import json
json_data='{"droplet":{"id":128915946,"name":"example.com","memory":1024,"vcpus":1,"disk":25,"locked":true,"status":"new","kernel":null,"created_at":"2019-01-16T20:24:46Z","features":[],"backup_ids":[],"next_backup_window":null,"snapshot_ids":[],"image":{"id":41695378,"name":"16.04.5 x64","distribution":"Ubuntu","slug":"ubuntu-16-04-x64","public":true,"regions":["nyc1","sfo1","nyc2","ams2","sgp1","lon1","nyc3","ams3","fra1","tor1","sfo2","blr1"],"created_at":"2018-12-24T01:32:00Z","min_disk_size":20,"type":"snapshot","size_gigabytes":0.31,"description":"Ubuntu 16.04.5 x64 20181224","tags":[],"status":"available","error_message":""},"volume_ids":[],"size":{"slug":"s-1vcpu-1gb","memory":1024,"vcpus":1,"disk":25,"transfer":1.0,"price_monthly":5.0,"price_hourly":0.00744,"regions":["ams2","ams3","blr1","fra1","lon1","nyc1","nyc2","nyc3","sfo1","sfo2","sgp1","tor1"],"available":true},"size_slug":"s-1vcpu-1gb","networks":{"v4":[],"v6":[]},"region":{"name":"New York 3","slug":"nyc3","features":["private_networking","backups","ipv6","metadata","install_agent","storage","image_transfer"],"available":true,"sizes":["512mb","1gb","2gb","4gb","8gb","16gb","s-1vcpu-3gb","m-1vcpu-8gb","s-3vcpu-1gb","s-1vcpu-2gb","s-2vcpu-2gb","s-2vcpu-4gb","s-4vcpu-8gb","s-6vcpu-16gb","s-1vcpu-1gb"]},"tags":["mpmaurya"]},"links":{"actions":[{"id":611131716,"rel":"create","href":"https://api.digitalocean.com/v2/actions/611131716"}]}}'
jsond=json.loads(json_data)
print (jsond["droplet"]["region"]["name"])
print (jsond["droplet"]["size"])