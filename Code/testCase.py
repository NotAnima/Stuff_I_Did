from Algorithms import Algorithms
import json
import xlwt
from xlwt import Workbook

# wb = Workbook()
# sheet1 = wb.add_sheet('1000m')

# Objective of minimize walking not yet accomplished
testCases = [("Larkin Terminal","Opp AEON Taman Universiti"),("Medan Selera Senai","Senai Airport Terminal"),
             ("Pan Vista","aft Persiaran Indahpura 4"),("Sin Kok Soon Motor (JB) Sdn Bhd","Menara MSC Cyberport"),("Opp Pulai View Condo","Kulai Terminal")]
values = [0,5,15,20,25,30]
graphValue = [300,500]
# testCases = [("Larkin Terminal","Opp AEON Taman Universiti"),("Medan Selera Senai","Senai Airport Terminal")]
# values = [0,5]

i = 1
j = 1
firstTime = True
for dist in graphValue:
    wb = Workbook()
    sheet1 = wb.add_sheet(str(dist)+'m')
    with open('BusData'+str(dist)+'.json', 'r') as f:
        (graph, bus_service,bus_stop, plotGraph) = json.load(f)
    for start,end in testCases:
        print("Test location from "+start+" till "+end)
        sheet1.write(0, j, "Test location from "+start+" till "+end)
        for penalty in values:
            for bonus in values:
                print("Penalty of "+str(penalty)+" and bonus of "+str(bonus))
                path,curr_dist,curr_transfers, walks = Algorithms.shortestPath(graph,start,end,bus_stop,penalty,bonus)
                if(firstTime):
                    sheet1.write(i, 0, "Penalty of "+str(penalty)+" and bonus of "+str(bonus))
                    sheet1.write(i+1, 0, "Penalty of "+str(penalty)+" and bonus of "+str(bonus))
                    sheet1.write(i+2, 0, "Penalty of "+str(penalty)+" and bonus of "+str(bonus))
                    sheet1.write(i+3, 0, "Penalty of "+str(penalty)+" and bonus of "+str(bonus))
                sheet1.write(i, j, str(curr_dist)+"km")
                sheet1.write(i+1, j, str(curr_transfers)+" transfers")
                sheet1.write(i+2, j, str(len(path)) + " bus stops")
                sheet1.write(i+3,j, str(walks) + " walks required")
                i += 4
                print("")
        firstTime = False
        j +=1
        i = 1
    j = 1
    firstTime = True
    print("End of test case")
    filename = "TestResults"+str(dist)+".xls"
    wb.save(filename)