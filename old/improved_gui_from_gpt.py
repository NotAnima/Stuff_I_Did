import tkinter as tk
from tkinter import filedialog
from PIL import Image, ImageTk, ImageDraw
from tkinterdnd2 import DND_FILES, TkinterDnD

class Application():
    def __init__(self):
        self.file_path = ''
        self.window = TkinterDnD.Tk()
        self.window.title('Steganography App')
        self.window.geometry('800x600')
        self.window.config(bg='light gray')


        title_label = tk.Label(self.window, text='Steganography App', bg='light gray', font=('Arial', 24, 'bold'))
        title_label.pack(pady=10)


        dnd_frame = tk.Frame(self.window, bg='white', bd=5)
        dnd_frame.pack(pady=10)
        button = tk.Button(dnd_frame, text="Select file", command=self.select_file, font=('Arial', 14))
        button.grid(row=0, column=1, padx=10)
        dndLabel = tk.Label(dnd_frame, text="Drag a file here!", relief=tk.SUNKEN, borderwidth=2, width=50, height=5, bg='lightblue', fg='black', font=('Arial', 14))
        dndLabel.grid(row=0, column=0, padx=10)
        dndLabel.drop_target_register(DND_FILES)
        dndLabel.dnd_bind('<<Drop>>', self.on_drop)


        file_method_frame = tk.Frame(self.window, bg='light gray')
        file_method_frame.pack(pady=10)
        self.fileLabel = tk.Label(file_method_frame, text='Current file chosen: ', bg='light gray', font=('Arial', 14))
        self.fileLabel.pack(pady=10)
        method_label = tk.Label(file_method_frame, text='Please choose to encode/decode:', bg='light gray', font=('Arial', 14))
        method_label.pack(pady=10)
        self.selected_option = tk.StringVar(value="Encode")
        rb1 = tk.Radiobutton(file_method_frame, text="Encode", variable=self.selected_option, value="Encode", bg='light gray', font=('Arial', 14))
        rb2 = tk.Radiobutton(file_method_frame, text="Decode", variable=self.selected_option, value="Decode", bg='light gray', font=('Arial', 14))
        rb1.pack(pady=10)
        rb2.pack(pady=10)


        payload_frame = tk.Frame(self.window, bg='light gray')
        payload_frame.pack(pady=10)
        payload_label = tk.Label(payload_frame, text='Please input payload below:', bg='light gray', font=('Arial', 14))
        payload_label.pack(pady=10)
        self.payload_text = tk.Text(payload_frame, width=50, height=5, font=('Arial', 14))
        self.payload_text.pack(pady=10)


        bit_frame = tk.Frame(self.window, bg='light gray')
        bit_frame.pack(pady=10)
        self.bit_var = tk.IntVar()
        bit_label = tk.Label(bit_frame, text='Please select number of bits:', bg='light gray', font=('Arial', 14))
        bit_label.pack(pady=10)
        bit_slider = tk.Scale(bit_frame, from_=1, to=8, orient=tk.HORIZONTAL, variable=self.bit_var, width=15, length=300, sliderlength=20, bg='white', font=('Arial', 14))
        bit_slider.pack(pady=10)


        save_button = tk.Button(self.window, text="Save", command=self.get_info, font=('Arial', 14, 'bold'), bg='light green')
        save_button.pack(pady=20)

    def get_method(self):
        method = self.selected_option.get()
        return method

    def get_text(self):
        text = self.payload_text.get("1.0", "end-1c")
        return text

    def get_bit(self):
        bit = self.bit_var.get()
        return bit

    def select_file(self):
        self.file_path = filedialog.askopenfilename()
        self.update_label(self.file_path)

    def on_drop(self,event):
        dropped_data = event.data
        self.file_path = dropped_data.strip()
        self.update_label(self.file_path)

    def update_label(self, text):
        self.fileLabel['text'] = f"Current file chosen: {text}"

    def get_info(self):
        info = [self.file_path, self.get_method(), self.get_text(), self.get_bit()]
        print(info)


app = Application()

app.window.mainloop()