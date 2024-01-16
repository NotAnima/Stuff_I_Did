# Installation Guide
This version uses python 3.9.16

1. Run using `pip install -r requirements.txt`
2. `python ./CacheBus.py` (Creates a JSON file for WorkingPlot to use) 
3. `python ./mapUI.py`

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

## Files required
1. bus_stop.xlsx (Used to import GPS location data)
2. SheetNames.txt (Used to reference bus services inside of the excel sheet and in python)
3. requirements.txt (Used for installing the appropriate libraries required)
4. CacheBus.py (Used for caching the excel data into a JSON format)
5. bestMap.jpg (High resolution map of all the routes in Johor)
6. mapUI.py (The main file used)

## Note
BusDataOld.json is the old graph used, mainly for referencing
