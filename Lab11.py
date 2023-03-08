class calculator():
    
    def __init__(self):
        self.prevAns = None

    def adder(self):
        input1 = float(input("input1: "))
        truncd1 = roundHalfUp(input1)
        if almostEqual(input1,truncd1):
            input1 = truncd1
        input2 = float(input("input2: "))
        truncd2 = roundHalfUp(input2)
        if almostEqual(input1,truncd2):
            input2 = truncd2
        self.prevAns = input1 + input2
        truncdAns = int(self.prevAns)
        if almostEqual(self.prevAns,truncdAns):
            self.prevAns = int(self.prevAns)
        return self.prevAns

    def subtractor(self):
        input1 = float(input("input1: "))
        truncd1 = roundHalfUp(input1)
        if almostEqual(input1,truncd1):
            input1 = truncd1
        input2 = float(input("input2: "))
        truncd2 = roundHalfUp(input2)
        if almostEqual(input1,truncd2):
            input2 = truncd2
        self.prevAns = input1 - input2
        truncdAns = int(self.prevAns)
        if almostEqual(self.prevAns,truncdAns):
            self.prevAns = int(self.prevAns)     
        return self.prevAns
    
    def multiplier(self):
        input1 = float(input("input1: "))
        truncd1 = roundHalfUp(input1)
        if almostEqual(input1,truncd1):
            input1 = truncd1
        input2 = float(input("input2: "))
        truncd2 = roundHalfUp(input2)
        if almostEqual(input1,truncd2):
            input2 = input2
        self.prevAns = input1 * input2
        truncdAns = int(self.prevAns)
        if almostEqual(self.prevAns,truncdAns):
            self.prevAns = int(self.prevAns)
        return self.prevAns
    
    def clear(self):
        self.prevAns = 0

        return self.prevAns

    def divider(self):
        try:
            input1 = float(input("input1: "))
            input2 = float(input("input2: "))
            truncd1 = roundHalfUp(input1)
            if almostEqual(input2,0):
                raise ZeroDivisionError
            if almostEqual(input1,truncd1):
                input1 = truncd1
            truncd2 = roundHalfUp(input2)
            if almostEqual(input1,truncd2):
                input2 = input2
        except ZeroDivisionError:
            return "Can't divide by 0!"
        self.prevAns = input1/input2
        truncdAns = int(self.prevAns)
        if almostEqual(self.prevAns,truncdAns):
            self.prevAns = int(self.prevAns)
        return self.prevAns

class clockTime():

    def __init__(self):
        self.time = None
        self.hours = None
        self.minutes = None
        self.seconds = None
    
    def setHours(self):
        try:
            hours = int(input("Enter hours: "))
            if hours < 0:
                raise ValueError
            if hours > 23:
                raise moreThanAllowedError
        except (ValueError, moreThanAllowedError) as e:
            if isinstance(e, moreThanAllowedError):
                print("Cannot be more than 23 Hours")
                return self.setHours()
            elif isinstance(e, ValueError):
                print("Cannot have negative hours")
                return self.setHours()
        self.hours = str(hours) 

    def setMinutes(self):
        try:
            minutes = int(input("Enter Minutes: "))
            if minutes < 0:
                raise ValueError
            if minutes > 59:
                raise moreThanAllowedError
        except (ValueError, moreThanAllowedError) as e:
            if isinstance(e, moreThanAllowedError):
                print("Cannot be more than 59 Minutes")
                return self.setMinutes()
            elif isinstance(e, ValueError):
                print("Cannot have negative Minutes")
                return self.setMinutes()
        if minutes < 10:
            self.minutes = "0"+str(minutes)
        else:
            self.minutes = str(minutes) 
    
    def setSeconds(self):
        try:
            seconds = int(input("Enter Seconds: "))
            if seconds < 0:
                raise ValueError
            if seconds > 59:
                raise moreThanAllowedError
        except (ValueError, moreThanAllowedError) as e:
            if isinstance(e, moreThanAllowedError):
                print("Cannot be more than 59 Seconds")
                return self.setSeconds()
            elif isinstance(e, ValueError):
                print("Cannot have negative Seconds")
                return self.setSeconds()
        if seconds < 10:
            self.seconds = "0"+str(seconds)
        else:
            self.seconds = str(seconds) 

    def setTime(self):
        print("Set hours: ", end ="")
        self.setHours()
        print("Set minutes: ", end = "")
        self.setMinutes()
        print("Set Seconds: ", end = "")
        self.setSeconds()

    def clearTime(self):
        self.hours = None
        self.minutes = None
        self.seconds = None
        return print("Successfully cleared timed")

    def showTime(self):
        if self.hours == None or self.minutes == None or self.seconds == None:
            return "Time is not properly set yet"
        return f'{self.hours}Hours:{self.minutes}Minutes:{self.seconds}Seconds.'   

class moreThanAllowedError(ValueError):
    pass

def almostEqual(val1, val2, epsilon=10**-7):
    return (abs(val1 - val2) < epsilon)
    
import decimal
def roundHalfUp(d): #helper function
    rounding = decimal.ROUND_HALF_UP
    return int(decimal.Decimal(d).to_integral_value(rounding=rounding))

print("Question 1:")
print("_________________")
parser = calculator()
print("For adder method: ")
print(parser.adder())
print("For subtractor method: ")
print(parser.subtractor())
print("For multiplier method: ")
print(parser.multiplier())
print("For divider method: ")
print(parser.divider())
print("For ZeroDivision error handling on divider method: ")
print(parser.divider())
print("For clear method: ")
print("Before: ")
print(parser.prevAns)
print("After: ")
parser.clear()
print(parser.prevAns)
print("\n")
print("Question 2: ")
print("_________________")
clock = clockTime()
print("For error Handling on undisplayable times")
print(clock.showTime())
print("For setHours method")
clock.setHours()
print("For setMinutes method")
clock.setMinutes()
print("For setSeconds method")
clock.setSeconds()
print("Displaying time:")
print(clock.showTime())
print("For setTime method")
clock.setTime()
print(clock.showTime())
print("For out of range settings")
clock.setTime()
print(clock.showTime())
