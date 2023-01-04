
import socket
import os
import glob
from time import sleep
from math import ceil
from getpass import getpass
import zlib
import zipfile

def help():
    print("\n\n...........Commands Menu.........\n\nhelp         >>    Help Menu.\ndir/ls       >>    List Files and Directories.\npwd          >>    Print Working Directoriy.\nupl          >>    Upload File.\ndwd          >>    Download File.\ncompress     >>    Compress File.\nquit         >>    Disconnect and Exit.\n\n")

def main():
    PORT = 65427
    HOST = '127.0.0.1' 
    s = socket.socket()
    s.connect((HOST, PORT))
    loginAttempts = 0
    while loginAttempts < 3:
        message = s.recv(2048).decode()
        print(message)
        
        username = input("Enter your username: ")
        s.send(username.encode())
        
        password = getpass(prompt = "Enter your password: ", stream = None)
        s.send(password.encode())
        
        answer = s.recv(2048).decode()
        
        if answer == 'correct':
            print("\n\nSuccessful login attempt!\nWelcome to Our FTP Server\n")
            help()
            while True:
                string = input("\nWating for Command :: ftp >> ")
                s.send(string.encode())

                if string == 'dir':   
                    x = s.recv(2048).decode()
                    print (x)

                elif string == 'help' :
                    help()

                elif string == 'ls':
                    x = s.recv(2048).decode()
                    print(x)

                elif string == 'pwd':
                    x = s.recv(2048).decode()
                    print(x)

                elif string[:4] == 'dwd ':
                    response = s.recv(2048).decode()
                    print(response + ' bytes')
                    if(response[:4] == 'file'):
                        filename = string[4:]
                        filesize = int(response[27:])
                        packetAmmount = ceil(filesize/2048)
                        if (os.path.isfile('new_' + filename)):
                            x = 1
                            while(os.path.isfile('new_' + str(x) + filename )):
                                x += 1
                            f = open('new_' + str(x) + filename, 'wb')

                        else:
                            f = open("new_" + filename, 'wb')
                        
                        for x in range (0, packetAmmount):
                            data = s.recv(2048)
                            f.write(data)
                        
                        f.close()
                        print("Download is complete")
                    else:
                        print("file does not exist...")
                
                elif string[:4] == 'upl ':
                    filename = string[4:]
                    if os.path.isfile(filename):
                        filesize = int(os.path.getsize(filename))
                        s.send(('true' + str(filesize)).encode())
                        with open(filename, 'rb') as f:
                            packetAmmount = ceil(filesize/2048)
                            for x in range(0, packetAmmount):
                                bytesToSend = f.read(2048)
                                s.send(bytesToSend)
                        print("file sent!")
                    else:
                        s.send('false'.encode())
                        print("file does not exist...")
                
                elif string [:9] == 'compress ':
                    x = s.recv(2048).decode()
                    print(x)

                elif string == 'quit':
                    loginAttempts = 4
                    break

        elif answer == 'disconnect':
            break
        loginAttempts += 1
    print("You have been disconnected...")

main()

