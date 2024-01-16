import os
import ffmpeg as ffmpeg
from moviepy.audio.io.AudioFileClip import AudioFileClip
from moviepy.video.io.ImageSequenceClip import ImageSequenceClip
from moviepy.video.io.VideoFileClip import VideoFileClip
import moviepy.editor as mv
import numpy as np
import pandas as pd
import varying_encoder as ve
import varying_decoder as vd
import cv2
import tempfile
import math
from os import path

def to_bin(data):
    if isinstance(data, str):
        return ''.join([format(ord(i),"08b") for i in data])
    elif isinstance(data, bytes) or isinstance(data,np.ndarray):
        return [format(i,"08b") for i in data]
    elif isinstance(data, int) or isinstance(data, np.uint8):
        return format(data,"08b")
    else:
       raise TypeError("Type not supported")
    
def convert_frames_to_video(tempFolderHoldingPngs, fps):
    """Converts all frames to a video"""
    

    extension = "_encoded.png" #can be replace in others jpeg
    lengthExt = len(extension) # the length is 4

    # 0 to -4 in the folder, the -4 you delete off the from the extension/ then this will ilterate and get all the values of the files. 0-839
    listOfFrames = [img[:] for img in os.listdir(tempFolderHoldingPngs.name) if img.endswith(extension)]
    listOfFrames.sort(key=lambda x: int(''.join(filter(str.isdigit, x))))
    #pick = img.split(extension)
    #outputFile = os.path.join(tempFolderHoldingPngs, pick[0])
    newFrameslist = [f"{os.path.join(tempFolderHoldingPngs.name,img)}" for img in listOfFrames] # tidy up the frames. and rearrange it nicely.
    video_object = ImageSequenceClip(newFrameslist, fps=fps) #can change the fps based on the video
    return video_object

def combine_audio_video(video_object, audio_object, base_filename):
    """Combines an audio and a video object together"""
    with_audio = video_object.set_audio(audio_object)
    with_audio.write_videofile(filename=f'{base_filename}_combined.mp4')

def extractFramesFpsAudio(temp_dir, videoFile):
    # Create a temporary directory to store the frames
    frame_files = []
    # Open the MP4 file
    video = cv2.VideoCapture(videoFile)
    # Read and extract frames until there are no more frames
    success, image = video.read()
    frame_count = 0
    while success:
        # Save the frame as an image file in the temporary directory
        frame_file = f"{temp_dir.name}/frame_{frame_count}.png"
        cv2.imwrite(frame_file, image)
        frame_files.append(frame_file)
        success, image = video.read()
        frame_count += 1
    fps = video.get(cv2.CAP_PROP_FPS)
    video.release()
    return frame_files, fps

# Function to insert a message into an image
def insert(absPathOfImage, payload, outputPath, bitsUsedToEncode):
    # Constants for bitwise operations
    highBits = 256 - (1 << bitsUsedToEncode)
    lowBits = (1 << bitsUsedToEncode) - 1

    # Number of bits needed to store a single byte
    bytesPerByte = math.ceil(8 / bitsUsedToEncode)

    # Flag to indicate the end of the secret message
    terminationSeq = '====='

    # Read the image
    img = cv2.imread(absPathOfImage, cv2.IMREAD_ANYCOLOR)

    # Save the original shape of the image to restore later
    originalShape = img.shape

    # Calculate the maximum number of bytes that can be hidden in the image
    max_bytes = originalShape[0] * originalShape[1] // bytesPerByte

    # Encode the message with its length and the flag
    payload = '{}{}'.format(payload, terminationSeq)

    # Check if the message fits within the capacity of the image
    assert max_bytes >= len(payload), "Message greater than capacity:{}".format(max_bytes)

    # Flatten the image data to process pixel values
    data = np.reshape(img, -1)

    # Embed each character of the message into the pixel values
    for (id, val) in enumerate(payload):
        hiding(data[id * bytesPerByte: (id + 1) * bytesPerByte], val, highBits, lowBits, bitsUsedToEncode)

    # Reshape the modified data back to the original shape
    img = np.reshape(data, originalShape)

    # Create a new filename for the modified image
    filename = outputPath

    # Save the modified image
    cv2.imwrite(filename, img)

    #return filename
def hiding(block, data, highBits, lowBits, bitsUsedToEncode):
    # Encode the given data into the block of pixel values using bitwise operations

    # Convert the character to its Unicode code
    data = ord(data)

    # Encode the data into the block by modifying the least significant bits
    for id in range(len(block)):
        # Clear the least significant bits of the block
        block[id] &= highBits

        # Set the least significant bits of the block with the encoded data

        block[id] |= (data >> (bitsUsedToEncode * id)) & lowBits

