import urllib.request
import os
token=os.getenv("DO_TOKEN")
droplet_id=input("Enter the Droplet that you want to delete : ")
req = urllib.request.Request('https://api.digitalocean.com/v2/droplets/'+str(droplet_id),method='DELETE')
req.add_header('Content-Type', 'application/json')
req.add_header('Authorization','Bearer '+token)
r = urllib.request.urlopen(req)
stuff=(r.read(2000))
print(stuff)
