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

r = requests.get(
    "https://rxlaboratory.org/wp-json/wp/v2/users?roles=subscriber,customer&per_page=100&page=1",
    headers=headers,
    auth=wpAuth
    )

members = json.loads(r.text)
print(r.text)

print ("found " + str(len(members)) + " members")
count=0
for member in members:
    id = member['id']
    r = requests.get(
        "https://rxlaboratory.org/wp-json/pmpro/v1/get_membership_level_for_user?user_id=" + str(id),
        headers=headers,
        auth=wpAuth
    )
    level = json.loads(r.text)
    if level:
        count = count + 1

print ("found " + str(count) + " actual members")