def extractAudio(originalVideo, inputPath):
    video = VideoFileClip(originalVideo)
    audio = video.audio
    finalAudioPath = os.path.join(inputPath, 'tempAudioFile.wav')
    audio.write_audiofile(finalAudioPath)
    return finalAudioPath

def putImagesTogether(temp_dir, fps, outputPath, audioAbsPath):
    encodedImagesArray = []
    filesAvailable = os.listdir(temp_dir.name)
    for fileToAppend in filesAvailable:
        if fileToAppend.endswith("_encoded.png"):
            encodedImagesArray.append(os.path.join(temp_dir.name, fileToAppend))
    encodedImagesArray.sort(key=lambda x: int(''.join(filter(str.isdigit, x))))
    clip = ImageSequenceClip(encodedImagesArray, fps=fps)
    audio = AudioFileClip(audioAbsPath)
    clip = clip.set_audio(audio)
    clip.write_videofile(outputPath)

def encode(inputPath, payload, bitsUsedToEncode, fileName):
    absPath = os.path.join(inputPath, fileName) #the drag and dropped directly returns the absPath
    temp_dir = tempfile.TemporaryDirectory()
    image_array, fps = extractFramesFpsAudio(temp_dir, absPath)
    #find out the payload split per image in the video
    totalNumberOfFrames = len(image_array)
    payloadIndex = 0
    payloadSizeInBits = len(to_bin(payload))
    payloadSplitPerImage = math.ceil(payloadSizeInBits/totalNumberOfFrames)
    for i, imagePath in enumerate(image_array):
        outputPath = os.path.join(temp_dir.name, f"frame{i}_encoded.png")
        if i == totalNumberOfFrames:
            insert(imagePath, payload[payloadIndex:], outputPath, bitsUsedToEncode)
            #ve.encode_message(imagePath, payload[payloadIndex:], bitsUsedToEncode)
        else:
            #ve.encode_message(imagePath, payload[payloadIndex:payloadIndex+payloadSplitPerImage], bitsUsedToEncode)
            insert(imagePath, payload[payloadIndex:payloadIndex+payloadSplitPerImage], outputPath, bitsUsedToEncode)

        payloadIndex += payloadSplitPerImage
    #after this loop ^ all the encoded images should appear in the temp folder
    outputPath = os.path.join(inputPath, f"encoded{fileName}") #preserve the orignal filename, can add .mp4 if needed
    audioFilePath = extractAudio(absPath, inputPath)
    #videoObject = convert_frames_to_video(temp_dir, fps)
    #audioObject = AudioFileClip(audioFilePath)
    #combine_audio_video(videoObject, audioObject, "finalCombined.mp4")
    putImagesTogether(temp_dir, fps, outputPath, audioFilePath)

    #with open(outputPath) as videoWithoutAudio:
     #   addAudio(videoWithoutAudio, audioFile, outputPath)
    os.remove(audioFilePath)
    temp_dir.cleanup()

def extract(path, bits):
    low_bits = (1 << bits) - 1

    # Number of bits needed to store a single byte
    bytes_per_byte = math.ceil(8 / bits)

    # Flag to indicate the start of the secret message
    terminationSeq = '====='

    # Read the image
    img = cv2.imread(path, cv2.IMREAD_ANYCOLOR)

    # Flatten the image data to process pixel values
    data = np.reshape(img, -1)

    # Total number of pixels in the image
    total = data.shape[0]

    # Variable to store the extracted secret message
    res = ''
    idx = 0

    # Decode the message length
    while idx < total // bytes_per_byte:
        ch = uncover(data[idx * bytes_per_byte: (idx + 1) * bytes_per_byte], low_bits, bits)
        idx += 1
        if len(res)>=5:
            if res[-5:] == '=====':
                break
        res += ch

    # Calculate the end index of the secret message
    end = int(res) + idx

    # Check if the end index is within the bounds of the image data
    assert end <= total // bytes_per_byte, "Input image isn't correct."

    # Variable to store the decoded secret message
    secret = ''

    # Decode the secret message
    while idx < end:
        secret += uncover(data[idx * bytes_per_byte: (idx + 1) * bytes_per_byte], low_bits, bits)
        idx += 1

    # Return the extracted secret message
    return secret

def uncover(block, lowBits, bitUsedToEncode):
    # Decode the given block of pixel values into a character

    val = 0
    for id in range(len(block)):
        val |= (block[id] & lowBits) << (id * bitUsedToEncode)

    return chr(val)

def decode(inputPath, encodedVideoName, bitsUsedToEncode):
    absPath = os.path.join(inputPath, encodedVideoName)
    temp_dir = tempfile.TemporaryDirectory()
    image_array, fps = extractFramesFpsAudio(temp_dir, absPath)
    finalMsg = ''
    for currentImage in image_array:
        #msg = vd.decode_message(currentImage, bitsUsedToEncode)
        msg = extract(currentImage, bitsUsedToEncode)
        if msg == '':
            break
        finalMsg += msg
    temp_dir.cleanup()
    return finalMsg

