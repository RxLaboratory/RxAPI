"""Checks for updates for RxOT tools"""

from urllib.parse import quote
from urllib.request import urlopen
from json import loads
import platform

def checkUpdate(url, toolName, version, host, hostVersion, preRelease = False):
    """Checks if an update is available"""

    # Check os
    os  = platform.system()
    if os == "Windows":
        os = "win"
    elif os == "Darwin":
        os = "mac"
    elif os == "Linux":
        os = "linux"

    args = {
        "getVersion": "",
        "name": toolName,
        "version": version,
        "os": os,
        "osVersion": platform.version(),
        "host": host,
        "hostVersion": hostVersion
    }

    if preRelease:
        args["preRelease"] = ""

    response = request(url, args)
    return loads(response.read())

def request(url, args=None):
    """Builds a GET request with the args"""

    if args:
        first = True
        for arg in args:
            if first:
                url = url + '?'
                first = False
            else:
                url = url + '&'
            url = url + arg
            val = args[arg]
            if val != "":
                url = url + '=' + quote(val, safe='')
    response = urlopen(url)
    return response

if __name__ == "__main__":
    data = checkUpdate('https://api.rxlab.io', "DuBlast", "2.1.0", "Blender", "3.2.0")
    print(data)
