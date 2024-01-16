from PIL import Image
import os

# Function to convert an integer to binary string representation
def int_to_bin(n):
    return bin(n)[2:].zfill(8)

# Function to encode a message into an image using LSB steganography
def encode_message(image_path, message):
    image = Image.open(image_path)
    width, height = image.size

    # Check if the image has enough capacity to hold the message
    max_chars = width * height * 3 // 8
    if len(message) > max_chars:
        raise ValueError("Message is too long to be encoded in the image.")

    # Convert the message to binary representation
    message_bin = ''.join(int_to_bin(ord(c)) for c in message) + '11111111'

    # Encode the message into the image pixel values
    pixels = image.load()
    index = 0
    for x in range(width):
        for y in range(height):
            r, g, b = pixels[x, y]

            # Modify the least significant bit of each color channel
            if index < len(message_bin):
                r = (r & 0xFE) | int(message_bin[index])
                index += 1
            if index < len(message_bin):
                g = (g & 0xFE) | int(message_bin[index])
                index += 1
            if index < len(message_bin):
                b = (b & 0xFE) | int(message_bin[index])
                index += 1

            pixels[x, y] = (r, g, b)

    # Save the modified image with the encoded message
    root, ext = os.path.splitext(image_path)
    directory_path = os.path.dirname(root)
    basename_without_ext = os.path.splitext(os.path.basename(image_path))[0]
    output_path = directory_path + "/" + basename_without_ext + "_encoded" + ext 
    image.save(output_path)
    print(f"Message encoded in the image: {output_path}")

#image_path = 'original_image.png'
#message = "Hello, Steganography!"
#encode_message(image_path, message)
