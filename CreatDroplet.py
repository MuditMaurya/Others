import urllib.request
import json
import urllib.parse
import os
token=os.getenv("DO_TOKEN")
body = json.dumps({
	"name":"example.com",
	"region":"nyc3",
	"size":"s-1vcpu-1gb",
	"image":"ubuntu-16-04-x64",
	"tags": ["mpmaurya"]
})
data=body.encode('ascii')
print(data)
req = urllib.request.Request('https://api.digitalocean.com/v2/droplets')
req.add_header('Content-Type', 'application/json')
req.add_header('Authorization','Bearer '+token) 
r = urllib.request.urlopen(req,data)
print(r.read(400))
