import tkinter as tk
from tkVideoPlayer import TkinterVideo

def create_gradient(canvas, x, y, width, height, color1, color2):
        # Create a rectangle with a gradient fill
        for i in range(width):
            r = int(color1[0] * (width - i) / width + color2[0] * i / width)
            g = int(color1[1] * (width - i) / width + color2[1] * i / width)
            b = int(color1[2] * (width - i) / width + color2[2] * i / width)
            color = f'#{r:02x}{g:02x}{b:02x}'
            canvas.create_line(x, y + i, x + height, y + i, fill=color)

root = tk.Tk()

frame = tk.Frame(root, width=400, height=400)
frame.pack()

# Define the gradient colors (start and end colors)
start_color = (255, 255, 255)  # White
end_color = (115, 110, 176)  # Blue

# Create the gradient background
create_gradient(frame, 0, 0, 400, 400, start_color, end_color)

root.mainloop()

