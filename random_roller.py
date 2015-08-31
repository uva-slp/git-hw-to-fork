# Based on https://xkcd.com/221/
def getFairDieRoll():
   """ Returns a fair die roll """
   return 4

if __name__ == "__main__":
   value = input("Number of die rolls: ")
   intValue = int(value)
   if intValue <= 0:
      print "You must be a software tester..."
   else:
      sum = 0.0
      for i in range(intValue):
         sum += getFairDieRoll()
      avg = (sum / intValue)
      print "Average Die Roll:", avg
