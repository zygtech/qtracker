#!/usr/bin/env python3
"""Author: Krzysztof Hrybacz <krzysztof@zygtech.pl>"""
"""License: GNU General Public License -- version 3"""

import  urllib.parse, hashlib, datetime, sys, os
from urllib.request import urlopen
from pathlib import Path

def saveid(query):
    url = "https://zygtech.pl/qtracker/"
    path = os.path.dirname(os.path.abspath(__file__))
    if (len(sys.argv) == 1):
        queryurl = url + "querypopularity.php?q=" + urllib.parse.quote(query);
        response = urlopen(queryurl)
        content = response.read()
        f = open(path + "/places/" + hashlib.md5(query.encode('utf-8')).hexdigest() + ".txt", "a")
        d = datetime.datetime.now()
        f.write(d.strftime("%Y-%m-%d %H") + ": " + str(content).replace("'","").replace("b","") + "\n")
        f.close()
    else:
        if (sys.argv[1]=="init"):
            if not(Path(path + "/names").is_dir()):
                os.mkdir(path + "/names") 
            if not(Path(path + "/places").is_dir()):
                os.mkdir(path + "/places")
            f = open(path + "/names/" + hashlib.md5(query.encode('utf-8')).hexdigest() + ".txt", "w")
            f.write(query)
            f.close()

def main():
    saveid("Red Square Krasnaya ploshchad', Moskva, Russia, 109012")

if __name__ == '__main__':
    main()
