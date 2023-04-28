# Stuff_I_Did

Using only the linux terminal and shell commands with cron jobs to fully automate the minecraft server without the usage of screens or GUI.
All the lines with the "$" symbol attached to it indicate that it's something you have to enter into the linux terminal and not something you actually include yourself.

SETTING UP THE SERVER ON LOCALHOST:

1) Make sure that the raspberry pi is properly connected to the internet. WI-FI or Ethernet connection is fine
- SSH into your raspberry PI
- Enter the user ID and password
- Default user ID: pi
- Default pwd: raspberry

2) Properly update the raspberry pi with:
    If you cannot get the WiFi connection to work, you can try using the PI imager and override the harddisk SD card and enable wifi with your home's wifi SSID and password from the terminal
    $ sudo apt update
    $ sudo apt upgrade
    $ sudo reboot

3) Set a static IP for your raspberry pi within your own private network (192.168.x.x):
  3.1) $ cd /etc
  3.2) $ nano dhcpcd.conf
  # Default gateway can be easily found out on a windows system under cmd using ipconfig /all and ip route on a linux terminal
  3.3) at the top of the .conf file add these lines:
    interface eth0
    static ip_address=x.x.x.x/24 
    #replacing x.x.x.x with the left over octets of your private network of the raspberry PI.
    static router = x.x.x.x
    #replacing x.x.x.x with the default gateway of your house (most likely the router). 
    static domain_name_server=8.8.8.8
    
4) $ cd /home/pi && mkdir folder_name

5) $ cd folder_name

6) wget https://piston-data.mojang.com/v1/objects/8f3112a1049751cc472ec13e397eade5336ca7ae/server.jar
  #https://www.minecraft.net/en-us/download/server use this website link and right click copy link address on the minecraft_server.jar download href

7) $ java -Xmx1024M -Xms1024M -jar server.jar nogui
  # NOTE: that running /server.jar or ./server.jar most likely will not work because there is not enough RAM for the server to even load properly
  # In the future, you can change 1024 to any number greater than the current available RAM size. Do note that it shouldn't really go above ~85-90% of the total RAM     (assuming that you are not running any extra things that consumes RAM like chromium browser)
  # Let the server generate the world and then type "/stop" or "stop"
  
8) $ nano eula.txt

9) edit the eula.txt from false to TRUE and hit Ctrl+O -> Enter -> Ctrl+X

10) From this point on, the server is entirely usable on a localhost where you can have people from the same local area network (same wifi) to join the server either by using localhost or x.x.x.x for the server.
  # $ java -Xmx3500M -Xms3500M -jar server.jar nogui
  Is the command I used to run my server for more RAM allocation to the server and load up the entire world
  Additionally you can OP your own character to make administration matters in the server easier later on
  #NOTE: The server will crash if you exit out of the SSH session at any point of time. So the next part is to have it run as a background process automatically
  
PORTFORWARDING THE SERVER:

1) Access into your router and add a new rule to the router on UDP/TCP that allows the port for external port: 25565 and indicated for the server to be the internal port: 25565 by default, unless changed otherwise
# Normally you would need to enable inbound/outbound firewalls for this on the same ports on UDP/TCP, but raspberry pi doesn't seem to inherently have this inbuilt (correct me if I am wrong, but ufw is an installed apt).
# This allows people from outside your network to access the minecraft server if you provide them your public ip address which you can easily find out by googling:
 "What is my ip address?"
# NOTE: Public IP address leased by your router can and probably will change every so often, usually 7-14 days per lease. So the IP address used to connect to the server will probably be different after sometime.

AUTOMATION PROCESS:
1) $ cd /home/pi/Minecraft_Server (this is my folders name, it could be different from yours)

2) $ nano reboot.sh
  -Copy paste this command into the shell file:
    #!/bin/bash
    sudo reboot
  -Ctrl+O -> Enter -> Ctrl+X to save the file
  
3) $ chmod 777 reboot.sh
   #This gives a lot of permissions to reboot.sh
   
4) $ crontab -e
  - Select nano if it's the first time entering crontab -e. Navigate to the bottom of the crontab and add these lines:
    @reboot sleep 10 && cd /home/pi/Minecraft_Server && /usr/bin/java -Xmx3500M -Xms3500M -jar /home/pi/Minecraft_Server/server.jar nogui &
    @reboot sleep 86400 && cd /home/pi/Minecraft_Server && /home/pi/Minecraft_Server/reboot.sh &
  - Once again, change the path of the information required to run the server.jar file if necessary.
  - Ctrl+O -> Enter -> Ctrl+X to exit
  # Basically what this does is that it create cron jobs for the system to execute in the background upon bootup. You can now SSH into your PI and it won't affect
   the server at all.
   
SETTING UP A DDNS:
1) www.duckdns.org
2) Login using any form of login method: I just used gmail login
3) Name your sub domain to be whatever you want
4) Navigate to "install" at the top header of the website
5) Select that domain name server
#NOTE: the domain is only HTTP so it is not as secure as it would be, but it's a free domain, so use it at your own risk.
6) SSH into your raspberry PI and do the following to make the DNS dynamic: (or just follow what is on the website)
    6.1) $ cd /home/pi && mkdir duckdns
    6.2) $ cd duckdns
    6.3) $ vi duck.sh
    6.4) Copy and paste (right click in the terminal to paste) the token provided by duckdns into the shell file
    6.5) Escape -> :wq! -> Enter
    6.6) $ chmod 700 duck.sh
    6.7) $ ./duck.sh
    6.8) $ cat duck.log to check if the response was "OK", if yes, then all is well. If it is "KO" something went wrong. Go back to 6.3) or just follow the website.
      - the output should be something like:
        "OKpi@raspberrypi:~/duckdns $ "
    6.9) $ crontab -e
      - Navigate to the bottom of the crontab and enter this:
        "*/5 * * * * /home/pi/duckdns/duck.sh >> /home/pi/duckdns/duck.log 2>&1 &" not including the "    " quotations, make sure the path for executing duck.sh
      - Ctrl+O -> Enter -> Ctrl+X to save and exit. Make sure to not include @reboot at the front like the previous cron jobs because it invalid crontab syntax
        and it causes it to not function properly.
    6.10) $ sudo service cron start
      - This just starts the new cron job that you added into the crontab file. It shouldn't affect any of the previous jobs currently executing.
7) $ sudo reboot

END:

That should be everything that you need to install and automate your Minecraft Server that restarts every 24hrs, including your raspberry pi to prevent memory leaks and refresh CPU Load of extended periods of being turned on.
