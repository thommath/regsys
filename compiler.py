import os, inspect, sys, re, json
from ftplib import FTP

def readFile():
    pass

def generatePages():
    dir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
    try:
        os.mkdir(dir + "/compiled")
    except Exception as e:
        pass
    print("Generating components")
    generateComponents(dir)
    print("Done with components")
    generatePage(dir);
    print("Done with pages")

def generateComponents(dir, subdir=""):
    path = dir + "/compiled/" + ((subdir + "/") if subdir != "" else "");
    for page in os.listdir(dir + "/components" + (("/" + subdir) if subdir != "" else "")):
        #generate folders and files
        if page[len(page)-3:len(page)] == "php":
            print("making file " + ((subdir + "/") if subdir != "" else "") + page)
            file = open(path + page, 'w+')

            #Read content file
            read = open(dir + "/components/" + ((subdir + "/") if subdir != "" else "") + page)
            content = read.read()

            content = insertDependencies(dir, content)
#            content = replaceRefs(content)
            file.write(content)

            file.close()
        elif '.' not in page:
            try:
                os.mkdir(path + page)
            except Exception as e:
                pass
            generateComponents(dir, subdir+"/"+page if subdir != "" else page)
        else:
            print("making file " + page)
            file = open(path + page, 'w+')
            read = open(dir + "/components/" + ((subdir + "/") if subdir != "" else "") + page)
            file.write(read.read())
            read.close()
            file.close()

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
            dep = [[],[],[]]
            if content[0:4] == "dep:":
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
                        if temp[len(temp)-3:len(temp)] == "php":
                            dep[2].append(temp)
                        temp = ""
                    else:
                        temp += c
                content = content[length:]

            #Use file template instead
            read = open(dir + "/template.php")
            template = read.read()
            read.close()


            css = ""
            for style in dep[0]:
                css += "<link rel=\"stylesheet\" href=" + style + ">\n"
            js = ""
            for javascript in dep[1]:
                js += "<script src=\"" + javascript + "\" charset=\"utf-8\"></script>\n"
            php = ""
            for personahomepage in dep[2]:
                fil = open(path + personahomepage)
                php += fil.read() + "\n";
                fil.close()

            template = template.replace("<!--style-->", css)
            template = template.replace("<!--js-->", js)
            template = template.replace("<!--content-->", content)
            template = template.replace("<!--php-->", php)

            content = template

            content = insertDependencies(dir, content)
#            content = replaceRefs(content)
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

def replaceRefs(content):
    for href in re.findall("href=\"\/(.*)\"", content):
        content = content.replace("href=\"/" + href + "\"", "href=\"/beta/" + href + "\"")
    for src in re.findall("src=\"\/(.*)\"", content):
        content = content.replace("src=\"/" + src + "\"", "src=\"/beta/" + src + "\"")
    return content


def upload(folder="testing"):
    dir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
    json_file = open(".ftpconfig")
    data = json.load(json_file)
    ftp = FTP(data['host'])
    ftp.login(data['user'], data['pass'])

    ftp.cwd(data[folder])

    uploadFile(ftp, dir+"/compiled/")
    ftp.cwd(data[folder])
    uploadFile(ftp, dir + "/", "dependencies")
    uploadFile(ftp, dir + "/", "components")
    ftp.close()

def uploadFile(ftp, dir, file="", wd=""):
    path = dir + wd + file;
    if "." in file:
        print("Uploading file " + file)
        fil = open(path, 'rb')
        ftp.storbinary("STOR " + file, fil)
        fil.close()
    else:
        try:
            print("Making dir " + file)
            ftp.mkd(file)
        except Exception as e:
            pass
        ftp.cwd(file)
        wd += file+"/"
        for page in os.listdir(path):
            uploadFile(ftp, dir, page, wd)
        ftp.cwd("..")

def testing():
    phperror = "<br />\n<b>Warning</b>:"

def main(args):
    generatePages()
    if(len(args) > 1 and args[1] == "prodset"):
        upload("real")
    else:
        upload()

main(sys.argv)
