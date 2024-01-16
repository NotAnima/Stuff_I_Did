from PIL import Image

def lsb_replace(pixel, bits, num_bits):
    # Convert the pixel value to a binary string
    pixel_bin = format(pixel, '08b')
    # Modify the least significant bits according to the data bits
    pixel_bin = pixel_bin[:-num_bits] + bits
    # Convert the binary string back to an integer
    pixel_new = int(pixel_bin, 2)
    return pixel_new

def encode_lsb_gif(gif_path, data, num_bits):
    # Open file
    gif = Image.open(gif_path)
    frames = []
    
    # Iterate over each frame
    for frame in range(gif.n_frames):
        gif.seek(frame)
        frame_data = gif.convert("RGBA")
        frame_pixels = list(frame_data.getdata())

        # Encode the data into each pixel
        encoded_pixels = []
        for pixel in frame_pixels:
            r, g, b, a = pixel

            # Get the bits from the data
            bits = data[:num_bits]
            data = data[num_bits:]

            # Replacement on the alpha channel
            alpha_new = lsb_replace(a, bits, num_bits)

            # Modify pixel with the new alpha value
            encoded_pixel = (r, g, b, alpha_new)
            encoded_pixels.append(encoded_pixel)

        # Create a new frame
        encoded_frame = Image.new("RGBA", frame_data.size)
        encoded_frame.putdata(encoded_pixels)
        frames.append(encoded_frame)

    frames[0].save("encoded.gif", format="GIF", save_all=True, append_images=frames[1:], loop=0, duration=gif.info['duration'])

    print("LSB encoding completed. Encoded GIF saved as 'encoded.gif'.")

gif_path = "original.gif"
data_to_hide = "PLS HELP"
num_bits = 2

# Data to a binary string
binary_data = ''.join(format(ord(char), '08b') for char in data_to_hide)

encode_lsb_gif(gif_path, binary_data, num_bits)
