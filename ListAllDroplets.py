import urllib.request
import os
token=os.getenv("DO_TOKEN")
req = urllib.request.Request('https://api.digitalocean.com/v2/droplets?page=1&per_page=1')
req.add_header('Content-Type', 'application/json')
req.add_header('Authorization','Bearer '+token)
r = urllib.request.urlopen(req)
stuff=(r.read(2000))
print(stuff)
