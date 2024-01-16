import cv2, numpy as np
from PIL import Image
import binascii

def bin_to_int(bin_str):
    return int(bin_str, 2)

def to_bin(data):
    if isinstance(data, str):
        return ''.join([format(ord(i),"08b") for i in data])
    elif isinstance(data, bytes) or isinstance(data,np.ndarray):
        return [format(i,"08b") for i in data]
    elif isinstance(data, int) or isinstance(data, np.uint8):
        return format(data,"08b")
    else:
        raise TypeError("Type not supported")

def KMPdoesItContain(haystack, needle): 
        haystack = haystack.upper()
        needle = needle.upper()
        if needle == "":
            return False
        # Will only ever have the same amount of states in the LPS array = to the length of the pattern to look for
        lps = [0]*len(needle) 
        prevLPS = 0
        i = 1
        while i < len(needle):
            if needle[i] == needle[prevLPS]:
                lps[i] = prevLPS + 1
                prevLPS += 1
                i += 1
            elif prevLPS == 0:
                lps[i] = 0
                i += 1
            else:
                prevLPS = lps[prevLPS-1]
        # Everything above this is setting up the LPS, longest prefix suffix array which tells us which 'state' index to go to
        i = 0 # Pointer for text to search in
        j = 0 # Pointer for pattern
        while i < len(haystack):
            if haystack[i] == needle[j]:
                i, j = i + 1, j+1 #iIf theres a match, increment both pointers
            else:
                if j == 0: # If first letter in pattern doesn't already match, go to the next letter of the busStopName, because j cannot be < 0
                    i += 1
                else:
                    j = lps[j-1]
            if j == len(needle): 
                indexOfOccurence = i - len(needle) #
                return True
        return False # Result not found
    
def decode_message(image_path, bit):
    image = Image.open(image_path).convert('RGB')
    w, h = image.size

    pixels = image.load()
    binary_data = ""
    for x in range(w):
        for y in range(h):
            r, g, b = pixels[x, y]

            r = to_bin(r)
            payload_r = r[-bit:]
            g = to_bin(g)
            payload_g = g[-bit:]
            b = to_bin(b)
            payload_b = b[-bit:]

            binary_data += payload_r + payload_g + payload_b
            if KMPdoesItContain(binary_data[-40-bit*3:],"0011110100111101001111010011110100111101"):
                break
        if KMPdoesItContain(binary_data[-40-bit*3:],"0011110100111101001111010011110100111101"):
            break     
    message = ''       
    for i in range(0, len(binary_data), 8):
        byte = binary_data[i:i+8]
        message += chr(bin_to_int(byte))
        if message[-5:] == '=====':
            break
    if message == "=====":
        return ''
    return message[:-5]