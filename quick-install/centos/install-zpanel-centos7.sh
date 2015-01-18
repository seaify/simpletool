#!/bin/sh
yum update -y
yum install -y expect wget
wget https://raw.githubusercontent.com/zpanel/installers/master/install/beta/CentOS_7/beta-Centos-7-10.1.1.sh  -O /root/10_1_1.sh
wget https://raw.githubusercontent.com/seaify/tools/master/quick-install/centos/second-install-zpanel.sh -O /root/second-install-zpanel.sh
chmod +x /root/second-install-zpanel.sh
cd /root
./second-install-zpanel.sh
