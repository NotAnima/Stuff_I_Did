import heapq, datetime
from pprint import pprint
from scipy.spatial import Delaunay
import math
import numpy as np

class Algorithms:
    def shortestPath(graph,start,end, bus_stop,lazy=False,penalty=15,bonus=0):
        # A Star
        queue = []
        seen = set()
        # Track current time
        current_time = datetime.timedelta(minutes=0)
        heapq.heappush(queue, (0, 0, 0, current_time,[(start,None)]))
        walk = 0

        while queue:
            # current cost is the distance, euclidean distance and transfer cost accounted for. # current distance is only the distance traversed so far
            (curr_cost, curr_dist, curr_transfers,current_time, path) = heapq.heappop(queue)
            (node, curr_service) = path[-1]
            # Base case, if node has reached the destination
            if node == end:
                # pprint.pprint(path)
                for stop, service in path:
                    if(service == "Walk"):
                        walk += 1
                
                # Show total accumulated travel time
                total_time = round(float(current_time.total_seconds() / 60))
                # Verbose to show algorithm outcome
                # pprint(path)
                print(str(curr_dist)+"km")
                print(str(curr_transfers-1) + " transfers made")
                print(str(walk) + " walks required")
                print("Estimated destination time is:",str(total_time),"mins")

                # Returns the route, total distance covered, total transfers required, total travel time, total number of walks required
                return (path,curr_dist,curr_transfers-1,current_time, walk)

            # Skip bus stop with that bus service if iterated through before
            if (node, curr_service) in seen:
                continue

            seen.add((node, curr_service))

            for adjacent, (distance,service) in graph.get(node, {}).items():
                if (len(service) > 1 and isinstance(service, list)):
                    # If there are multiple services then handle the different pathways and the variable type is array
                    for service_in_use in service:
                        service_in_use = service[0]
                        new_path = list(path)
                        new_path.append((adjacent,service_in_use))
                        new_distance = curr_dist + distance
                        new_transfers = curr_transfers

                        # Heuristics are the Distance to the next adjacent node, Euclidean distance to end node and Transfers needed
                        new_cost = curr_cost + distance + Algorithms.haversine(bus_stop[node], bus_stop[end])
                        if (curr_service != service_in_use and service_in_use == "Walk"):
                            new_transfers += 1
                            #Give harsher penalty for having to transfer by walking
                            new_cost += penalty+5

                            # Calculate time. Distance/Speed = Time (In hours)
                            # Assume human walking speed is 5
                            time = distance/5
                            # Convert time to minutes
                            time = time *60
                            current_time += datetime.timedelta(minutes=time)
                            # Add the time in minutes as additional values as heuristics
                            new_cost += time
                        elif (curr_service != service_in_use):
                            new_transfers += 1
                            #Give penalty for having to transfer
                            new_cost += penalty

                            # Waiting time for the next bus, assume 7 mins
                            current_time += datetime.timedelta(minutes=7)
                            # Add the time in minutes as additional values as heuristics
                            new_cost += 7
                        else:
                            # Give bonus for not transferring
                            new_cost -= bonus
                            # Calculate time. Distance/Speed = Time (In hours)
                            # Assume average bus speed is 17
                            time = distance/20
                            # Convert time to minutes
                            time = time *60
                            current_time += datetime.timedelta(minutes=time)
                            # Add the time in minutes as additional values as heuristics
                            new_cost += time

                        heapq.heappush(queue, (new_cost, new_distance, new_transfers,current_time, new_path))
                elif(isinstance(service, list) or isinstance(service,str)):
                    # If only 1 bus service goes from the current to the next
                    if (isinstance(service, list)):
                        service_in_use = service[0]
                    else:
                        service_in_use = service
                    if (service == "Walk" and lazy is True):
                        continue
                    new_path = list(path)
                    new_path.append((adjacent,service_in_use))
                    new_distance = curr_dist + distance
                    new_transfers = curr_transfers

                    # Heuristics are the Distance to the next adjacent node, Euclidean distance to end node and Transfers needed
                    new_cost = curr_cost + distance + Algorithms.haversine(bus_stop[node], bus_stop[end])
                    if (curr_service != service_in_use and service_in_use == "Walk"):
                        new_transfers += 1
                        #Give harsher penalty for having to transfer by walking
                        new_cost += penalty+5

                        # Calculate time. Distance/Speed = Time (In hours)
                        # Assume human walking speed is 5
                        time = distance/5
                        # Convert time to minutes
                        time = time *60
                        current_time += datetime.timedelta(minutes=time)
                        new_cost += time
                    elif (curr_service != service_in_use):
                        new_transfers += 1
                        # Give penalty for having to transfer
                        new_cost += penalty

                        # Waiting time for the next bus, assume 7 mins
                        current_time += datetime.timedelta(minutes=7)
                        new_cost += 7
                    else:
                        # Give bonus for not transferring
                        new_cost -= bonus

                        # Calculate time. Distance/Speed = Time (In hours)
                        # Assume average bus speed is 17
                        time = distance/20
                        # Convert time to minutes
                        time = time *60
                        current_time += datetime.timedelta(minutes=time)
                        new_cost += time
                    heapq.heappush(queue, (new_cost, new_distance, new_transfers,current_time, new_path))


    # Function takes in a Dataframe and 2 tuples of latitude and longitude 
    def closestBusStop(pdBus_stop,start_location,end_location):
        # Convert dataframe into KDTree
        tree = KDTree(pdBus_stop[['latitude', 'longitude','Bus stop']])

        # Find the nearest for both start and end location
        start_nearest = tree.nearest_neighbors((start_location.latitude, start_location.longitude), k=1)
        end_nearest = tree.nearest_neighbors((end_location.latitude, end_location.longitude), k=1)

        # Return the name of the bus stop for the nearest
        return start_nearest[0][2],end_nearest[0][2]
    
    # The pattern will be the return box from the GUI, running through a constantly waiting loop and searches new patterns, its a threaded process which returns the list from cached busstops
    def KMPdoesItContain(busStopName, pattern): 
        busStopName = busStopName.upper()
        pattern = pattern.upper()
        if pattern == "":
            return False
        # Will only ever have the same amount of states in the LPS array = to the length of the pattern to look for
        lps = [0]*len(pattern) 
        prevLPS = 0
        i = 1
        while i < len(pattern):
            if pattern[i] == pattern[prevLPS]:
                lps[i] = prevLPS + 1
                prevLPS += 1
                i += 1
            elif prevLPS == 0:
                lps[i] = 0
                i += 1
            else:
                prevLPS = lps[prevLPS-1]
        # Everything above this is setting up the LPS, longest prefix suffix array which tells us which 'state' index to go to
        i = 0 # Pointer for text to search in
        j = 0 # Pointer for pattern
        while i < len(busStopName):
            if busStopName[i] == pattern[j]:
                i, j = i + 1, j+1 #iIf theres a match, increment both pointers
            else:
                if j == 0: # If first letter in pattern doesn't already match, go to the next letter of the busStopName, because j cannot be < 0
                    i += 1
                else:
                    j = lps[j-1]
            if j == len(pattern): # if j == length of the pattern to look for, it means that theres a string matching the busStopName of certain sections eg: 'Taman University' and pattern is 'Taman' (might have to toUpper() the inputs)
                indexOfOccurence = i - len(pattern) # Change the code to return this if you need, otherwise no need
                return True
        return False # Result not found
    
    # Calculate haversine distance between 2 points on a sphere
    def haversine(local1, local2):
        # convert decimal degrees to radians
        lat1, lon1, lat2, lon2 = map(math.radians, [local1[0], local1[1], local2[0], local2[1]])

        # haversine formula
        dlon = lon2 - lon1 
        dlat = lat2 - lat1 
        a = math.sin(dlat/2)**2 + math.cos(lat1) * math.cos(lat2) * math.sin(dlon/2)**2
        c = 2 * math.asin(math.sqrt(a)) 
        r = 6371 # Radius of earth in kilometers. Use 3956 for miles
        return c * r
    
    # See if GPS location is within allowed space (JB)
    def quickHull(points):
        # Finds the leftmost and rightmost points in the set
        leftmost = min(points, key=lambda point: point[0])
        rightmost = max(points, key=lambda point: point[0])

        # Divide the points into two subsets: those on the left side of the line from leftmost to rightmost, and those on the right side of the line
        left_set = set()
        right_set = set()
        for point in points:
            if Algorithms.isLeftOfLine(leftmost, rightmost, point) > 0:
                left_set.add(point)
            elif Algorithms.isLeftOfLine(leftmost, rightmost, point) < 0:
                right_set.add(point)

        # Recursively find the points on the convex hull of each subset
        hull = [leftmost, rightmost]
        Algorithms.findHull(hull, left_set, leftmost, rightmost)
        Algorithms.findHull(hull, right_set, rightmost, leftmost)

        return hull


    def findHull(hull, point_set, p, q):
        if not point_set:
            return

        # find the point with the maximum distance from the line pq
        max_dist = 0
        max_point = None
        for point in point_set:
            dist = Algorithms.distanceFromLine(p, q, point)
            if dist > max_dist:
                max_dist = dist
                max_point = point

        # Add the max point to the hull and remove it from the point set
        hull.insert(hull.index(q), max_point)
        point_set.remove(max_point)

        # Divide the remaining points into two subsets: those on the left side of the line from p to max_point, and those on the left side of the line from max_point to q
        left_set = set()
        right_set = set()
        for point in point_set:
            if Algorithms.isLeftOfLine(p, max_point, point) > 0:
                left_set.add(point)
            elif Algorithms.isLeftOfLine(max_point, q, point) > 0:
                right_set.add(point)

        # Recursively find the points on the convex hull of each subset
        Algorithms.findHull(hull, left_set, p, max_point)
        Algorithms.findHull(hull, right_set, max_point, q)


    def isLeftOfLine(p, q, r):
        # determines if point r is on the left or right of the line formed by points p and q
        return (q[0] - p[0]) * (r[1] - p[1]) - (q[1] - p[1]) * (r[0] - p[0])


    def distanceFromLine(p, q, r):
        # calculates the distance between point r and the line formed by points p and q
        return abs((q[0] - p[0]) * (p[1] - r[1]) - (p[0] - r[0]) * (q[1] - p[1])) / ((q[0] - p[0]) ** 2 + (q[1] - p[1]) ** 2) ** 0.5

    def isinHull(point, hull): #checks whether or not a point given into the function is within the hull or not
        if not isinstance(hull,Delaunay):
            hull = Delaunay(hull)

        return hull.find_simplex(point)>=0

