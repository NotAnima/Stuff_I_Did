import os
import socket
SERVER_DATA_PATH = "server_data"
global passive_socket

def send_response(conn, code, message):
    conn.sendall(f'{code} {message}\r\n'.encode('utf-8'))

def handle_command(connection, command):
    global passive_socket

    cmd = command.split()
    if not cmd:
        send_response(connection, 500, 'Invalid command')
        return
    
    if cmd[0].upper() == 'QUIT':
        send_response(connection, 221, 'Goodbye')
        connection.close()
        return True
    
    if cmd[0].upper() == 'USER':
        send_response(connection, 331, 'User name okay, need password')
        return
    
    if cmd[0].upper() == 'PASS':
        send_response(connection, 230, 'Password okay, logged in')
        return
    
    if cmd[0].upper() == 'PWD':
        send_response(connection, 257, f'"{os.getcwd()}" is the current directory')
        return
    
    if cmd[0].upper() == 'TYPE':
        send_response(connection, 200, 'Type set to binary')
        return
    
    if cmd[0].upper() == 'LIST':
        # Get the data connection from the client
        if not passive_socket:
            passive_socket = handle_PASV(connection)
            if not passive_socket:
                return   
        files = os.listdir(SERVER_DATA_PATH)
        # Send the list of files in the current directory
        response = '\r\\'.join(files)
        send_data(connection, response.encode('utf-8'))
        send_response(connection, 226, 'Directory listing sent')
        return
    
    if cmd[0].upper() == 'PASV':
        handle_PASV(connection)
        return
    
    if cmd[0].upper() == 'AUTH':
        send_response(connection, 234, 'Security data exchange complete')
        return
    
    if cmd[0].upper() == 'STOR':
        if len(cmd) < 2:
            send_response(connection, 501, 'Syntax error in parameters or arguments')
            return
        
        filename = cmd[1]
        with open(filename, 'wb') as f:
            while True:
                data = connection.recv(1024)
                if not data:
                    break
                f.write(data)
        
        send_response(connection, 226, 'Transfer complete')
        return
    
    if cmd[0].upper() == 'RETR':
        if len(cmd) < 2:
            send_response(connection, 501, 'Syntax error in parameters or arguments')
            return
        
        filename = cmd[1]
        if not os.path.exists(filename):
            send_response(connection, 550, 'File not found')
            return
        
        with open(filename, 'rb') as f:
            while True:
                data = f.read(1024)
                if not data:
                    break
                connection.sendall(data)
        
        send_response(connection, 226, 'Transfer complete')
        return
    
    if cmd[0].upper() == 'RNFR':
        if len(cmd) < 2:
            send_response(connection, 501, 'Syntax error in parameters or arguments')
            return
        
        filename = cmd[1]
        if not os.path.exists(filename):
            send_response(connection, 550, 'File not found')
            return
        
        connection.filename = filename
        send_response(connection, 350, 'Ready for RNTO')
        return
    
    if cmd[0].upper() == 'RNTO':
        if not hasattr(connection, 'filename'):
            send_response(connection, 503, 'Bad sequence of commands')
            return
        
        new_filename = cmd[1]
        os.rename(connection.filename, new_filename)
        del connection.filename
        
        send_response(connection, 250, 'Rename successful')
        return
    
    if cmd[0].upper() == 'DELE':
        if len(cmd) < 2:
            send_response(connection, 501, 'Syntax error in parameters or arguments')
            return
        
        filename = cmd[1]
        if not os.path.exists(filename):
            send_response(connection, 550, 'File not found')
            return
        
        os.remove(filename)
        send_response(connection, 250, 'File deleted')
        return
    
    send_response(connection, 502, 'Command not implemented')

def handle_PASV(conn):
    global passive_socket
    ip_address = socket.gethostbyname(socket.gethostname())
    port = 0
    passive_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    passive_socket.bind((ip_address, port))
    passive_socket.listen()
    port = passive_socket.getsockname()[1]
    response = f'Entering passive mode ({",".join(ip_address.split("."))},{int(port/256)},{port%256}).'
    send_response(conn, 227, response)


def send_data(conn, data):
    # Send the length of the data as a 4-byte big-endian integer
    conn.send(len(data).to_bytes(4, byteorder='big'))
    
    # Send the data itself
    conn.sendall(data)

def main():
    PORT = int(input("Choose a port number not including 1-1023 which are basic ports: "))
    IP = socket.gethostbyname(socket.gethostname())
    ADDR = (IP, PORT)
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
        s.bind(ADDR)
        s.listen()
        print(f'Server listening on {IP}:{PORT}')
        
        while True:
            conn, addr = s.accept()
            print(f'Connected by {addr}')
            
            send_response(conn, 220, 'FTP server ready')
            
            while True:
                data = conn.recv(1024).decode('utf-8')
                if not data:
                    break
                
                print(f'Received: {data.strip()}')
                
                if handle_command(conn, data.strip()):
                    break
    
if __name__ == '__main__':
    main()