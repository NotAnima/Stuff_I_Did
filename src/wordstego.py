import os

def hide_text(cover_file, payload, num_lsb):
    with open(cover_file, 'r') as cover:
        cover_text = cover.read()

    # Convert payload to binary
    payload_bin = ''.join(format(ord(c), '08b') for c in payload)

    # Ensure payload fits within the cover text
    if len(payload_bin) > len(cover_text):
        print("Error: Payload too large for cover file.")
        return

    # Modify the LSBs of each character in the cover text
    stego_text = ''
    payload_index = 0
    for char in cover_text:
        if payload_index < len(payload_bin):
            # Modify LSBs of the character
            char_bin = format(ord(char), '08b')
            modified_bin = char_bin[:-(num_lsb)] + payload_bin[payload_index:payload_index + num_lsb]
            modified_char = chr(int(modified_bin, 2))
            stego_text += modified_char
            payload_index += num_lsb
        else:
            stego_text += char

    root, ext = os.path.splitext(cover_file)
    directory_path = os.path.dirname(root)
    basename_without_ext = os.path.splitext(os.path.basename(cover_file))[0]
    outfileName = basename_without_ext+"_encoded"+ext
    stego_file = os.path.join(directory_path, outfileName)

    with open(stego_file, 'w') as stego:
        stego.write(stego_text)

    print("Text payload hidden successfully in the cover file.")


def extract_text(stego_file, num_lsb):
    with open(stego_file, 'r') as stego:
        stego_text = stego.read()

    extracted_payload = ''
    for char in stego_text:
        char_bin = format(ord(char), '08b')
        extracted_bits = char_bin[-num_lsb:]
        extracted_payload += extracted_bits

    # Convert binary payload to text
    extracted_text = ''
    for i in range(0, len(extracted_payload), 8):
        byte = extracted_payload[i:i + 8]
        extracted_text += chr(int(byte, 2))

    return extracted_text


# # Example usage
# payload = "This is a hidden message."
# cover_file = "Text/cover.txt"
# stego_file = "Text/stego.txt"
# num_lsb = 1  # Select the number of LSBs to use from bits 0 - 5

# # Hide the text payload in the cover file
# hide_text(payload, cover_file, stego_file, num_lsb)

# # Extract the hidden text from the stego file
# extracted_text = extract_text(stego_file, num_lsb)
# print("Extracted text:", extracted_text)
