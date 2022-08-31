from email import header
import requests
import json

wpAuth = (
    'user',
    'password'
    )

headers = {
    'Accept': 'application/json',
    'Content-Type': 'application/json;charset=utf-8',
    'User-Agent': 'RxAPI/2.0 (Python)'
}

"""r = requests.get(
    "https://api.rxlab.io/?getVersion&name=Duik&version=17.0.0",
    headers=headers,
    auth=wpAuth
    )

print(r.text)

r = requests.get(
    "https://api.rxlab.io/?getStats",
    headers=headers,
    auth=wpAuth
    )

print(r.text)"""

r = requests.get(
    "https://api.rxlab.io/whois.php",
    headers=headers,
    auth=wpAuth
    )

print(r.text)