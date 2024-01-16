import tkinter as tk
import os
import vlc
from tkinter import filedialog
from PIL import Image, ImageTk, ImageDraw
from tkinterdnd2 import DND_FILES, TkinterDnD
import varying_encoder, varying_decoder
import mdatAVmethod 
import mp3Steg
import textstego

class Application():
    def __init__(self):
        self.cover_file_path = ''
        self.payload_file_path = ''
        self.window = TkinterDnD.Tk()
        self.window.title('App')
        self.window.geometry('950x1000')
        self.window.config(bg='light grey')

        # Main frame
        frame = tk.Frame(self.window, bg='light grey')
        frame.grid(row=0, column=0)
        frame.pack(pady=10, expand=True)
        
        # Cover File selected and method frame
        cover_file_frame = tk.Frame(frame, bg='light grey')
        cover_file_frame.grid(row=1, column=0, columnspan=2)
        coverfile_label = tk.Label(cover_file_frame, text='Please select the cover file below:', font=('Arial', 14), bg='light grey')
        coverfile_label.grid(row=0, column=0, columnspan=2)

        dndCoverFileButton = tk.Button(cover_file_frame, text="Select or Drag a file here!", borderwidth=2, width=40, height=2, bg='lightblue', fg='black', font=('Arial', 14), command=self.select_cover_file)
        dndCoverFileButton.grid(row=1, column=0)
        dndCoverFileButton.drop_target_register(DND_FILES)
        dndCoverFileButton.dnd_bind('<<Drop>>', self.on_cover_drop)

        self.coverFileLabel = tk.Label(cover_file_frame, text='Current cover file chosen: None', font=('Arial', 14), bg='light grey')
        self.coverFileLabel.grid(row=2, column=0)

        # Option frame
        options_frame = tk.Frame(frame, bg='light grey')
        options_frame.grid(row=2, column=0, columnspan=2)
        method_label = tk.Label(options_frame, text='Please choose to encode/decode: ', font=('Arial', 14), bg='light grey')
        method_label.grid(row=0, column=0)
        self.selected_option = tk.StringVar(value="Encode")
        rb1 = tk.Radiobutton(options_frame, text="Encode", variable=self.selected_option, value="Encode", command=self.update_button, font=('Arial', 14), bg='light grey')
        rb2 = tk.Radiobutton(options_frame, text="Decode", variable=self.selected_option, value="Decode", command=self.update_button, font=('Arial', 14), bg='light grey')
        rb1.grid(row=0, column=1)
        rb2.grid(row=0, column=2)

        # Payload frame etc
        payload_frame = tk.Frame(frame, bg='light grey')
        payload_frame.grid(row=3,column=0, columnspan=2)
        payload_label = tk.Label(payload_frame, text='Please select the payload file below:', font=('Arial', 14), bg='light grey')
        payload_label.grid(row=0, column=0)
        #self.payload_text = tk.Text(payload_frame, width=40, height=5, font=('Arial', 14))
        #self.payload_text.grid(row=1, column=0, pady=5)

        # Payload select file frame
        dndPayloadFileButton = tk.Button(payload_frame, text="Select or Drag a file here!", borderwidth=2, width=40, height=2, bg='lightblue', fg='black', font=('Arial', 14), command=self.select_payload_file)
        dndPayloadFileButton.grid(row=1, column=0)
        dndPayloadFileButton.drop_target_register(DND_FILES)
        dndPayloadFileButton.dnd_bind('<<Drop>>', self.on_payload_drop)
        
        payload_file_label_frame = tk.Frame(payload_frame, bg='light grey')
        payload_file_label_frame.grid(row=2, column=0, columnspan=2)
        self.payloadFileLabel = tk.Label(payload_file_label_frame, text='Current payload file chosen: None', font=('Arial', 14), bg='light grey')
        self.payloadFileLabel.grid(row=2, column=0)

        self.bit_var = tk.IntVar()
        bit_label = tk.Label(payload_frame, text='Please select number of bits:', font=('Arial', 14), bg='light grey')
        bit_label.grid(row=3, column=0)
        bit_slider = tk.Scale(payload_frame, from_=1, to=6, orient=tk.HORIZONTAL, variable=self.bit_var, width=15, length=150, sliderlength=20, font=('Arial', 14), bg='light grey')
        bit_slider.grid(row=4,column=0)

        # Save frame
        save_frame = tk.Frame(frame, bg='light grey')
        save_frame.grid(row=5, column=0, columnspan=2)
        self.save_button = tk.Button(save_frame, text=self.selected_option.get(), command=self.run_function, bg='light blue', font=('Arial', 14))
        self.save_button.grid(row=0, column=0, pady=10)

        # Output frame
        output_frame = tk.Frame(save_frame, bg='light grey')
        output_frame.grid(row=1, column=0)

        scrollbar = tk.Scrollbar(output_frame, orient=tk.VERTICAL)
        scrollbar.pack(side=tk.RIGHT, fill=tk.Y)

        self.output_text = tk.Text(output_frame, width=50, height=5, font=('Arial', 14), bg='light grey', wrap=tk.WORD, yscrollcommand=scrollbar.set)
        self.output_text.pack(side=tk.LEFT, fill=tk.BOTH)

        scrollbar.config(command=self.output_text.yview)

        #Preview frame
        self.preview_frame = tk.Frame(frame, bg='light grey')
        self.preview_frame.grid(row=6, column=0)

        self.instance = vlc.Instance()
        self.player = self.instance.media_player_new()
        self.output_player = self.instance.media_player_new()

        self.embed = tk.Frame(self.preview_frame, bg="light grey", width=300, height=300)
        self.embed.grid(row=1, column=0)

        self.player_pause_btn = tk.Button(self.preview_frame, bg="light grey", text="\u23F8 Pause", font=("Arial", 14), command=lambda: self.play_pause(self.player, self.player_pause_btn))
        self.player_pause_btn.pack_forget()

        self.arrow_video_label = tk.Label(self.preview_frame, bg="light grey")
        self.arrow_video_label.grid(row=1, column=1)

        self.output_embed = tk.Frame(self.preview_frame, bg="light grey", width=300, height=300)
        self.output_embed.grid(row=1, column=2)

        self.output_player_pause_btn = tk.Button(self.preview_frame, bg="light grey", text="\u23F8 Pause", font=("Arial", 14), command=lambda: self.play_pause(self.output_player, self.output_player_pause_btn))
        self.output_player_pause_btn.pack_forget()

        self.image_label = tk.Label(self.preview_frame, bg="light grey")
        self.image_label.grid(row=0, column=0)
        
        self.arrow_image_label = tk.Label(self.preview_frame, bg="light grey")
        self.arrow_image_label.grid(row=0, column=1)

        self.output_image_label = tk.Label(self.preview_frame, bg="light grey")
        self.output_image_label.grid(row=0, column=2)

    def get_method(self):
        method = self.selected_option.get()
        return method

    def get_text(self):
        if self.payload_file_path == '':
            return
        with open(self.payload_file_path, 'r') as file:
            text = file.read() 
        return text

    def get_bit(self):
        bit = self.bit_var.get()
        return bit

    def select_cover_file(self):
        self.cover_file_path = filedialog.askopenfilename()
        basename = os.path.basename(self.cover_file_path)
        root, ext = os.path.splitext(self.cover_file_path)
        self.update_label(basename, 'cover', ext)

    def select_payload_file(self):
        self.payload_file_path = filedialog.askopenfilename()
        root, ext = os.path.splitext(self.payload_file_path)
        if ext != '.txt':
            self.payloadFileLabel['text'] = 'Invalid input file type given, please choose a .txt file.'
            return
        basename = os.path.basename(self.payload_file_path)
        self.update_label(basename, 'payload', '.txt')

    def on_payload_drop(self,event):
        dropped_data = event.data
        dropped_data = dropped_data.replace("{","").replace("}","")
        self.payload_file_path = dropped_data.strip()
        basename = os.path.basename(self.payload_file_path)
        self.update_label(basename, 'payload', '.txt')
        
    def on_cover_drop(self,event):
        dropped_data = event.data
        dropped_data = dropped_data.replace("{","").replace("}","")
        self.cover_file_path = dropped_data.strip()
        root, ext = os.path.splitext(self.cover_file_path)
        basename = os.path.basename(self.cover_file_path)
        self.update_label(basename, 'cover', ext)

    def update_label(self, text, label, ext):
        match label:
            case 'cover':
                if text == '':
                    self.coverFileLabel['text'] = 'Current cover file chosen: None'
                    return
                self.coverFileLabel['text'] = f"Current cover file chosen: {text}"
                if ext == '.png' or ext == '.bmp':
                    self.display_image(self.cover_file_path, 'cover')
                if ext == '.mp4':
                    self.display_video(self.cover_file_path, 'cover')
                    self.player_pause_btn.grid(row=2,column=0)
            case 'payload':
                if text == '':
                    self.payloadFileLabel['text'] = 'Current payload file chosen: None'
                    return
                self.payloadFileLabel['text'] = f"Current payload file chosen: {text}"

    def update_button(self):
        self.save_button['text'] = self.selected_option.get() 

    def get_info(self):
        info = [self.cover_file_path, self.get_method(), self.get_text(), self.get_bit()]
        return info

    def display_image(self, image_path, label):
        self.player.stop()
        self.player.set_media(None)
        self.output_player.stop()
        self.output_player.set_media(None)
        self.arrow_video_label.config(image="")
        image = Image.open(image_path)
        image = image.resize((300,300))
        photo = ImageTk.PhotoImage(image)
        if label == 'cover':
            self.image_label.config(image=photo)
            self.image_label.image = photo
            return
        elif label == 'encoded':
            self.output_image_label.config(image=photo)
            self.output_image_label.image = photo
            return
        else:
            self.arrow_image_label.config(image=photo)
            self.arrow_image_label.image = photo

    def display_video(self, video_path, label):
        self.image_label.config(image="")
        self.output_image_label.config(image="")
        self.arrow_image_label.config(image="")
        if label == 'cover':
            self.player.set_mrl(video_path)
            self.player.set_hwnd(self.embed.winfo_id())
            self.player.audio_set_volume(50)
            self.player.play()
            return
        elif label == 'encoded':
            self.output_player.set_mrl(video_path)
            self.output_player.set_hwnd(self.output_embed.winfo_id())
            self.output_player.audio_set_volume(50)
            self.output_player.play()
            return
        else:
            image = Image.open(video_path)
            image = image.resize((300,300))
            photo = ImageTk.PhotoImage(image)
            self.arrow_video_label.config(image=photo)
            self.arrow_video_label.image = photo

    def play_pause(self, player, button):
        if player.get_state() == vlc.State.Playing:
            player.pause()
            button.config(text="\u25B6 Play")
        else:
            player.play()
            button.config(text="\u23F8 Pause")

    def run_function(self):
        cover_file, method, payload, bits = self.get_info()
        root, ext = os.path.splitext(self.cover_file_path)
        if (method == "Encode"):
            if ext == '.png' or ext == '.bmp':
                try:
                    output_path = varying_encoder.encode_message(cover_file,payload,bits)
                    self.display_image(output_path, 'encoded')
                    self.display_image("../Images/arrow.png", 'arrow')
                except ValueError:
                    self.output_text.delete("1.0", tk.END)
                    self.output_text.insert(tk.END, 'Payload is too long to be encoded in the image.') 
                    return
            elif ext == '.txt' or ext == '.docx':
                output_path = textstego.hide_text(cover_file, payload, ext)
            elif ext == '.mp4':
                try:
                    output_path = mdatAVmethod.encodeVideo(cover_file, payload, bits)
                    self.display_video(output_path, 'encoded')
                    self.display_video("../Images/arrow.png", 'arrow')
                    self.output_player_pause_btn.grid(row=2, column=2)
                except ValueError:
                    self.output_text.delete("1.0", tk.END)
                    self.output_text.insert(tk.END, 'Payload is too long to be encoded in the image.') 
                    return
            elif ext == '.mp3':
                try:
                    output_path = mp3Steg.mp3Encode(cover_file, payload, bits)
                except ValueError:
                    self.output_text.delete("1.0", tk.END)
                    self.output_text.insert(tk.END, 'Payload is too long to be encoded in the image.') 
                    return
            else:
                self.coverFileLabel['text'] = 'Invalid input file type given, please choose another file.'
                return
            self.output_text.delete("1.0", tk.END)
            self.output_text.insert(tk.END, 'Message successfully hidden in ' + output_path) 
        else:
            if ext == '.png' or ext == '.bmp':
                decoded_msg = varying_decoder.decode_message(cover_file,bits)
            elif ext == '.txt' or ext == '.docx':
                decoded_msg = textstego.extract_text(cover_file, ext)
            elif ext == '.mp4':
                decoded_msg = mdatAVmethod.decodeVideo(cover_file, bits)
            elif ext == '.mp3':
                decoded_msg = mp3Steg.mp3Decode(cover_file, bits)
            else:
                self.output_text.delete("1.0", tk.END)
                self.output_text.insert(tk.END, 'Invalid input file type given, please choose another file.')
                return
            try:
                with open('result.txt', 'w') as file:
                    file.write(decoded_msg)
            except UnicodeEncodeError:
                print('gibberish')
            self.output_text.delete("1.0", tk.END)
            self.output_text.insert(tk.END, decoded_msg) 

app = Application()

app.window.mainloop()
