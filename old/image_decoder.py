from PIL import Image

# Function to convert a binary string to an integer
def bin_to_int(bin_str):
    return int(bin_str, 2)

# Function to decode the hidden message from an image using LSB steganography
def decode_message(image_path):
    image = Image.open(image_path)
    width, height = image.size

    # Extract the LSBs from the image pixel values
    pixels = image.load()
    message_bin = ''
    for x in range(width):
        for y in range(height):
            r, g, b = pixels[x, y]
            message_bin += str(r & 0x01)
            message_bin += str(g & 0x01)
            message_bin += str(b & 0x01)

    # Convert the binary message to text
    message = ''
    for i in range(0, len(message_bin), 8):
        byte = message_bin[i:i+8]
        if byte == '11111111':
            break
        message += chr(bin_to_int(byte))

    return message

#image_path = 'encoded_image.png'
#decoded_message = decode_message(image_path)
#print(f"Decoded message: {decoded_message}")
