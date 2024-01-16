import tkinter as tk

# Create a Tkinter window
window = tk.Tk()
window.title("Scrollbar Example")

# Create a Canvas widget
canvas = tk.Canvas(window)
canvas.pack(side=tk.LEFT, fill=tk.BOTH, expand=True)

# Create a Scrollbar widget
scrollbar = tk.Scrollbar(window, command=canvas.yview)
scrollbar.pack(side=tk.RIGHT, fill=tk.Y)

# Configure the Canvas to use the Scrollbar
canvas.configure(yscrollcommand=scrollbar.set)

# Create a Frame to hold the content
content_frame = tk.Frame(canvas)
canvas.create_window((0, 0), window=content_frame, anchor=tk.NW)

# Add some content to the Frame
for i in range(50):
    label = tk.Label(content_frame, text=f"Label {i+1}")
    label.pack()

# Configure the Canvas to scroll with the Scrollbar
canvas.update_idletasks()
canvas.configure(scrollregion=canvas.bbox("all"))

# Start the Tkinter event loop
window.mainloop()
            
