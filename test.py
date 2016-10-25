import os, re

def run(dir, root):
    try:
        for page in os.listdir(dir):
            try:
                content = open(dir + "/" + page).read()

                for link in re.findall("href=\"([^\"(/?)(/#)(/')(http://)]*)\"", content)+re.findall("src=\"([^\"(http://)]*)\"", content)+re.findall("Location: http://\" . $_SERVER['SERVER_NAME'] . \"([^\"]*)\"", content):
                    if(link == "#" or link == ""):
                        continue
                    elif(link[0] == "/"):
                        path = root+link
                    else:
                        path = dir + "/" + link
                    try:
                        try:
                            open(path).read()
                        except Exception as e:
                            open(path+"/index.php")
                    except Exception as e:
                        print("Unable to find file: " + path[len(root):] + "\t\t in file: " + dir[len(root):]+"/"+page)
                        return False


            except Exception as e:
                if not run(dir + "/" + page, root):
                    return False
    except Exception as e:
        print("Unable to open " + dir[len(root):] + " moving on")
    return True
