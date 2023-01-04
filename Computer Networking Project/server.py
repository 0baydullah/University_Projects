import socket
import os
import glob
from math import ceil
from time import sleep
import zipfile
import zlib
import hashlib
import random
import struct



def compress(file):
    compressedFile = os.path.splitext(file)[0] + ".zip"
    fileToZip = zipfile.ZipFile(compressedFile, mode='w', compression=zipfile.ZIP_DEFLATED)
    fileToZip.write(file)
    fileToZip.close()

def main():
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    host = '127.0.0.1' 
    port = 65427
    username = "admin"
    password =  "admin"
    s.bind((host, port))
    s.listen()
    print(host)
    print("waiting for a connection...")
    conn, addr = s.accept()
    print(addr, "Has connected to the server.")
    print("connection has been established!\n\n\n___________FTP SERVER LISTENING_____________\n")
    
    for x in range(3, 0, -1):
        answer = "\nPlease print your username and password to log into the server. You have " + str(x) + " more tries."
        conn.send(answer.encode())
        
        attemptedUsername = conn.recv(2048).decode()
        print(attemptedUsername)
        
        attemptedPassword = conn.recv(2048).decode()
        print(attemptedPassword)
        
        if attemptedUsername == username and attemptedPassword == password:
            sleep(0.1)
            conn.send("correct".encode())
            
            while True:
                recieveData = conn.recv(2048).decode()
                print(recieveData)

                if recieveData == 'dir':
                    x = os.listdir()
                    y = 0
                    for file in x:
                        if os.path.isfile(file):
                            string = 'F: ' + str(file) 
                            x[y] = string
                        else:
                            string = 'D: ' + str(file)
                            x[y] = string
                        y += 1    
                    x.sort()
                    string = '\n'.join(x)
                    conn.send(string.encode())
                
                elif recieveData == 'ls':
                    x = os.listdir()
                    y = 0
                    x.sort()
                    for file in x:
                        if os.path.isfile(file):
                            string = 'F: ' + str(file) 
                            x[y] = string
                        else:
                            string = 'D: ' + str(file)
                            x[y] = string
                        y += 1
                    string = '\n'.join(x)
                    conn.send(string.encode())
       
                elif recieveData[:3] == 'pwd':
                    string = str(os.getcwd())
                    conn.send(string.encode())

                elif recieveData[:4] == 'dwd ':
                    filename = recieveData[4:]
                    if os.path.isfile(filename):
                        conn.send(("file exists with a size of " + str(os.path.getsize(filename))).encode())
                        filesize = int(os.path.getsize(filename))
                        with open(filename, 'rb') as f:
                            packetAmmount = ceil(filesize/2048)
                            for x in range(0, packetAmmount):
                                bytesToSend = f.read(2048)
                                conn.send(bytesToSend)

                    else: 
                        conn.send("Error while reading the file!".encode())
                
                elif recieveData[:4] == 'upl ':
                    response = conn.recv(2048).decode()
                    if(response[:4] == 'true'):
                        filesize = int(response[4:])
                        packetAmmount = ceil(filesize/2048)
                        filename = recieveData[4:]
                        if (os.path.isfile('new_' + filename)):
                            x = 1
                            while(os.path.isfile('new_' + str(x) + filename )):
                                x += 1
                            f = open('new_' + str(x) + filename, 'wb')

                        else:
                            f = open("new_" + filename, 'wb')
                        
                        for x in range (0, packetAmmount):
                            data = conn.recv(2048)
                            f.write(data)
                        
                        f.close()
                
                elif recieveData[:9] == 'compress ':
                    fileToCompress = recieveData[9:]
                    compress(fileToCompress)
                    conn.send("file specified compressed on server side.".encode())

                elif recieveData == 'quit':
                    x = -1
                    break
            print("disconnected...")
            break
        else:
            sleep(0.1)
            conn.send("incorrect".encode())
    
    print("disconnected...")
main()


