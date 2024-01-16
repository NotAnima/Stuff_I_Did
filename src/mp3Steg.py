import os
from varying_encoder import to_bin
from varying_decoder import bin_to_int
from mdatAVmethod import getRelativePath
from mdatAVmethod import splitIntoBiteSize

def mp3Encode(filepath, payload, numbits):
    relativePath = getRelativePath(filepath)
    
    fileName = os.path.basename(filepath)
    
    fileName = fileName.split(".")
    
    origName = fileName[0]
    
    ext = fileName[1]
    if ext != "mp3":
        raise TypeError("File format not supported")
    
    fileName = origName+"_encoded."+ext

    data = None

    with open(filepath, 'rb') as file:
        data = bytearray(file.read())
    
    payload += "====="
    
    #for _ in range(len(rawBits)):
    #    actualBits += rawBits[_]
    
    #rawBits = actualBits

    payloadBits = to_bin(payload)

    payloadBits = splitIntoBiteSize(payloadBits, numbits)

    remainder = len(payload) % numbits

    if remainder > 0:
        payload += '0' * (numbits - remainder)

    payloadLength = len (payloadBits)

    if payloadLength > (len(data)*8):
        raise ValueError("Message is too long to be encoded in the image.")

    currentIndex = 0
    
    endindex = 8
        
        #insertionBits = payloadBits[currentIndex:currentIndex + numbits] #will give the bits to replace
        #
        #rawBits = rawBits[currentIndex:endindex-numbits] + insertionBits + rawBits[endindex:] #100011 + 11 + the rest of the bits
        
    for i in range(0, payloadLength): #starts encoding the bits AFTER the mdat position, considering to encode from before the mdat box ends

        data[i] = (data[i] & (0xFF << numbits)) | int(payloadBits[i], 2)

    
    #save the file

    outputFile = os.path.join(relativePath, fileName)
    
    with open(outputFile, "wb") as out:
        out.write(data)

    return outputFile

def mp3Decode(filePath, numbits):
    
    relativePath = getRelativePath(filePath)
    
    fileName = os.path.basename(filePath)
    
    fileName = fileName.split(".")
    
    origName = fileName[0]
    
    ext = fileName[1]
    
    if ext != "mp3":
        raise TypeError("File format not supported")
    
    data = None

    with open(filePath, 'rb') as file:
        data = bytearray(file.read())

    payload = ''
    chr_bin = ''
    startIndex = 0
    endIndex = 8
    for i in range(0, len(data)):

            chr_bin += to_bin(data[i])[-numbits:]

            # convert the binary string to a character when there are at least 8 bits
            if len(chr_bin) >= 8:
                payload += chr(int(chr_bin[:8], 2))
                chr_bin = chr_bin[8:]

            if payload.endswith("====="):
                break

    return payload[:-5]

# filepath = input("Abs: ")
# payload = "hello"
# #payload = "lorem ipsum etclorem ipsum etclorem ipsum etclorem ipsum etclorem ipsum etc"
# mp3Encode(filepath, payload, 3)
# print("end of encoding")
# stegPath = input("Abs: ")
# payloadReturn = mp3Decode(stegPath, 3)
# print(payloadReturn)