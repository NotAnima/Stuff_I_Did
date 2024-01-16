from varying_encoder import to_bin
from varying_decoder import bin_to_int
import os

def splitIntoBiteSize(payloadInBinary, bitsUsedToEncode):
    bitsPerChannel = []
    for i in range(0, len(payloadInBinary), bitsUsedToEncode): #from the 0th index in the payload, to the last, for every iteration, jump by the number of bitsToEncode
        bitsPerChannel.append(payloadInBinary[i:i + bitsUsedToEncode])

    if len(bitsPerChannel[-1]) % bitsUsedToEncode != 0:
        bitsPerChannel[-1] += '0' * (bitsUsedToEncode - len(bitsPerChannel[-1]) % bitsUsedToEncode)

    return bitsPerChannel

def getMDAT(filePath):
    with open(filePath, "rb") as mp4File:
        while True:
            boxSizeBytes = mp4File.read(4)
            if boxSizeBytes == b'':
                # Reached the end of the file without finding 'mdat' box
                return None
            
            boxSize = int.from_bytes(boxSizeBytes, byteorder = "big")
            boxType = mp4File.read(4).decode("utf-8")
            
            if boxType == "mdat":
                # Found 'mdat' box, return its position and size
                mdat_position = mp4File.tell()

                # If mdat position is greater than box size, then the metadata might be corrupted
                # Another method of calculating mdat size will be used instead
                if mdat_position > boxSize:
                    mp4File.read()
                    boxSize = mp4File.tell() - mdat_position
                return mp4File.tell(), boxSize
            else:
                # Skip to the next box
                mp4File.seek(boxSize - 8, 1)

def encodeVideo(absVideoPath, payload, bitUsedToEncode):
    #encodes a video file using lsb replacement
    #raises ValueError: if file format is not supported
    
    if absVideoPath.endswith(".mp4"):
        outputPath = encodeMp4(absVideoPath, payload, bitUsedToEncode)
        return outputPath
    else:
        raise ValueError("File format not supported.")
    
def decodeVideo(absVideoPath, bitUsedToEncode):
    #decodes a video file encoded using lsb replacement
    #raises ValueError: if file format is not supported
    
    if absVideoPath.endswith(".mp4"):
        return decodeMp4(absVideoPath, bitUsedToEncode)
    else:
        raise ValueError("File format not supported.")

def getRelativePath(absPathOfMp4):

    data = os.path.dirname(absPathOfMp4)
    return data

def encodeMp4(mp4AbsPath, payload, bitsUsedToEncode):

    relativePath = getRelativePath(mp4AbsPath)

    mdat_position, mdat_size = getMDAT(mp4AbsPath)

    with open(mp4AbsPath, "rb") as file:

        data = bytearray(file.read())

        payload = payload + "====="

        binary_payload = to_bin(payload) #from Ash's file

        binary_payload = splitIntoBiteSize(binary_payload, bitsUsedToEncode)

        requiredSamples = len(binary_payload)

        if requiredSamples > mdat_size:
            raise ValueError(f"Insufficient samples to hide the message.\nAudio samples: {mdat_size}\nRequired samples: {requiredSamples}")
        
        for i in range(mdat_position, mdat_position + requiredSamples): #starts encoding the bits AFTER the mdat position, considering to encode from before the mdat box ends
            data[i] = (data[i] & (0xFF << bitsUsedToEncode)) | int(binary_payload[i - mdat_position], 2)

        outputPath = os.path.join(relativePath, "encodedVideo.mp4")

        with open(outputPath, "wb") as encodedFile:
            encodedFile.write(data)

        return outputPath

def decodeMp4(encodedMp4Path, bitsUsedToEncode):

    mdat_position = getMDAT(encodedMp4Path)[0]
    
    with open(encodedMp4Path, "rb") as file:
        file = open(encodedMp4Path, 'rb')
        data = bytearray(file.read())
        file.close()


        payload = ''
        chr_bin = ''

        for i in range(mdat_position, len(data)):

            chr_bin += to_bin(data[i])[-bitsUsedToEncode:]

            # convert the binary string to a character when there are at least 8 bits
            if len(chr_bin) >= 8:
                payload += chr(int(chr_bin[:8], 2))
                chr_bin = chr_bin[8:]

            if payload.endswith("====="):
                break

        return payload[:-5]


#mp4File = input("Abs Path: ")
#payload = "only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
#encodeVideo(mp4File, payload, 6)
#encodedmp4File = input("2nd Abs Path")
#print(decodeVideo(encodedmp4File, 6))
