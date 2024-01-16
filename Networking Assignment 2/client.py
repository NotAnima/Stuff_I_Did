import socket
import os
import sys

IP = socket.gethostbyname(socket.gethostname()) #dynamically assigns hostname
#PORT = None #arbitrary port number that is not a basic port
#ADDR = (IP, PORT)
BUFFER = 1024
FORMAT = "utf-8"
CLIENT_DATA_PATH = "client_data"
RFC_List = ["212", "220", "221", "125", "225", "226", "426", "500", "200", "451", "550" ]#426 for no override #500 for invalid command 200 for "OK" #451 for some server error
#directory status (for list), service ready for connection ready, disconnecting from server, Data connection open, for file transfers, Data connection open, no transfer in progress (for overriding), after successful transfers
commands = ['LIST','UPLD','DWLD','DELF','RNTO','QUIT']
def handle_list(client):
    return client.sendall("LIST".encode(FORMAT))

def handle_upload(client, filename, filesize):
    with open(os.path.join(CLIENT_DATA_PATH, filename), "rb") as file: #file writing in binary
        bytes_Sent = 0
        while bytes_Sent < filesize:
            chunk = file.read(BUFFER)
            if not chunk:
                break
            client.sendall(chunk)
            bytes_Sent += BUFFER
        if bytes_Sent >= filesize:
            return
def handle_override(client, filename, filesize, userInput):
    if userInput.upper() == "Y":
        client.sendall("OVERRIDE".encode(FORMAT))
        with open(os.path.join(CLIENT_DATA_PATH, filename), "rb") as file: #file writing in binary
            bytes_Sent = 0
            while bytes_Sent < filesize:
                chunk = file.read(BUFFER)
                if not chunk:
                    break
                client.sendall(chunk)
                bytes_Sent += BUFFER
            if bytes_Sent >= filesize:
                return 
    else:
        client.sendall("PASS".encode(FORMAT))
        return

def handle_download(client, replyFromServer, filename):

    if replyFromServer[0] == "550": #server does not have this file
        client.sendall("200".encode(FORMAT))

    elif replyFromServer[0] == "225":
        filesize = int(replyFromServer[1])
        with open(os.path.join(CLIENT_DATA_PATH, filename), "wb") as file: #file writing in binary
            bytes_received = 0
            while bytes_received < filesize:
                chunk = client.recv(BUFFER)
                if not chunk:
                    break
                file.write(chunk)
                bytes_received += len(chunk)
            if bytes_received >= filesize:
                client.sendall("RECEIVED".encode(FORMAT)) #reply to gotMyData from server
            else:
                client.sendall("NO".encode(FORMAT))

def main():
    IP = input("Enter the IP Address of the server: ")
    PORT = int(input("Choose a port number not including 1-1023 which are basic ports: "))
    ADDR = (IP, PORT)
    try:
        client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        client.connect(ADDR)
        while True:
            data = client.recv(BUFFER).decode(FORMAT)
            cmd, message = data.split("@")
            if cmd in RFC_List:
                if cmd != "221":
                    print(cmd+ "\n" + message)
                else:
                    print(cmd+ "\n"  + message)
                    break
            else:
                print(message)
            data = input("> ")
            data = data.split(" ")
            cmd = data[0]

            if cmd == "LIST":
                handle_list(client)

            elif cmd == "QUIT":
                client.sendall("QUIT".encode(FORMAT))
            elif cmd == "UPLD": #at this point, server is still listening for a command
                files = os.listdir(CLIENT_DATA_PATH)
                filename = data[1]
                try:
                    if filename not in files:
                        raise FileNotFoundError
                    filepath = os.path.join(CLIENT_DATA_PATH, filename)
                    filesize = int(os.path.getsize(filepath))
                    dataToSend = f'{cmd} {filename} {filesize}' #sends the upload cmd, the filename to upload, and the filesize it wants to upload
                    client.sendall(dataToSend.encode(FORMAT)) #going to send you the command and the filename, check whether it exists for me, server will reply, then listen again
                    reply = client.recv(BUFFER).decode(FORMAT) #waiting for server to reply,
                    reply = reply.split(" ")
                    if reply[0] == "NO":#over here, server should be listening for data to be sent
                        handle_upload(client,filename,filesize)

                    elif reply[0] == "YES":
                        print("This file already exists, do you want to override it? Y/N")
                        userInput = input(">")
                        userInput = userInput.strip(" ")
                        handle_override(client,filename,filesize,userInput)

                except:
                    client.sendall(f"ClientFileBad {filename}".encode(FORMAT))
                    #print(f"The file {filename} is not found!")

            elif cmd == "DWLD":
                filename = data[1]
                dataToSend = f'{cmd} {filename}'.encode(FORMAT) #i want to download these files, help check if exists and then if exist, give me filesize
                client.sendall(dataToSend)
                reply = client.recv(BUFFER).decode(FORMAT)
                reply = reply.split("@")
                handle_download(client, reply, filename)

            elif cmd == "DELF":
                client.sendall(f'{cmd} {data[1]}'.encode(FORMAT)) #sends to server the delete command and the filename to delete

            elif cmd == "RNTO":
                client.sendall(f'{cmd} {data[1]} {data[2]}'.encode(FORMAT))

            else:
                client.sendall(cmd.encode(FORMAT))
    except:
        #if isinstance(socket.error):
            #print("Socket error connection")
        print(f"Could not make a connection to {ADDR}")
        return
    #print("#221 Disonnected from the server")
    client.close()

if __name__ == "__main__":
    main()