#!/bin/sh
yum update -y
yum install -y expect wget mysql-community-server
yum install -y http://dev.mysql.com/get/mysql-community-release-el7-5.noarch.rpm
systemctl start mysqld
wget https://raw.github.com/zpanel/installers/master/install/CentOS-6_4/10_1_1.sh -O /root/10_1_1.sh
wget https://raw.githubusercontent.com/seaify/tools/master/quick-install/centos/second-install-zpanel.sh -O /root/second-install-zpanel.sh
chmod +x /root/second-install-zpanel.sh
cd /root
./second-install-zpanel.sh
