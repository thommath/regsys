import os, json, ftplib, inspect
from ftplib import FTP

def upload(folder="testing"):
    dir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
    json_file = open(".ftpconfig")
    data = json.load(json_file)
    ftp = FTP(data['host'])
    ftp.login(data['user'], data['pass'])

    ftp.cwd(data[folder])

    FtpRmTree(ftp, "")

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

def FtpRmTree(ftp, path):
    #"""Recursively delete a directory tree on a remote server."""
    wd = ftp.pwd()

    try:
        names = ftp.nlst(path)
    except ftplib.all_errors as e:
        # some FTP servers complain when you try and list non-existent paths
        return

    for name in names:
        if os.path.split(name)[1] in ('.', '..'): continue

        try:
            ftp.cwd(name)  # if we can cwd to it, it's a folder
            ftp.cwd(wd)  # don't try a nuke a folder we're in
            FtpRmTree(ftp, name)
        except ftplib.all_errors:
            ftp.delete(name)

    try:
        ftp.rmd(path)
    except ftplib.all_errors as e:
        print('FtpRmTree: Could not remove {0}: {1}'.format(path, e))