def bin_to_int(bin_str):
    return int(bin_str, 2)

def writeOutToText(message, outputPath):
    with open(outputPath, "w") as file:
        file.write(message)

def main():
    inputPath = input("File path here: ")
    files = os.listdir(inputPath)
    files = files[0]
    payload = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
    encode(inputPath, payload, 2, files)
    files = os.listdir(inputPath)
    for file in files:
        if file.startswith("encoded"):
            files = file
            break
    decode(inputPath, files, 2)
if __name__ == '__main__':
    main()

#payload += payload*len(payload) #longer payload to test
#for file in files: #don't use this loop in the actual GUI portion, just take the singular file event upload
#    video = None
#    audio = None
#    fps = None
#    originalExtension = None
#    absPath = os.path.join(inputPath, file) #combines the filename with the absolute file inclusive of the file extension, but if absolute path to file is given, don't need this line
#    originalExtension = file.split(".")
#    originalName = originalExtension[0] #preserves the original name
#    originalExtension = originalExtension[1] #preserves the original video extension type
#    (video, audio, fps) = splitAudioVisual(absPath) #returns a triple for the essential information needed to create the new file
#    newVideoFile = f"{originalName}Steg.{originalExtension}"
#    outputPath = os.path.join(inputPath, newVideoFile) 
#    extractFrames(absPath)
#    #encode(video, payload, 2) #after running through this, the global video variable should be adjusted to whatever encode ran it through and is the "newFrames"
#    createVideo(video, fps, audio, outputPath, originalExtension) #call this function and it returns a compressed video (I've been trying to disable the compression)
#    imageHeight, imageWidth, imageRGB = np.shape(video[0])
#    #render_lossless_video(video, outputPath,imageHeight, imageWidth, fps, audio)
#    stegVideo = None
#    absPath = os.path.join(inputPath, newVideoFile)
#    (stegVideo, audio, fps) = splitAudioVisual(absPath)
#    outputPath = os.path.join(inputPath, "hiddenMessage.txt")
#    message = decode(stegVideo, 2) #match with the encode
#for file in files:
#    bitsUsedToEncode = 2
#    absPath = os.path.join(inputPath, file) #the drag and dropped directly returns the absPath
#    temp_dir = tempfile.TemporaryDirectory()
#    image_array, fps = extractFramesFpsAudio(temp_dir, absPath)
#    #find out the payload split per image in the video
#    totalNumberOfFrames = len(image_array)
#    payloadIndex = 0
#    payloadSizeInBits = len(to_bin(payload))
#    payloadSplitPerImage = math.ceil(payloadSizeInBits/totalNumberOfFrames)
#
#    for i, imagePath in enumerate(image_array):
#        if i == totalNumberOfFrames:
#            ve.encode_message(imagePath, payload[payloadIndex:], bitsUsedToEncode)
#        else:
#            ve.encode_message(imagePath, payload[payloadIndex:payloadIndex+payloadSplitPerImage], bitsUsedToEncode)
#        payloadIndex += payloadSplitPerImage
#    #after this loop ^ all the encoded images should appear in the temp folder
#
#    outputPath = os.path.join(inputPath, f"encoded{file}") #preserve the orignal filename, can add .mp4 if needed
#    audioFile = extractAudio(absPath, inputPath)
#    putImagesTogether(temp_dir, fps, outputPath, audioFile)
#    #with open(outputPath) as videoWithoutAudio:
#     #   addAudio(videoWithoutAudio, audioFile, outputPath)
#    os.remove(audioFile)
#    temp_dir.cleanup()
#def decode(stegVideo, bitsUsedToEncode):
#    hiddenMessageInBin = ''
#    try:
#        for frame in stegVideo: #for every image
#            print(np.shape(frame))
#            imageRow, imageColumn, imageRGB = np.shape(frame)
#            for row in range(imageRow):
#                for column in range(imageColumn):
#                    rgb_Array = [to_bin(frame[row][column][0]), to_bin(frame[row][column][1]), to_bin(frame[row][column][2])]
#                    for currentColor in range(len(rgb_Array)): #for each red green and blue
#                        if len(hiddenMessageInBin)>=40:
#                            if hiddenMessageInBin[-40:] == "0011110100111101001111010011110100111101": #exit condition
#                                break
#                        hiddenMessageInBin += rgb_Array[currentColor][-bitsUsedToEncode:]
#        message = ''       
#        for i in range(0, len(hiddenMessageInBin), 8):
#            byte = hiddenMessageInBin[i:i+8]
#            message += chr(bin_to_int(byte))
#            if message[-5:] == "=====":
#                break
#        return message
# 
#    except Exception as e:
#        raise Exception("Something went wrong")

