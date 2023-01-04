import numpy as np

def q1(array):
    largest_num = max(array)
    return array.index(largest_num)

def q2(array):
    length = len(array)
    return array[-1:-(length+1):-1]

def q3(array):
    smallest = min(array)
    index_smallest = array.index(smallest)
    array.pop(index_smallest)
    second_smallest = min(array)
    print(f'{smallest} {second_smallest}')

def q4(array,x):
    array.append(x)
    return print(sorted(array))
#q5  best case = O(n)
#    worst case = O(n)

class student:
    def __init__(self,name,student_number,subjects):
        self.name = name
        self.student_number = student_number
        self.subjects = subjects
    def getBestExamScore(self):
        highest_score = 0
        highest_subj_name = ""
        for subject, score in self.subjects.items(): #iterates through the dictionary and returns the (key==subject, value==score) pairs as a tuple, they are ordered
            if score>highest_score:
                highest_score = score
                highest_subj_name = subject
        return highest_subj_name

    def getFailedModules(self):
        failed = [] #array of failed modules, empty for now
        for subject, score in self.subjects.items():
            if score<40:
                failed.append(subject)
        print(f"Failed modules: {', '.join(failed)}")


    def addScore(self,SubjectCode,examScore):
        self.subjects.update({SubjectCode:examScore})

    def printScore(self):
        print(f'{self.name}:')
        for subject, score in self.subjects.items():
            print(f'{subject}: {score}')
        print("\n")
def testq1():
    print("Testing q1()....", end ="")
    assert(q1([1,6,57,38,838,364])==4)
    assert(q1([666,3492,6902,5,-14])==2)
    assert(q1([0,-52,-0.43,0])==0)
    assert(q1([-1,-1,-2,-4,-78])==0)
    print("Passed!")

def testq2():
    print("Testing q2()....", end ="")
    assert(q2([1,6,57,38,838,364])==[364,838,38,57,6,1])
    assert(q2([666,3492,6902,5,-14])==[-14,5,6902,3492,666])
    assert(q2([0,-52,-0.43,0])==[0,-0.43,-52,0])
    assert(q2([-1,-1,-2,-4,-78])==[-78,-4,-2,-1,-1])
    print("Passed!")

def main():
    testq1()
    testq2()
    q3([78,52,67,66,23])
    q4([78,52,67,66,23],65)
    print("\n")
    student1 = student("Poh Kuang Yi", "2201354", {'CSC1109':20,'CSC1108':77, 'INF1006':80})
    student1.printScore()
    student1.getBestExamScore()
    student1.getFailedModules()
    student1.addScore("INF1004",99)
    student1.printScore()
    student1.getBestExamScore()

main()
