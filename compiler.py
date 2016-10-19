import os, inspect, sys, re

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
            print("making file " + ((subdir + "/") if subdir != "" else "") + page)
            file = open(path + page, 'w+')

            #Read content file
            read = open(dir + "/pages/" + ((subdir + "/") if subdir != "" else "") + page)
            content = read.read()

            #Checking for dependencies
            dep = [[],[]]
            if content[0:3] == "dep:":
                temp = ""
                length = 4
                for c in content[4:]:
                    length += 1
                    if c == '\n':
                        break
                    elif c == ';':
                        if temp[len(temp)-3:len(temp)] == "css":
                            dep[0].append(temp)
                        if temp[len(temp)-2:len(temp)] == "js":
                            dep[1].append(temp)
                        temp = ""
                    else:
                        temp += c
                content = content[length:]

            #Use file template instead
            if page == "index.php":
                read = open(dir + "/template.php")
                template = read.read()
                read.close()


                css = ""
                for style in dep[0]:
                    css += "<link rel=\"stylesheet\" href=" + style + ">\n"
                js = ""
                for javascript in dep[1]:
                    js += "<script src=" + javascript + " charset=\"utf-8\"></script>\n"

                template = template.replace("<!--style-->", css)
                template = template.replace("<!--js-->", js)
                template = template.replace("<!--content-->", content)

                content = template

            content = insertDependencies(dir, content)
            file.write(content)

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

def insertDependencies(dir, content):
    for require in re.findall("require_once\(\"(.*)\"\);", content):
        read = open(dir + "/" + require)
        content = content.replace("require_once(\"" + require + "\");", insertDependencies(dir, read.read()))
    return content

def main(args):
    generatePages()

main(sys.argv)
