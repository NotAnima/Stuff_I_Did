import socket
import os
import sys

IP = socket.gethostbyname(socket.gethostname()) #dynamically assigns hostname
PORT = 4455 #arbitrary port number that is not a basic port
ADDR = (IP, PORT)
BUFFER = 1024
FORMAT = "utf-8"
CLIENT_DATA_PATH = "client_data"

def main():
    client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    client.connect(ADDR)
    while True:
        data = client.recv(BUFFER).decode(FORMAT)
        cmd, message = data.split("@")

        if cmd == "OK":
            print(message)

        elif cmd == "DISCONNECTED":
            print(message)
            break

        data = input("> ")
        data = data.split(" ")
        cmd = data[0]

        if cmd == "LIST":
            client.send(cmd.encode(FORMAT))

        elif cmd == "QUIT":
            client.send(cmd.encode(FORMAT))

        elif cmd == "UPLD":
            filepath = CLIENT_DATA_PATH + '/' + data[1]
            #filepath = os.path.basename(filepath)

            with open(filepath, 'rb') as file:
    # get the size of the file
                filesize = os.path.getsize(filepath)
                filename = os.path.basename(filepath)
                client.send(f'{cmd} {filename} {filesize}'.encode(FORMAT))
                bytesSent = 0
                while True:
                    if filesize<BUFFER:
                        client.send(file.read(filesize))
                        bytesSent += filesize
                        break
                    else:
                        packet = file.read(BUFFER)
                        if not packet:
                            break #end of file
                        client.sendall(packet)
                        bytesSent += BUFFER
                print("Bytes sent: "+str(bytesSent))
                  
        elif cmd == "DWLD":
            client.send(f'{cmd} {data[1]}'.encode(FORMAT))
            data = client.recv(BUFFER).decode(FORMAT)
            data = data.split("@")
            filename = data[0]
            filesize = ""
            stringFileSize = data[1]
            for char in stringFileSize:
                if char.isdigit():
                    filesize += char
            filesize = int(filesize)
            with open(os.path.join(CLIENT_DATA_PATH, filename), 'wb') as file:
                bytes_received = 0
                while bytes_received < filesize:
                    chunk = client.recv(BUFFER)
                    if not chunk:
                        break
                    file.write(chunk)
                    bytes_received += len(chunk)
                if bytes_received >= filesize:
                    dataToSend = f"SUCCESS Successfully Downloaded File: <{filename}>"
                    client.send(dataToSend.encode(FORMAT))
                #if bytes_received >= filesize:
                    #print(f"Successfully Downloaded file: <{filename}>")
                

        elif cmd == "DELF":
            client.send(f'{cmd} {data[1]}'.encode(FORMAT))

        elif cmd == "RNTO":
            client.send(f'{cmd} {data[1]} {data[2]}'.encode(FORMAT))

        else:
            client.send(cmd.encode(FORMAT))
    print("Disonnected from the server")
    client.close()

if __name__ == "__main__":
    main()