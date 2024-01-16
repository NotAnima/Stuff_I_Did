import tkinter as tk
import vlc

class VideoPlayer:
    def __init__(self, video_path):
        self.instance = vlc.Instance()
        self.player = self.instance.media_player_new()
        self.player.set_fullscreen(True)
        self.player.audio_set_volume(50)
        self.player.set_mrl(video_path)

        self.root = tk.Tk()
        self.embed = tk.Frame(self.root, width=640, height=480)
        self.embed.grid(row=0, column=0)
        self.embed.pack()

        self.play_button = tk.Button(self.embed, text='\u25B6 Play', command=self.play_pause, font=('Arial', 14))
        self.play_button.grid(row=1, column=0)
        self.play_button.pack()

        self.player.set_hwnd(self.embed.winfo_id())
        self.player.play()

        self.root.mainloop()

    def play_pause(self):
        if self.player.get_state() == vlc.State.Playing:
            self.player.pause()
            self.play_button.config(text="\u25B6 Play")
        else:
            self.player.play()
            self.play_button.config(text="\u23F8 Pause")


if __name__ == '__main__':
    video_path = '../audioVisual/bing_chilling.mp4'
    player = VideoPlayer(video_path)
