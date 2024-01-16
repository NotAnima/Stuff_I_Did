import tkinter as tk
from tkinter import ttk
import os
from tkinter import filedialog
from PIL import Image, ImageTk, ImageDraw
from tkinterdnd2 import DND_FILES, TkinterDnD
from tkVideoPlayer import TkinterVideo
import varying_encoder, varying_decoder
import mdatAVmethod 
import textstego

class Application():
    def __init__(self):
        self.cover_file_path = ''
        self.payload_file_path = ''
        self.window = TkinterDnD.Tk()
        self.window.title('INF2005 ACW1')
        self.window.geometry('1920x1080')
        self.window.config(bg='#333333')

        # Select file and DND frame
        frame = tk.Frame(self.window, bg='#333333')
        frame.pack(pady=5)
        coverfile_frame = tk.Frame(frame, bg='#333333')
        coverfile_frame.grid(row=0, column=0)
        coverfile_label = tk.Label(coverfile_frame, text='Please select the cover file or stego object below:', font=('Arial', 14), bg='#333333', fg="#ffffff")
        coverfile_label.grid(row=0, column=0)
        dndCoverFileButton = tk.Button(coverfile_frame, text="Select or Drag a file here!", relief=tk.SUNKEN, borderwidth=2, width=40, height=5, bg='#564ae7', fg='#ffffff', font=('Arial', 14), command=self.select_cover_file)
        dndCoverFileButton.grid(row=1, column=0)
        dndCoverFileButton.drop_target_register(DND_FILES)
        dndCoverFileButton.dnd_bind('<<Drop>>', self.on_cover_drop)

        self.coverFileLabel = tk.Label(coverfile_frame, text='Current cover file chosen: None', font=('Arial', 14), bg='#333333')
        self.coverFileLabel.grid(row=2, column=0)

        self.image_label = tk.Label(coverfile_frame, bg='#333333')
        self.image_label.grid(row=3, column=0)

        # Cover File selected and method frame
        bit_label_frame = tk.Frame(frame, bg='#333333')
        bit_label_frame.grid(row=0, column=1, columnspan=2)
        self.bit_var = tk.IntVar()
        bit_label = tk.Label(bit_label_frame, text='Please select number of bits:', font=('Arial', 14), bg='#333333')
        bit_label.grid(row=1, column=0)
        bit_slider = tk.Scale(bit_label_frame, from_=1, to=6, orient=tk.HORIZONTAL, variable=self.bit_var, width=15, length=150, sliderlength=20, font=('Arial', 14), bg='#333333')
        bit_slider.grid(row=2,column=0)


        # Payload and bit frame
        payload_frame = tk.Frame(frame, bg='#333333')
        payload_frame.grid(row=0,column=3, columnspan=2)
        payload_label = tk.Label(payload_frame, text='Please select the payload file below:', font=('Arial', 14), bg='#333333')
        payload_label.grid(row=0, column=0)

        # Payload select file frame
        dndPayloadFileButton = tk.Button(payload_frame, text="Select or Drag a file here!", relief=tk.SUNKEN, borderwidth=2, width=50, height=5, bg='#564ae7', fg='#333333', font=('Arial', 14), command=self.select_payload_file)
        dndPayloadFileButton.grid(row=1, column=0)
        dndPayloadFileButton.drop_target_register(DND_FILES)
        dndPayloadFileButton.dnd_bind('<<Drop>>', self.on_payload_drop)
        
        # Payload File selected frame
        payload_file_label_frame = tk.Frame(payload_frame, bg='#333333')
        payload_file_label_frame.grid(row=2, column=0, columnspan=2)
        self.payloadFileLabel = tk.Label(payload_file_label_frame, text='Current payload file chosen: None', font=('Arial', 14), bg='#333333')
        self.payloadFileLabel.grid(row=2, column=0)
        
        # Option frame
        options_frame = tk.Frame(frame, bg='#333333')
        options_frame.grid(row=1, column=1, columnspan=2)
        method_label = tk.Label(options_frame, text='Please choose to encode/decode: ', font=('Arial', 14), bg='#333333')
        method_label.grid(row=0, column=0)
        self.selected_option = tk.StringVar(value="Encode")
        rb1 = tk.Radiobutton(options_frame, text="Encode", variable=self.selected_option, value="Encode", command=self.update_button, font=('Arial', 14), bg='#333333')
        rb2 = tk.Radiobutton(options_frame, text="Decode", variable=self.selected_option, value="Decode", command=self.update_button, font=('Arial', 14), bg='#333333')
        rb1.grid(row=0, column=1)
        rb2.grid(row=0, column=2)

        # Save frame
        save_frame = tk.Frame(frame, bg='#333333')
        save_frame.grid(row=2, column=1, columnspan=2)
        self.save_button = tk.Button(save_frame, text=self.selected_option.get(), command=self.run_function, bg='light blue', font=('Arial', 14))
        self.save_button.grid(row=0, column=0, pady=10)

        #Output frame
        output_frame = tk.Frame(save_frame, bg='#333333')
        output_frame.grid(row=1, column=0)

        scrollbar = tk.Scrollbar(output_frame, orient=tk.VERTICAL)
        scrollbar.pack(side=tk.RIGHT, fill=tk.Y)

        self.output_text = tk.Text(output_frame, width=50, height=10, font=('Arial', 14), bg='#333333', wrap=tk.WORD, yscrollcommand=scrollbar.set)
        self.output_text.pack(side=tk.LEFT, fill=tk.BOTH)

        scrollbar.config(command=self.output_text.yview)

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
        self.display_image(self.cover_file_path)
        self.update_label(basename, 'cover')

    def select_payload_file(self):
        self.payload_file_path = filedialog.askopenfilename()
        root, ext = os.path.splitext(self.payload_file_path)
        if ext != '.txt':
            self.payloadFileLabel['text'] = 'Invalid input file type given, please choose a .txt file.'
            return
        basename = os.path.basename(self.payload_file_path)
        self.update_label(basename, 'payload')

    def on_payload_drop(self,event):
        dropped_data = event.data
        dropped_data = dropped_data.replace("{","").replace("}","")
        self.payload_file_path = dropped_data.strip()
        basename = os.path.basename(self.payload_file_path)
        self.update_label(basename)
        
    def on_cover_drop(self,event):
        dropped_data = event.data
        dropped_data = dropped_data.replace("{","").replace("}","")
        self.cover_file_path = dropped_data.strip()
        basename = os.path.basename(self.cover_file_path)
        self.update_label(basename)

    def update_label(self, text, label):
        match label:
            case 'cover':
                if text == '':
                    self.coverFileLabel['text'] = 'Current cover file chosen: None'
                    return
                self.coverFileLabel['text'] = f"Current cover file chosen: {text}"
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

    def display_image(self, image_path):
        image = Image.open(image_path)
        image = image.resize((300, 300))
        photo = ImageTk.PhotoImage(image)
        self.image_label.config(image=photo)
        self.image_label.image = photo

    def run_function(self):
        cover_file, method, payload, bits = self.get_info()
        root, ext = os.path.splitext(self.cover_file_path)
        if (method == "Encode"):
            if ext == '.png' or ext == '.bmp':
                output_path = varying_encoder.encode_message(cover_file,payload,bits)
            elif ext == '.txt':
                textstego.hide_text(cover_file, payload, bits)
            elif ext == '.mp4':
                mdatAVmethod.encodeVideo(cover_file, payload, bits)
            else:
                self.coverFileLabel['text'] = 'Invalid input file type given, please choose another file.'
                return
            self.output_text.delete("1.0", tk.END)
            self.output_text.insert(tk.END, 'Message successfully hidden in ' + output_path) 
        else:
            if ext == '.png' or ext == '.bmp':
                decoded_msg = varying_decoder.decode_message(cover_file,bits)
            elif ext == '.txt':
                decoded_msg = textstego.extract_text(cover_file, bits)
            elif ext == '.mp4':
                decoded_msg = mdatAVmethod.decodeVideo(cover_file, bits)
            else:
                self.output_text.delete("1.0", tk.END)
                self.output_text.insert(tk.END, 'Invalid input file type given, please choose another file.')
                return
            with open('result.txt', 'w') as file:
                file.write(decoded_msg)
            self.output_text.delete("1.0", tk.END)
            self.output_text.insert(tk.END, decoded_msg) 

app = Application()

app.window.mainloop()

