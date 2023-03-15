import socket #for creating TCP socket connection
import os
import threading #for multithreading

IP = socket.gethostbyname(socket.gethostname()) #dynamically assigns hostname
PORT = 4455 #arbitrary port number that is not a basic port
ADDR = (IP, PORT)
BUFFER = 1024
FORMAT = "utf-8"
SERVER_DATA_PATH = "server_data"

def handle_list(connection):
    files = os.listdir(SERVER_DATA_PATH)
    dataToSend = "OK@"
    if len(files) == 0:
        dataToSend += "The server has no files in it.\n"
    else:
        dataToSend += "\n".join(file for file in files)
    connection.sendall(dataToSend.encode(FORMAT))

def handle_upload(connection, filename, filesize):
    with open(os.path.join(SERVER_DATA_PATH, filename), "wb") as file: #file writing in binary
        bytes_received = 0
        while bytes_received < filesize:
            chunk = connection.recv(BUFFER)
            if not chunk:
                break
            file.write(chunk)
            bytes_received += len(chunk)
        if bytes_received >= filesize:
            connection.sendall(f"OK@File: <{filename}> uploaded successfully".encode(FORMAT))
        else: #pretty redundant but just incase
            connection.sendall(f"OK@File failed to upload successfully".encode(FORMAT))     
    return 

def handle_download(connection,filename,filesize):
    toReplyData = f"YES@{filesize}"
    connection.sendall(toReplyData.encode(FORMAT))
    with open(os.path.join(SERVER_DATA_PATH, filename), "rb") as file: #read the file
        bytes_Sent = 0
        while bytes_Sent < filesize:
            packet = file.read(BUFFER)
            if not packet:
                break
            connection.sendall(packet)
            bytes_Sent += BUFFER
        if bytes_Sent >= filesize:
            gotMyData = connection.recv(BUFFER).decode(FORMAT) #don't send stuff until client gets all the data and replies
            gotMyData = gotMyData.split(" ")
            if gotMyData[0] == "RECEIVED":
                connection.send(f"OK@File {filename} successfully downloaded".encode(FORMAT))
            else:
                connection.send(f"OK@Something wrong occured, please try again".encode(FORMAT)) # remove return later, handle_download(connection, filename, filesize) #should never execute unless did not receive the data properly? which shouldn't happen
        else:
            gotMyData = connection.recv(BUFFER).decode(FORMAT)
            connection.send(f"OK@Something wrong occured, please try again".encode(FORMAT))
            return
        
def handle_delete(connection, fileToDelete):
    files = os.listdir(SERVER_DATA_PATH)
    if len(files) == 0:
        dataToSend += "The server has no files in it."
        connection.send(dataToSend.encode(FORMAT))
    else:
        if fileToDelete in files:
            filepath = os.path.join(SERVER_DATA_PATH, fileToDelete)
            os.remove(filepath) #ensures different operating systems can work for deletion
            dataToSend = f"OK@Successfully deleted file {fileToDelete}."
            connection.sendall(dataToSend.encode(FORMAT))
        else: #if fileToDelete is not in the server
            dataToSend = f"OK@The file does not exist in the server."
            connection.sendall(dataToSend.encode(FORMAT))

def handle_rename(connection, oldFileName, newFileName):
    files = os.listdir(SERVER_DATA_PATH)
    if len(files) == 0:
        dataToSend += "OK@The server has no files in it."
        connection.sendall(dataToSend.encode(FORMAT))
    else:
        if oldFileName in files:
            old_path = os.path.join(SERVER_DATA_PATH, oldFileName)
            new_path = os.path.join(SERVER_DATA_PATH, newFileName)
            os.rename(old_path, new_path)
            connection.sendall(f'OK@File {oldFileName} renamed successfully to {newFileName}'.encode(FORMAT))
        else:
            connection.sendall(f'OK@File {oldFileName} not found in server'.encode(FORMAT))

    
def handle(connection, addressOfClient):
    print(f'New connection {addressOfClient} is connected')
    connection.send("OK@Welcome to the INF1006 FTP client\nLIST          : List files\nUPLD file_name: Upload File\nDWLD file_name: Download file\nDELF file_name: Delete file\nRNTO file_name: Rename file\nQUIT          : Exit".encode(FORMAT))
    while True:
        data = connection.recv(BUFFER).decode(FORMAT)
        data = data.split(" ")
        cmd = data[0]
        if cmd == "LIST":
            handle_list(connection)

        elif cmd == "UPLD":
            files = os.listdir(SERVER_DATA_PATH)
            filename = data[1]
            filesize = int(data[2])
            if filename in files:
                connection.sendall("YES".encode(FORMAT)) #sends YES to client, then waits for override request
                reply = connection.recv(BUFFER).decode(FORMAT)
                reply = reply.split(" ")
                if reply[0] == "OVERRIDE":
                    handle_upload(connection, filename, filesize)               
                elif reply[0] == "PASS":
                    connection.send("OK@Did not override file".encode(FORMAT))
           
        elif cmd == "DWLD":
            #def handle_download(connection,filename,filesize):
            filename = data[1] #from the first message received by client
            files = os.listdir(SERVER_DATA_PATH)
            if filename not in files:
                connection.sendall("NO") #if not in file, break out
                replyFromClient = connection.recv(BUFFER).decode(FORMAT)
                connection.sendall("OK@File not found in server\n") #to get client out of receiving mode <-- might cause breakage, check later
            else:
                filepath = os.path.join(SERVER_DATA_PATH, filename)
                filesize = int(os.path.getsize(filepath))
                handle_download(connection, filename, filesize)
            
        elif cmd == "DELF":
            fileToDelete = data[1]
            handle_delete(connection, fileToDelete)
            
        elif cmd == "RNTO":
            old_name = data[1]
            new_name = data[2]
            handle_rename(connection, old_name, new_name)

        elif cmd == "QUIT":
            connection.send("DISCONNECTED@Disconnecting you from the server...".encode(FORMAT))
            break
        
        elif cmd == "ClientFileBad":
            filename = data[1]
            connection.sendall(f"OK@The file {filename} is not found!".encode(FORMAT))

        else:
            connection.sendall(f"OK@Invalid command:'{cmd}'".encode(FORMAT))
    print(f'Disconnected from {addressOfClient}'.encode(FORMAT))


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