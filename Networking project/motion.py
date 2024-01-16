from gpiozero import MotionSensor
import subprocess
import time
import os
import requests

#url = 'http://example.com/upload'
#auth = ('username', 'password')
# Set up motion sensor on GPIO2 (Pin 3)
pir = MotionSensor(4)
fileIter = 0

while True:
    pir.wait_for_motion()

    # Record a 10-second video using ffmpeg
    video_filename = f'video{fileIter}.mp4'
    image_filename = f'picture{fileIter}_taken.jpg'
    take_video = ['ffmpeg', '-f', 'video4linux2', '-input_format', 'mjpeg', '-video_size', '1920x1080', '-framerate', '30', '-i', '/dev/video0', '-t', '10', '-c:v', 'h264', '-preset', 'ultrafast', '-crf', '23', video_filename]
    take_picture = ['fswebcam','-r', '1920x1080', image_filename] 
    subprocess.call(take_video)

    image_path = os.path.join(os.getcwd(), image_filename)
    video_path = os.path.join(os.getcwd(), video_filename)
    #with open(image_path, 'rb') as image_file:
    #    files = {'file': (image_filename, image_file)}
    #    response = requests.post(url, auth=auth, files=files)
    #if response.status_code == 200:
    #    print('Video uploaded successfully')
    #else:
    #    print('Error uploading video: {}'.format(response.text))
    print('Motion detected! Video recorded')
    fileIter += 1
    time.sleep(2)