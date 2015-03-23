#!/bin/sh
sudo apt-get update
sudo apt-get --yes install python-pip python-m2crypto supervisor build-essential python-dev
pip install shadowsocks gevent
ip=$(curl http://icanhazip.com/)
echo $ip
curl -X POST http://template.seaify.com/get_template --data "template_id=1&server=$ip&password=$1" > /etc/shadowsocks-config.json
config="\n[program:shadowsocks]\ncommand=ssserver -c /etc/shadowsocks-config.json\nautorestart=true\nuser=root"
echo $config > /etc/supervisor/conf.d/shadowsocks.conf
service supervisor restart
