import cv2, numpy as np
from PIL import Image
import os

def to_bin(data):
    if isinstance(data, str):
        return ''.join([format(ord(i),"08b") for i in data])
    elif isinstance(data, bytes) or isinstance(data,np.ndarray):
        return [format(i,"08b") for i in data]
    elif isinstance(data, int) or isinstance(data, np.uint8):
        return format(data,"08b")
    else:
        raise TypeError("Type not supported")
    
def encode_message(image_path, payload, bit):
    image = Image.open(image_path).convert('RGB')
    w, h = image.size

    max_chars = w * h * 3 // 8
    payload += '====='
    if len(payload) > max_chars:
        raise ValueError("Message is too long to be encoded in the image.")
    payload = to_bin(payload)

    remainder = len(payload) % bit
    if remainder > 0:
        payload += '0' * (bit - remainder)

    payloadLength = len (payload)

    pixels = image.load()
    startindex = 0
    endindex = bit
    for x in range(w):
        if startindex >= payloadLength:
            break
        for y in range(h):
            r, g, b = pixels[x, y]
            #RED
            if endindex > len(payload):
                endindex = len(payload)
            if startindex < len(payload):
                r = to_bin(r)
                replacement_bits = payload[startindex:endindex]
                r = r[:-(bit)] + replacement_bits
                r = int(r, 2)
                startindex += bit
                endindex += bit
            #GREEN
            if endindex > len(payload):
                endindex = len(payload)
            if startindex < len(payload):
                g = to_bin(g)
                replacement_bits = payload[startindex:endindex]
                g = g[:-(bit)] + replacement_bits
                g = int(g, 2)
                startindex += bit
                endindex += bit
            #BLUE
            if endindex > len(payload):
                endindex = len(payload)
            if startindex < len(payload):
                b = to_bin(b)
                replacement_bits = (payload[startindex:endindex])
                b = b[:-(bit)] + replacement_bits
                b = int(b, 2)
                startindex += bit
                endindex += bit

            pixels[x, y] = (r, g, b)

    root, ext = os.path.splitext(image_path)
    directory_path = os.path.dirname(root)
    basename_without_ext = os.path.splitext(os.path.basename(image_path))[0]
    outfileName = basename_without_ext+"_encoded"+ext
    output_path = os.path.join(directory_path, outfileName)
    #output_path = directory_path + "/" + basename_without_ext + "_encoded" + ext #changed to os.path.join() because if manually type "/", it crashes on posix systems
    image.save(output_path)
    print(f"Message encoded in the image: {output_path}")
    return output_path 
