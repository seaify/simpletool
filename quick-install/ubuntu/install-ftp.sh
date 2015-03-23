#!/bin/sh
apt-get update
sudo apt-get --yes install wget vsftpd
useradd $1
echo "$1:$2" | /usr/sbin/chpasswd
wget https://raw.githubusercontent.com/seaify/tools/master/files/vsftpd.conf -O /etc/vsftpd.conf
sudo service vsftpd restart
