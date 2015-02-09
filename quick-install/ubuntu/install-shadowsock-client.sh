#!/bin/sh
sudo apt-get update
sudo apt-get --yes install python-pip python-m2crypto supervisor
pip install shadowsocks
$ip=`curl http://icanhazip.com/`
//sed replace better
echo $ip
