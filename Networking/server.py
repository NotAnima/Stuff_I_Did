import socket #for creating TCP socket connection
import os
import threading #for multithreading

IP = socket.gethostbyname(socket.gethostname()) #dynamically assigns hostname
PORT = 4455 #arbitrary port number that is not a basic port
ADDR = (IP, PORT)
BUFFER = 1024
FORMAT = "utf-8"
SERVER_DATA_PATH = "server_data"

def handle(connection, addressOfClient):
    print(f'New connection {addressOfClient} is connected')
    connection.send("OK@Welcome to the INF1006 FTP client\nLIST          : List files\nUPLD file_name: Upload File\nDWLD file_name: Download file\nDELF file_name: Delete file\nRNTO file_name: Rename file\nQUIT          : Exit".encode(FORMAT))
    while True:
        data = connection.recv(BUFFER).decode(FORMAT)
        data = data.split(" ")
        cmd = data[0]
        if cmd == "LIST":
            files = os.listdir(SERVER_DATA_PATH)
            dataToSend = "OK@"
            if len(files) == 0:
                dataToSend += "The server has no files in it"
            else:
                dataToSend += "\n".join(file for file in files)

            connection.send(dataToSend.encode(FORMAT))
        elif cmd == "SUCCESS":
            connection.send(f"OK@{data[1]} {data[2]} {data[3]} {data[4]}".encode(FORMAT))
        elif cmd == "FAILURE":
            pass
        elif cmd == "UPLD":
            filename = data[1]
            filesize = ""
            stringFileSize = data[2]
            for char in stringFileSize:
                if char.isdigit():
                    filesize += char
            filesize = int(filesize)
            with open(os.path.join(SERVER_DATA_PATH, filename), "wb") as file: #file writing in binary
                bytes_received = 0
                while bytes_received < filesize:
                    chunk = connection.recv(BUFFER)
                    if not chunk:
                        break
                    file.write(chunk)
                    bytes_received += len(chunk)
                if bytes_received >= filesize:
                    connection.send(f"OK@File: <{filename}> uploaded successfully".encode(FORMAT))


        elif cmd == "DWLD":
            filepath = SERVER_DATA_PATH + '/' + data[1]
            with open(filepath, 'rb') as file:
                file_size = os.path.getsize(filepath)
                filename = os.path.basename(filepath)
                connection.send(f'{filename}@{file_size}'.encode(FORMAT))
                bytesSent = 0
                while True:
                    if file_size<BUFFER:
                        #padding = BUFFER - file_size
                        #pad = b'\x32'*padding
                        #padded_data = file.read(file_size) + pad
                        #connection.send(padded_data)
                        connection.send(file.read(BUFFER))
                        bytesSent += file_size
                        break
                    else:
                        packet = file.read(BUFFER)
                        if not packet:
                            break #end of file
                        connection.sendall(packet)
                        bytesSent += BUFFER

                    #connection.send(f"OK@File {filename} successfully downloaded".encode(FORMAT))
        elif cmd == "DELF":
            files = os.listdir(SERVER_DATA_PATH)
            dataToSend = "OK@"
            filename = data[1]
            if len(files) == 0:
                dataToSend += "The server has no files in it"
                connection.send(dataToSend.encode(FORMAT))
            else:
                if filename in files:
                    filepath = os.path.join(SERVER_DATA_PATH, filename)
                    os.remove(filepath) #ensures different operating systems can work for deletion
                    dataToSend += f"Successfully deleted file {filename}"
                    connection.send(dataToSend.encode(FORMAT))
                else:
                    connection.send("OK@The file does not exist in the server.".encode(FORMAT))

        elif cmd == "RNTO":
            old_name = data[1]
            new_name = data[2]
            dataToSend = rename_file(old_name, new_name)
            connection.second(dataToSend.encode(FORMAT))

        elif cmd == "QUIT":
            connection.send("DISCONNECTED@Disconnecting you from the server...".encode(FORMAT))
            break

        else:
            connection.send(f"OK@Invalid command:'{cmd}'".encode(FORMAT))
    print(f'Disconnected from {addressOfClient}'.encode(FORMAT))

def rename_file(old_name, new_name):
    old_path = os.path.join(SERVER_DATA_PATH, old_name)
    new_path = os.path.join(SERVER_DATA_PATH, new_name)
    try:
        os.rename(old_path, new_path)
        return "OK@File renamed successfully".encode(FORMAT)
    except FileNotFoundError:
        return "ERROR@File not found".encode(FORMAT)
    except FileExistsError:
        return "ERROR@A file with the new name already exists".encode(FORMAT)
    except:
        return "ERROR@An error occurred while renaming the file".encode(FORMAT)

def main():
    print("Server is starting up")
    server = socket.socket(socket.AF_INET, socket.SOCK_STREAM) #INET is for ipv4, SOCK_STREAM is for TCP connection
    server.bind(ADDR) #binds the specific IP address and port
    server.listen() #waiting for client to connect
    try:
        print("Server is now listening for clients on port" + str(ADDR))
        while True:
            connection, address = server.accept() #accepts the client
            thread = threading.Thread(target = handle, args = (connection, address))
            thread.start()
    finally:
        connection.close()

if __name__ == "__main__":
    main()