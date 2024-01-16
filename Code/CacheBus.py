
import json, pandas as pd, pprint, time
from Algorithms import Algorithms, KDTree

def greatImporter(fileNames, sheetNames):
    st = time.time()
    bus_stop = {}
    bus_service = {}
    # dataFrames variable used for compiling all the dataframes before combining into a single dataframe
    dataFrames = []
    # Name of the sheets to import from the excel file
    busStop = open(sheetNames,'r')
    line = busStop.readlines()
    # Remove \n at the back of the lines
    buses = [s.strip('\n') for s in line]

    # Convert sheet data into Dataframes
    print("Preparing bus stops....")
    for bus in buses:
        busRoute = []
        print("Working on bus "+str(bus))
        data = pd.read_excel(fileNames,sheet_name=bus)
        # data variable is used for plotting on matplotlib

        # Removes from the GPS Location column those that contain No bus stop
        data = data[data['GPS Location'] != 'No bus stop, ignore']
        # Split single column into two columns latitude and longitude using apply()
        data[['latitude', 'longitude']] = data["GPS Location"].apply(lambda x: pd.Series(str(x).split(","))).astype(float)
        data = data.set_index('Stop ID')
        for ind in data.index:
            # If GPS Location is a latitude and longitude, convert it into a tuple with dictionary key being the bus name
            bus_stop[data['Bus stop'][ind]] = tuple([data['latitude'][ind],data['longitude'][ind]])
            # Save the bus stop name for reference and distance to next stop
            busRoute.append(data['Bus stop'][ind])

        # Store into a bus dictionary the bus route
        bus_service[bus] = busRoute

        # append to dataFrames array to combine into single dataFrame later
        dataFrames.append(data)
    # Create a graph of every single bus service through the bus stop and sees where the next stop that bus can be
    graph = {}
    for service, path in bus_service.items():
        for route_index in range(len(path) - 1):
            key = path[route_index]
            if key not in graph:
                graph[key] = dict()
            # If it's already in the array don't put in again
            if (path[route_index + 1] not in graph[path[route_index]]):
                # Calculate distance between current bus stop and the next one in km, save it as a dictionary
                graph[path[route_index]][path[route_index + 1]] = (Algorithms.haversine(bus_stop[path[route_index]],bus_stop[path[route_index + 1]]),[service])
            elif(graph[path[route_index]].get(path[route_index + 1]) is not None):
                graph[path[route_index]][path[route_index + 1]][1].append(service)

    # Combine all the bus stop data into a single DataFrame
    pdBus_stop = pd.concat(dataFrames)
    # Remove duplicate locations
    pdBus_stop = pdBus_stop.drop_duplicates()
    pdBus_stop = pdBus_stop.drop(["GPS Location"],axis=1)


    # Start of the new way to do near by stops

    # Create a KD Tree
    tree = KDTree(pdBus_stop[['latitude', 'longitude','Bus stop']])

    for index, row in pdBus_stop.iterrows():
        # For easier naming reference
        curr_bus = row["Bus stop"]

        # Get the distance from the current bus stop to the nearest 5 bus stops around it
        nearest_results = tree.nearest_neighbors((row["latitude"],row["longitude"]), k=5)
        
        # Iterate through the nearest bus stops and put a bi-directional walk between the 2 of them
        for i in range(len(nearest_results)):
            # Variable of the current nearest bus stop to curr_bus
            nearest_bus = nearest_results[i][2]

            # If the nearest bus result is the same as the current bus stop then skip
            # If the current nearest bus stop is along the same bus service as the current bus then skip
            if(nearest_bus != curr_bus):
                lat = nearest_results[i][0]
                lon = nearest_results[i][1]
                # Get distance between current bus stop and nearby bus stops
                distance = Algorithms.haversine((lat,lon),(row["latitude"],row["longitude"]))

                # If the distance is less than 500m, the current bus is not inside of the nearest bus dictionary
                # and the nearest bus is not inside the current bus dictionary, then add it into the graph. This
                # is to prevent overriding existing routes
                if(distance < 0.5 and graph[nearest_bus].get(curr_bus) is None and graph[curr_bus].get(nearest_bus) is None):
                    graph[nearest_bus][curr_bus] = (distance,"Walk")
                    graph[curr_bus][nearest_bus] = (distance,"Walk")

    # End of the new way to do Opposite stops

    # Create Hull for border limit
    busList = list(bus_stop.values())
    busTuple = [tuple(inner_list) for inner_list in busList]
    hull = Algorithms.quickHull(busTuple)

    strJSON = pdBus_stop.to_json(orient='records')
    json_obj = json.loads(strJSON)

    with open('BusData.json', 'w') as f:
        #Graph is for A star, Bus services is dictionary for A star, Bus stop is dictionary for A star, result is a dataframe for matplotlib
        json.dump([graph,bus_service,bus_stop,json_obj,hull],f,indent=4)
    
    et = time.time()
    totalTime = et-st
    print("Total time taken to cache was "+str(totalTime))


greatImporter("bus_stops.xlsx","SheetNames.txt")