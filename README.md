# INF2005_ACW1

1. Run using `pip install -r requirements.txt`
## If pip install has errors:
```
pip : The term 'pip' is not recognized as the name of a cmdlet, function, script file, or operable program. Check the spelling of the name, or if a path was 
included, verify that the path is correct and try again.

At line:1 char:1
+ pip install -r requirements.txt
+ ~~~
    + CategoryInfo          : ObjectNotFound: (pip:String) [], CommandNotFoundException
    + FullyQualifiedErrorId : CommandNotFoundException
```
Direct yourself to the correct repo directory and run `python -m pip install -r requirements.txt`


2. Installation of VLC player for the application to run
```
Find out what bit system your machine operates on:
Steps:
1. Open up a File Explorer. For windows: Window Key + E
2. Find "This PC"
3. Right click and choose "properties"
4. Look under System type: For e.g: "64-bit operating system, x64-based processor"
5. Download the appropriate bit type VLC player for your system and then install it
```
After installing the VLC player, add it to your PATH if you're still having troubles running the GUI
