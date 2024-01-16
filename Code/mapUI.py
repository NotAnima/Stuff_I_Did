from tkinter import *
import tkinter,tkintermapview,geocoder,customtkinter,datetime
from geopy.geocoders import Nominatim
import json, pandas as pd, pprint, datetime, time
from Algorithms import Algorithms


geolocator = Nominatim(user_agent="mapApp")

class mapApp(tkinter.Tk):

    APP_NAME = "Bas Muafakat Johor Map"
    WIDTH = 1300
    HEIGHT = 800

    # Load json data
    # graph is for all the adjacent nodes, bus_service is a list of all bus service routes, bus_stop is a dictionary containing the coordinates of the bus stop
    # plotGraph is meant to be converted into a pandas dataframe
    with open('BusData.json', 'r') as f:
        (graph, bus_service,bus_stop, plotGraph,hull) = json.load(f)

    # Used for the search button
    key_bus_stop = list(bus_stop.keys())

    def __init__(self, *args, **kwargs):
        tkinter.Tk.__init__(self, *args, **kwargs)
        self.title(self.APP_NAME)
        # self.geometry(f"{self.WIDTH}x{self.HEIGHT}")
        self.marker_list = []
        width= self.winfo_screenwidth()
        height= self.winfo_screenheight()
        self.geometry("%dx%d" % (width, height))
        
        # To reference the name of the bus stop if typed
        self.chosenStart = ""
        self.chosenEnd = ""


        # ============ create two CTkFrames, Left & Right ============ #
        self.grid_columnconfigure(0, weight=0)
        self.grid_columnconfigure(1, weight=1)
        self.grid_rowconfigure(0, weight=1)

        self.frame_left = customtkinter.CTkFrame(master=self, width=150, corner_radius=0, fg_color=None)
        self.frame_left.grid(row=0, column=0, padx=0, pady=0, sticky="nsew")

        self.frame_right = customtkinter.CTkFrame(master=self, corner_radius=0)
        self.frame_right.grid(row=0, column=1, rowspan=1, pady=0, padx=0, sticky="nsew")
        #============== END of creating FRAMES =========================


        #======= LEFT FRAME =========#
        self.frame_right.grid_columnconfigure(0, weight=1)

        #====== Start location search bar ======#
        self.startLocLabel = customtkinter.CTkLabel(self.frame_left,text="Start:")
        self.startLocLabel.grid(row=0, column = 0,padx=(5,3),pady=(12,5))
        self.startLocEntry = customtkinter.CTkEntry(master=self.frame_left,width=200, placeholder_text="Start Location")
        self.startLocEntry.grid(row=0, column=1, sticky="we", padx=(12, 12), pady=(12,5))

        self.startListBox = tkinter.Listbox(self.frame_left,width=20)
        self.startListBox.grid(row=1, column=1, sticky="we", padx=(12, 12), pady=(12,5))
        self.startListBox.bind("<Double-Button-1>", self.startSelect)
        self.startListBox.grid_forget()
        
        self.items = []
        
        self.startLocEntry.bind("<KeyRelease>", self.start_update_listbox)

        self.button_2 = customtkinter.CTkButton(master=self.frame_left,text="Reset Map",command=self.resetMap)
        self.button_2.grid(row=0, column=2,padx=(10,5),pady=(12,5))

        #====== End location search bar ======#
        self.endLocLabel = customtkinter.CTkLabel(self.frame_left,text="End:")
        self.endLocLabel.grid(row=3, column = 0,padx=(10,1))
        self.endLocEntry = customtkinter.CTkEntry(master=self.frame_left,width=200, placeholder_text="End Location")
        self.endLocEntry.grid(row=3, column=1, sticky="we", padx=(12, 12), pady=5)
        self.endLocEntry.bind("<KeyRelease>", self.end_update_listbox)

        # Where the path results will be printed
        self.pathResult = customtkinter.StringVar()
        self.text_path_results = customtkinter.CTkLabel(master=self.frame_left,textvariable=self.pathResult).grid(row=7, columnspan=4,padx=(10,5),pady=(12,5))
        #====== Search Button ======# Can consider adding a function to search upon <return> key press
        self.search_button = customtkinter.CTkButton(master=self.frame_left,text="Search",command=self.searchBtn)
        self.search_button.grid(row=4, columnspan=4,padx=(10,5),pady=(12,5))
        
        #This is where we include buttons for filter options
        filter_label = customtkinter.CTkLabel(master=self.frame_left, text="Filters: ").grid(column = 0, row = 5)
        self.endListBox = tkinter.Listbox(self.frame_left,width=20)
        self.endListBox.bind("<Double-Button-1>", self.endSelect)
        self.endListBox.grid_forget()

        # List box if there are multiple route options
        self.routeOptions = tkinter.Listbox(self.frame_left,width=20)
        self.routeOptions.bind("<Double-Button-1>", self.getRoute)
        self.routeOptions.grid_forget()
        # What type of route is chosen (Recommended/No Walk)
        self.chosenRoute = ""

        #======= RIGHT FRAME (Purely display of the map) =================#
        self.frame_right.grid_rowconfigure(0, weight=1)
        self.frame_right.grid_columnconfigure(0, weight=1)
        self.map = tkintermapview.TkinterMapView(self.frame_right, corner_radius = 0)
        self.map.set_position(1.559140672,103.7123872) #Center of coordinates provided by cliff
        self.map.set_zoom(12) #zoom can be 0(lowest) to 19(highest)
        self.map.grid(column = 0, sticky="nsew")

        #self.map.add_right_click_menu_command(label="Add Marker", command=self.add_marker_event,pass_coords=True)
        self.map.add_left_click_map_command(self.left_click_event)
            
    def fill_entry(self, event):
        self.entry.delete(0, END)
        selected = self.searchListBox.get(self.searchListBox.curselection())
        if selected != "No suggestions.":
            self.entry.insert(0, selected)

    #function that searches location and drops 2 markers based on search data
    def searchBtn(self):

        for marker in self.marker_list:
            marker.delete()

        self.search_query1= self.startLocEntry.get()
        self.search_query2 = self.endLocEntry.get()
        self.start_location = geolocator.geocode(self.search_query1)
        self.end_location = geolocator.geocode(self.search_query2)
        drawPath = None

        # Convert dictionary into dataframe
        pdBus_stop = pd.DataFrame.from_dict(self.plotGraph)

        # Function to find the closest bus stop for the star and end location
        busStart,busEnd = Algorithms.closestBusStop(pdBus_stop,self.start_location,self.end_location)

        # Run through A start algo
        if(self.chosenStart != "" and self.chosenEnd != ""):
            (path,curr_dist,curr_transfers, travel_minutes,walks) = Algorithms.shortestPath(self.graph,self.chosenStart,self.chosenEnd,self.bus_stop)
            (altPath,alt_curr_dist,alt_curr_transfers, alt_travel_minutes,alt_walks) = Algorithms.shortestPath(self.graph,self.chosenStart,self.chosenEnd,self.bus_stop,lazy=True)
            # Save outcome into class instance
            self.path = path
            self.altPath = altPath
            # Since you're starting from a bus stop and ending at a bus stop, no need to add walk time
            startWalkMins = datetime.timedelta(minutes=0)
            endWalkMins = datetime.timedelta(minutes=0)
        else:
            (path,curr_dist,curr_transfers, travel_minutes,walks) = Algorithms.shortestPath(self.graph,busStart,busEnd,self.bus_stop)
            (altPath,alt_curr_dist,alt_curr_transfers, alt_travel_minutes,alt_walks) = Algorithms.shortestPath(self.graph,busStart,busEnd,self.bus_stop,lazy=True)

            # Save outcome into class instance
            self.path = path
            self.altPath = altPath

            # Get distance and time of starting and ending location to nearest bus stop
            startDist = Algorithms.haversine((self.start_location.latitude,self.start_location.longitude), self.bus_stop[busStart])
            endDist = Algorithms.haversine((self.end_location.latitude,self.end_location.longitude), self.bus_stop[busEnd])

            # Assume walking speed is 5km/h
            startWalkTime = startDist / 5
            # Convert to minutes
            startWalkTime = startWalkTime * 60
            # Convert to exact time delta
            startWalkMins = datetime.timedelta(minutes=startWalkTime)

            # Do the same for the end location
            endWalkTime = endDist / 5
            endWalkTime = endWalkTime * 60
            endWalkMins = datetime.timedelta(minutes=endWalkTime)

            # Make the start marker the address which was plotted. Only show what was before Johor
            startMarker = self.start_location.address.split(", Johor")[0]
            drawPath = ((self.start_location.latitude, self.start_location.longitude),"Walk","Start")
            # Add marker for start location
            self.marker_list.append(self.map.set_marker(self.start_location.latitude, self.start_location.longitude, text=startMarker))

        if (path != altPath):
            self.chosen = "Recommended"
            self.routeOptions.insert(tkinter.END, "Recommended")
            self.routeOptions.insert(tkinter.END, "No Walking")
            # Make it reappear again
            self.routeOptions.grid(row=8, column=1, sticky="we", padx=(12, 12), pady=(12,5))

        # Gets the current time and appends the total travel time
        current_time = datetime.datetime.now()
        alt_current_time = datetime.datetime.now()
        # Contains the estimated arrival time, includes start and end walk if there is
        current_time += travel_minutes + startWalkMins + endWalkMins
        total_minutes = travel_minutes + startWalkMins + endWalkMins

        # Accounts the alternate path
        alt_current_time += alt_travel_minutes + startWalkMins + endWalkMins
        alt_total_minutes = alt_travel_minutes + startWalkMins + endWalkMins
        
        # Save necessary data into the class instance
        self.total_minutes = total_minutes
        self.current_time = current_time
        if(drawPath):
            self.drawPathBase = drawPath
        self.chosenRoute = "Recommended"
        self.alt_current_time = alt_current_time
        self.alt_total_minutes = alt_total_minutes
        # Draw on map function
        self.drawMap(total_minutes,current_time,drawPath,path)

    def start_update_listbox(self, event):
        # Get the value of the Entry box
        query = self.startLocEntry.get()      
        # Replace this with your own function to search for results
        self.items = []
        # If there has been typed, hide the list box
        if not query:
            self.startListBox.delete(0, tkinter.END)
            self.startListBox.grid_forget()  # Hide the list box if the query is empty
        else:
            # Clear out whatever results have been in the list box so far
            self.startListBox.delete(0, tkinter.END)
            # Add any bus stop that matches the input given by the user using KMP
            for bus in self.key_bus_stop:
                if(Algorithms.KMPdoesItContain(bus,query)):
                    self.items.append(bus)
            # If there is 1 or more item then add it into the list box output
            if len(self.items) > 0:
                for item in self.items:
                    self.startListBox.insert(tkinter.END, item)
                # Make it reappear again
                self.startListBox.tkraise()
                self.startListBox.grid(row=2, column=1, sticky="we", padx=(12, 12), pady=(12,5))
            else:
                self.startListBox.delete(0, tkinter.END)
                self.startListBox.grid_forget()

    def end_update_listbox(self, event):
        query = self.endLocEntry.get()      
        # Replace this with your own function to search for results
        self.items = []
        if not query:
            self.endListBox.delete(0, tkinter.END)
            self.endListBox.grid_forget()  # Hide the list box if the query is empty
        else:
            self.endListBox.delete(0, tkinter.END)
            for bus in self.key_bus_stop:
                if(Algorithms.KMPdoesItContain(bus,query)):
                    self.items.append(bus)
            if len(self.items) > 0:
                for item in self.items:
                    self.endListBox.insert(tkinter.END, item)
                self.endListBox.tkraise()
                self.endListBox.grid(row=4, column=1, sticky="we", padx=(12, 12), pady=(12,5))
            else:
                self.endListBox.delete(0, tkinter.END)
                self.endListBox.grid_forget()
        
            
    def startSelect(self, event):
        # Select the bus stop chosen by the user
        index = self.startListBox.curselection()
        if index:
            item = self.items[index[0]]
            print(f"Selected item: {item}")
            # From the bus stop dictionary, get the latitude and longitude of the bus stop
            chosenLat = self.bus_stop[item][0]
            chosenLong = self.bus_stop[item][1]
            # Clear out the Entry value from whatever the user has typed
            self.startLocEntry.delete(0,tkinter.END)
            # Replace it with the latitude and longitude
            self.startLocEntry.insert(0,(chosenLat,chosenLong))
            # Clear out the list box
            self.startListBox.delete(0, tkinter.END)
            # Hide the listbox
            self.startListBox.grid_forget()
            if(self.chosenStart != ""):
                self.marker_list[-2].delete()
            # Add a marker onto the map
            self.marker_list.append(self.map.set_marker(chosenLat,chosenLong,text=item))
            self.chosenStart = item

    def endSelect(self, event):
        index = self.endListBox.curselection()
        if index:
            item = self.items[index[0]]
            print(f"Selected item: {item}")
            chosenLat = self.bus_stop[item][0]
            chosenLong = self.bus_stop[item][1]
            self.endLocEntry.delete(0,tkinter.END)
            self.endLocEntry.insert(0,(chosenLat,chosenLong))
            self.endListBox.delete(0, tkinter.END)
            self.endListBox.grid_forget()
            if(self.chosenEnd != ""):
                self.marker_list[-1].delete()
            self.marker_list.append(self.map.set_marker(chosenLat,chosenLong,text=item))
            self.chosenEnd = item

    #function to allow dropping of pin on right click   
    def add_marker_event(self,coords):
        print("Add marker:", coords)
        self.map.set_marker(coords[0], coords[1])
    
    #function to allow dropping of pin on right click   
    def left_click_event(self,coordinates_tuple):
        borderPermit = Algorithms.isinHull(coordinates_tuple,self.hull)
        if self.startLocEntry.get() == "":
            if(borderPermit):
                self.startLocEntry.insert(0,coordinates_tuple)
                self.start_location = self.startLocEntry.get()
                selectedLocation = geolocator.geocode(str(coordinates_tuple[0])+" "+str(coordinates_tuple[1]))
                addressMarker = selectedLocation.address.split(", Johor")[0]
                self.marker_list.append(self.map.set_marker(coordinates_tuple[0],coordinates_tuple[1],text=addressMarker))
            else:
                tkinter.messagebox.showerror("Error","You are outside the border, please click within Johor Bahru")

        elif self.endLocEntry.get() == "":
            if(borderPermit):
                self.endLocEntry.insert(0,coordinates_tuple)
                self.end_location = self.endLocEntry.get()
                selectedLocation = geolocator.geocode(str(coordinates_tuple[0])+" "+str(coordinates_tuple[1]))
                addressMarker = selectedLocation.address.split(", Johor")[0]
                self.marker_list.append(self.map.set_marker(coordinates_tuple[0],coordinates_tuple[1],text=addressMarker))
            else:
                tkinter.messagebox.showerror("Error","You are outside the border, please click within Johor Bahru")

    def resetMap(self):
        self.map.set_position(1.559140672,103.7123872) #Center of coordinates provided by cliff
        self.map.set_zoom(12) #zoom can be 0(lowest) to 19(highest)
        
        for marker in self.marker_list:
            marker.delete()
        
        # Reset result text to nothing
        self.pathResult.set("")
        self.startLocEntry.delete(0,END) 
        self.endLocEntry.delete(0,END)
        self.map.delete_all_path()

        self.map.set_position(1.559140672,103.7123872) #Center of coordinates provided by cliff
        self.map.set_zoom(12) #zoom can be 0(lowest) to 19(highest)

        # Remove route options
        self.routeOptions.delete(0,END)
        self.routeOptions.grid_forget()

        # Reset chosen value
        self.chosenStart = ""
        self.chosenEnd = ""


    def getRoute(self, event):
        options = ["Recommended", "No Walk"]
        index = self.routeOptions.curselection()
        if index:
            item = options[index[0]]
            print(f"Selected item: {item}")
            # Handles the Recommended route
            if(item == "Recommended" and self.chosenRoute != "Recommended"):
                self.chosenRoute = "Recommended"
                self.resetMap()
                self.drawMap(self.total_minutes,self.current_time,self.drawPathBase,self.path)
                self.routeOptions.insert(tkinter.END, "Recommended")
                self.routeOptions.insert(tkinter.END, "No Walking")
                # Make it reappear again
                self.routeOptions.grid(row=8, column=1, sticky="we", padx=(12, 12), pady=(12,5))

            # Handles the No walking route
            elif(item == "No Walk" and self.chosenRoute != "No Walk"):
                self.chosenRoute = "No Walk"
                self.resetMap()
                self.drawMap(self.alt_total_minutes,self.alt_current_time,self.drawPathBase,self.altPath)
                # Continue to give options to jump between Recommended and No walking
                self.routeOptions.insert(tkinter.END, "Recommended")
                self.routeOptions.insert(tkinter.END, "No Walking")
                # Make it reappear again
                self.routeOptions.grid(row=8, column=1, sticky="we", padx=(12, 12), pady=(12,5))

    # Takes in total minutes travelled, time taken to travel, drawPath needed to be drawn and output
    def drawMap(self,total_minutes,current_time,drawPathBase,path):
        drawPath = []
        if(drawPathBase):
            drawPath.append(drawPathBase)
        pprint.pprint(path)
        # Contains the number of travel mins, round up/down respectively
        minutes_travelled = round(float(total_minutes.total_seconds() / 60))

        time_string = current_time.strftime('%H:%M')
        # Tracks what mode of transport is being used
        current_service = None
        # Contains the string to concat to describe the travel instructions
        pathAnswer = "Your estimated arrival time is: "+time_string+"\nEstimated travel time is: "+str(minutes_travelled)+"mins\n"
        for index, busStop in enumerate(path):
            #Create a list of bus stops that contains it's coordinates and service used (Bus or walk) and bus stop name
            drawPath.append((self.bus_stop[busStop[0]],busStop[1],busStop[0]))

            # Everything is to create a string to print on the left panel of the GUI
            if index == 0:
                continue
            prev_stop = path[index-1]
            if busStop[1] is None:
                continue
            if busStop[1] == "Walk":
                if current_service is None:
                    pathAnswer += f"Walk to {busStop[0]}.\n"
                else:
                    pathAnswer += f"Alight from {current_service} and walk to {busStop[0]}.\n"
                current_service = None
            elif prev_stop[1] == busStop[1]:
                continue
            else:
                if current_service is None:
                    pathAnswer += f"Take {busStop[1]} at {prev_stop[0]}.\n"
                else:
                    pathAnswer += f"Alight from {current_service} and take {busStop[1]} at {prev_stop[0]}.\n"
                current_service = busStop[1]

        pathAnswer += f"Get off at {path[-1][0]}.\n"
        self.pathResult.set(pathAnswer)

        # Will add the ending location
        if(self.chosenStart == "" and self.chosenEnd == ""):
            drawPath.append(((self.end_location.latitude, self.end_location.longitude),"Walk","End"))

        prev_service = None
        # Draw the path onto the map
        if(self.chosenStart == "" and self.chosenEnd == ""):
            for i in range(len(drawPath)):
                if(i == len(drawPath)-2):
                    self.map.set_path(
                        [drawPath[i][0],
                        drawPath[i+1][0]],
                        color="red",
                        width=3
                    )
                # Handles for in between trips walking
                elif(drawPath[i][1] == "Walk" and i > 0):
                    self.map.set_path(
                        [drawPath[i][0],
                        drawPath[i-1][0]],
                        color="red",
                        width=3
                    )
                    self.map.set_path(
                        [drawPath[i][0],
                        drawPath[i+1][0]],
                        color="blue",
                        width=3
                    )
                # Handles for beginning/end of the trip walking
                elif(drawPath[i][1] == "Walk"):
                    self.map.set_path(
                        [drawPath[i][0],
                        drawPath[i+1][0]],
                        color="red",
                        width=3
                    )
                else:
                    self.map.set_path(
                        [drawPath[i][0],
                        drawPath[i+1][0]],
                        color="blue",
                        width=3
                    )

                # Handles when you first start marking since prev_service always starts with None
                if(prev_service is None):
                    prev_service = drawPath[i][1]
                    continue
                elif(drawPath[i][1] is None):
                    # Add marker if current node if it's in the beginning
                    self.marker_list.append(self.map.set_marker(drawPath[i][0][0],drawPath[i][0][1],text=drawPath[i][2]))
                elif(prev_service != drawPath[i][1] and (drawPath[i][1] == "Walk" or prev_service == "Walk")):
                    # If the current service and the previous service don't match means you're changing. Then ensure that it's a walk change
                    self.marker_list.append(self.map.set_marker(drawPath[i-1][0][0],drawPath[i-1][0][1],text=drawPath[i-1][2]))
                elif(prev_service != drawPath[i][1] and prev_service != "Walk" and drawPath[i][1] != "Walk"):
                    # If the current service and the previous service don't match means you're changing. Then ensure it's changing from 1 service to another within the same bus stop
                    self.marker_list.append(self.map.set_marker(drawPath[i-1][0][0],drawPath[i-1][0][1],text=drawPath[i-1][2]))
                elif(i == len(drawPath)-2):
                    # Handles when you reach the end point
                    self.marker_list.append(self.map.set_marker(drawPath[i][0][0],drawPath[i][0][1],text=drawPath[i][2]))
                    endMarker = self.end_location.address.split(", Johor")[0]
                    self.marker_list.append(self.map.set_marker(self.end_location.latitude, self.end_location.longitude, text=endMarker))
                    break

                prev_service = drawPath[i][1]
        else:
            for i in range(len(drawPath)-1):
                # Handles for in between trips walking
                if(drawPath[i][1] == "Walk" and i > 0):
                    self.map.set_path(
                        [drawPath[i][0],
                        drawPath[i-1][0]],
                        color="red",
                        width=3
                    )
                    self.map.set_path(
                        [drawPath[i][0],
                        drawPath[i+1][0]],
                        color="blue",
                        width=3
                    )
                else:
                    self.map.set_path(
                        [drawPath[i][0],
                        drawPath[i+1][0]],
                        color="blue",
                        width=3
                    )

                # Handles when you first start marking since prev_service always starts with None
                if(drawPath[i][1] is None):
                    # Add marker if current node if it's in the beginning
                    self.marker_list.append(self.map.set_marker(drawPath[i-1][0][0],drawPath[i-1][0][1],text=drawPath[i-1][2]))
                elif(prev_service != drawPath[i][1] and prev_service != "Walk" and drawPath[i][1] != "Walk"):
                    # If the current service and the previous service don't match means you're changing. Then ensure it's changing from 1 service to another within the same bus stop
                    self.marker_list.append(self.map.set_marker(drawPath[i-1][0][0],drawPath[i-1][0][1],text=drawPath[i-1][2]))
                elif(prev_service != drawPath[i][1] and (drawPath[i][1] == "Walk" or prev_service == "Walk")):
                    # If the current service and the previous service don't match means you're changing. Then ensure that it's a walk change
                    self.marker_list.append(self.map.set_marker(drawPath[i-1][0][0],drawPath[i-1][0][1],text=drawPath[i-1][2]))
                elif(i == len(drawPath)-1):
                    # Handles when you reach the end point
                    print("last one")
                    self.marker_list.append(self.map.set_marker(drawPath[i+1][0][0],drawPath[i+1][0][1],text=drawPath[i+1][2]))
                    break

                prev_service = drawPath[i][1]


        # Reset everything from scratch
        self.chosenStart = ""
        self.chosenEnd = ""


    def start(self):
        self.mainloop()

app = mapApp()
app.start()

