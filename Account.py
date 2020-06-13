import urllib.request
import os
token=os.getenv("DO_TOKEN")
print(token)
req = urllib.request.Request('https://api.digitalocean.com/v2/account')
req.add_header('Content-Type', 'application/json')
req.add_header('Authorization','Bearer '+token)
r = urllib.request.urlopen(req)
print(r.read(400))