#def encode(video, payload, bitsUsedToEncode):
#    totalFrames, heightPerFrame, widthPerFrame, rgbPerFrame = np.shape(video)
#    totalBytesInVideo = totalFrames * heightPerFrame * widthPerFrame * rgbPerFrame #for every byte, can store one
#    payloadBits = to_bin(payload + '=====')
#    lengthOfPayload = len(payloadBits)
#    newFrames = []
#    if lengthOfPayload > totalBytesInVideo:
#        raise ValueError("Message is too long to be encoded into the visuals.")
#    try:
#        payloadIndex = 0
#        currentImage = 0
#        leftoverBits = len(payloadBits)%bitsUsedToEncode #gives the amount of remaining amount of bits left to encode that is left out 
#        if leftoverBits > 0:
#            payload += '0' * (bitsUsedToEncode - leftoverBits)
#        for frame in video: #gets the current image of the video frame as an array which contains 1920*1080 pixels. Where each pixel is a rgbarray = [1,2,3]
#            imageRow, imageColumn, imageRGB = np.shape(frame) #break statements are really lazy but it works to speed up, if conditions are cheap in assembly technically
#            for row in range(imageRow):
#                if lengthOfPayload-leftoverBits <= payloadIndex: #have successfully inserted all the bits
#                    break
#                for column in range(imageColumn):
#                    if lengthOfPayload-leftoverBits <= payloadIndex: #have successfully inserted all the bits
#                        break
#                    rgb_Array = [to_bin(frame[row][column][0]), to_bin(frame[row][column][1]), to_bin(frame[row][column][2])] #get the RGB as bits
#                    for currentColor in range(3): #0 is red, 1 is green, 2 is blue
#                        if lengthOfPayload-leftoverBits <= payloadIndex: #have successfully inserted all the bits
#                            break
#                        insertionLoad = payloadBits[payloadIndex:payloadIndex+bitsUsedToEncode]
#                        rgb_Array[currentColor] = rgb_Array[currentColor][:8-bitsUsedToEncode] + insertionLoad
#                        payloadIndex += bitsUsedToEncode
#
#                    rgb_Array = [int(rgb_Array[0],2), int(rgb_Array[1],2), int(rgb_Array[2],2)] #turns the rgb Bit format back into the pixel values in decimal
#                    for currentColor in range(3): #replacing the original pixel with the new pixel
#                        video[currentImage][row][column][currentColor] = np.uint8(rgb_Array[currentColor])#for every pixel in the current image, replace the rgb values
#            newFrames.append(video[currentImage])
#            if lengthOfPayload-leftoverBits <= payloadIndex: #have successfully inserted all the bits
#                video = [newFrames] + video[len(newFrames):]
#                break
#            currentImage += 1
#
#
#    except Exception as e:
#        raise Exception("Something went wrong")

 #def render_lossless_video(image_array, output_file, widthOfVideo, heightOfVideo, frames, audioFile):
#    for i, image in enumerate(image_array):
#        image_path = f'image{i}.png'
#        image.save(image_path)
#    command = f'ffmpeg -y -framerate 30 -i image_%d.png -i "{audioFile}" -c:v libx264 -c:a aac -pix_fmt yuv420p -shortest "{output_file}"'
#    audio_pipe = io.BytesID(audioFile)
#    subprocess.call(command,stdin=audio_pipe, shell=True)
#    print('Video rendering completed.')

#def createVideo(newFrames, fpsOfOriginal, audioOfOriginal, outputPath, extension):
#    steganographicVideo = mv.ImageSequenceClip(newFrames, fps=fpsOfOriginal)
#    #steganographicVideo = steganographicVideo.set_audio(audioOfOriginal)
#    if extension == "mp4": # almost compressionless
#        steganographicVideo.write_videofile(outputPath, codec='libx264', audio_codec="aac", ffmpeg_params = ["-crf", "0"])
#        #steganographicVideo.write_videofile(outputPath, ffmpeg_params = ["-crf", "1"])
#        #subprocess(f'ffmpeg -i {inputPath} -c:v copy -c:a copy -qscale:v 0 {outputPath}')
#    elif extension == "webm": # looks like utter garbage but for some reason takes a long ass time to write out
#        steganographicVideo.write_videofile(outputPath)
#    else: # will consider to add more codec formats if it even works, it took me a long time to get mp4 to work
#        raise TypeError("Type not supported: Please use mp4 or webm")
#
#    return "Video Successfully written out"

#def splitAudioVisual(fileAbsPath):
#    originalVideo = mv.VideoFileClip(fileAbsPath)
#    clip = originalVideo.subclip(0)
#    rate = clip.fps
#    audio = originalVideo.audio
#    frames = []
#    for frame in originalVideo.iter_frames():
#        frames.append(np.array(frame))
#    print(audio)
#    return (frames, audio, rate)
#
