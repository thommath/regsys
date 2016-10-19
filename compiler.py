import os, inspect
import sys

def readFile():
    pass

def generatePages():
    dir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
    try:
        os.mkdir(dir + "/compiled")
    except Exception as e:
        pass
    generatePage(dir);

def generatePage(dir, subdir=""):
    path = dir + "/compiled/" + ((subdir + "/") if subdir != "" else "");
    for page in os.listdir(dir + "/pages" + (("/" + subdir) if subdir != "" else "")):
        #generate folders and files
        if page[len(page)-3:len(page)] == "php":
            print("making file " + page)
            file = open(path + page, 'w+')

            if page == "index.php":
                read = open(dir + "/head.php")
                file.write(read.read())
                read.close()

            read = open(dir + "/pages/" + ((subdir + "/") if subdir != "" else "") + page)
            file.write(read.read())
            read.close()

            if page == "index.php":
                read = open(dir + "/footer.php")
                file.write(read.read())
                read.close()

            file.close()
        elif '.' not in page:
            try:
                os.mkdir(path + page)
            except Exception as e:
                pass
            generatePage(dir, subdir+"/"+page if subdir != "" else page)
        else:
            print("making file " + page)
            file = open(path + page, 'w+')
            read = open(dir + "/pages/" + ((subdir + "/") if subdir != "" else "") + page)
            file.write(read.read())
            read.close()
            file.close()


def main(args):
    generatePages()

main(sys.argv)
