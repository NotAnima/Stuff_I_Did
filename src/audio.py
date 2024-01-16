from pydub import AudioSegment
import ffmpeg
import os
from varying_encoder import to_bin
from varying_decoder import bin_to_int
import numpy as np
import array

def encode_audio(input_file, output_file, secret_message):
    audio = AudioSegment.from_file(input_file, format="wav")
    tempoutput = os.path.join(os.path.dirname(output_file),"temp.wav")
    file_handle = audio.export(tempoutput, format="wav")
    audio = AudioSegment.from_file(tempoutput, format="wav")
    #audioFrameRate = audio.frame_rate
    #bytesPerSample = audio.sample_width
    #lengthOfAudioFile = len(audio)
    print("passed audio line")
    # Convert secret message to binary
    secret_bits = to_bin(secret_message+"=====")

    # Check if secret message can fit in the audio
    if len(secret_bits) > int(audio.frame_count()):
        raise ValueError("Secret message is too long to fit in the audio file.")

    # Encode secret message into audio frames
    frames = audio

    for i, bit in enumerate(secret_bits):
        frame = audio.get_frame(i)
        frame = bytearray(frame)
        frame[-1] = (frame[-1] & 0xFE) | int(bit)  # Store the bit in the last bit of the frame
        frames = frames._spawn(frames.raw_data + bytes(frame))

    print("passed enumerate for loop")
    # Export the modified audio as an encoded file
    frames.export(output_file, format='wav')
    print("passed exporting")

def decode_audio(encoded_file):
    encoded_audio = AudioSegment.from_file(encoded_file, format="wav")
    print(int(encoded_audio.frame_count()))
    # Decode secret message from audio frames
    secret_bits = ""
    for i in range(int(encoded_audio.frame_count())):
        frame = encoded_audio.get_frame(i)
        byte = frame[-1]
        secret_bits += str(byte | 0x00)
        print(secret_bits)
        if (len(secret_bits))>100:
            break 
    #hidden_byte = ''
    #for i, byte in enumerate(encoded_audio):
    #    # transform to a string of bits
    #    hidden_bit = '{:08b}'.format(byte)
    #    # get the last bit
    #    hidden_bit = hidden_bit[-1]
    #    # add to the string
    #    hidden_byte += hidden_bit
    ## Convert binary secret message to text
    secret_message = ""
    for i in range(0, len(secret_bits), 8):
        byte = secret_bits[i:i+8]
        secret_message += chr(int(byte, 2))
        if secret_message.endswith("====="):
            break
    return secret_message

#def decode_audio(encoded_file):
#    with open(encoded_file, 'rb') as file:
#        encoded_data = file.read()
#
#    secret_bits = ""
#    byte_index = 0
#    bit_index = 0
#    delimiterInBin = to_bin("=====")
#    # Iterate over the encoded data
#    while byte_index < len(encoded_data) and not secret_bits.endswith(delimiterInBin):
#        byte = encoded_data[byte_index]
#        bit = (byte >> bit_index) & 0x01
#        secret_bits += str(bit)
#
#        bit_index += 1
#        if bit_index == 8:
#            byte_index += 1
#            bit_index = 0
#
#    # Convert binary secret message to text
#    secret_message = ""
#    for i in range(0, len(secret_bits) - 5, 8):
#        byte = secret_bits[i:i + 8]
#        secret_message += chr(int(byte, 2))
#
#    return secret_message

payload = "Testing here"
inputFile = input("File here: ")
#sound = AudioSegment.from_file(inputFile, format="mp3")
basename = os.path.basename(inputFile)
print(basename)
parentDir = os.path.dirname(inputFile)
print(parentDir)
outputFile = os.path.join(parentDir, "encoded.wav")
print(outputFile)
#file_handle = sound.export(outputFile, format="mp3")
encode_audio(inputFile, outputFile, payload)
input = input("File here to decode: ")
print(decode_audio(input))