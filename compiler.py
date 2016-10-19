import os, inspect
import sys

def readFile():
    pass

def generatePages():
    dir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
    print(os.listdir(dir + "/pages"))
    try:
        os.mkdir(dir + "/compiled")
    except Exception as e:
        pass

    for page in os.listdir(dir + "/pages"):
        #generate folders and files
        try:
            os.mkdir(dir + "/compiled/" + page)
        except Exception as e:
            pass

        file = open(dir + '/compiled/' + page + '/index.php', 'w+')
        read = open(dir + '/pages/' + page + '/index.php')
#        file.write()
        print(read.read())
#        file.write(read.read())
        read.close()
        file.close()










def main(args):
    generatePages()

main(sys.argv)