class KDTree:
    def __init__(self, df): #KDTree class constructor
        points = df[['latitude', 'longitude']].values.tolist() #extracts the points from the passed in dataframe array
        bus_stops = df['Bus stop'].tolist() #extracts the bus stops from the dataframe array
        self.root = self.build_kdtree(points, bus_stops) #builds the tree and assigns the top of the tree to be the root

    def build_kdtree(self, points, bus_stops, depth=0):
        if not points: #base case
            return None

        k = len(points[0]) #evaluates the number of dims the tree 2 here because it's just lat and long
        axis = depth % k #finding the dimension cycle
        sorted_points = sorted(zip(points, bus_stops), key=lambda x: x[0][axis]) #sorting the points on the current axis
        mid = len(sorted_points) // 2 #finding the mid of the points

        return KDNode( #creates a new KD node from the defined KDNode class **self is parameter 1**
            sorted_points[mid][0], #parameter 2
            axis,                  #parameter 3
            sorted_points[mid][1], #parameter 4
            self.build_kdtree([p for p, b in sorted_points[:mid]], [b for p, b in sorted_points[:mid]], depth+1), #parameter 5
            self.build_kdtree([p for p, b in sorted_points[mid+1:]], [b for p, b in sorted_points[mid+1:]], depth+1) #parameter 6
        )

    def nearest_neighbors(self, point, k=1): 
        heap = []

        def search(node, depth=0):
            if node is None: #base case
                return

            dist = math.dist(node.point, point) #finds euclidean dist of the point we are looking at and the current node
            heapq.heappush(heap, (-dist, node.point, node.bus_stop)) #add node to a priority queue in descending order (shortest path at the front)

            if len(heap) > k:
                heapq.heappop(heap) #remove node with the farthest distance from the current node

            kth_neighbor_dist = -heap[0][0] #get the distance of the farthest node in the p queue
            axis = depth % len(point) #finding the dimension cycle of the point <x or y>

            if point[axis] < node.point[axis]: #using the current node as "root", recursively search the left and right subtrees to find the node we want to look at's position
                search(node.left, depth+1)
                if point[axis] + kth_neighbor_dist >= node.point[axis]:
                    search(node.right, depth+1)
            else:
                search(node.right, depth+1)
                if point[axis] - kth_neighbor_dist <= node.point[axis]:
                    search(node.left, depth+1)

        search(self.root) #start the search from the base root node of the KDTree
        return [(lat, lon, stop) for dist, (lat, lon), stop in heapq.nlargest(k, heap)] 
        # retrieve the k nearest neighbors from the priority queue and return their coordinates and bus stop names

class KDNode: #KDNode class creation
    def __init__(self, point, axis, bus_stop=None, left=None, right=None): #class constructor
        self.point = point
        self.axis = axis
        self.bus_stop = bus_stop
        self.left = left
        self.right = right