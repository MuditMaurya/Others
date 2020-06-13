import urllib.request
import json
import os
Json=''
respond=''

def url_request(token,droplet_id=None,data=None):
    if len(data)>0:
        print('in loop '+str(data))
        request=urllib.request.Request('https://api.digitalocean.com/v2/droplets')
        request.add_header('Content-Type','application/json')
        request.add_header('Authorization','Bearer '+token)
        respond = urllib.request.urlopen(request,data)
    elif len(droplet_id)>0:
        request=urllib.request.Request('https://api.digitalocean.com/v2/droplets/'+droplet_id)
        request.add_header('Content-Type','application/json')
        request.add_header('Authorization','Bearer '+token)
        respond=urllib.request.urlopen(request,data)
    else:
        print("Something Went Wrong")
    return respond
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
#req = urllib.request.Request('https://api.digitalocean.com/v2/droplets')
#req.add_header('Content-Type', 'application/json')
#req.add_header('Authorization','Bearer '+token)
#respond = urllib.request.urlopen(req,data)
respond=url_request(token=token,data=data)
print (respond.read(1500))
formatted_respond=json.loads(respond)
droplet_id=(formatted_respond["droplet"]["id"])
respond=url_request(token=token,droplet_id=droplet_id)
print (respond.read(1000))
#req=urllib.request.Request('https://api')
