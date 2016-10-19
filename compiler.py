import os, inspect
import sys

def readFile():
    pass

def generatePages():
    dir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
    print(os.listdir(dir + "\pages"))
    try:
        os.mkdir(dir + "\compiled")
    except Exception as e:
        raise
    for page in os.listdir(dir + "\pages"):
        #generate folders and files
        pass









def main(args):
    generatePages()

main(sys.argv)
