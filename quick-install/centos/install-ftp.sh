#!/bin/sh
yum update -y
yum -y install wget vsftpd
useradd elance
echo "elance6591" | passwd elance --stdin
wget https://raw.githubusercontent.com/seaify/tools/master/files/vsftpd.conf -O /etc/vsftpd/vsftpd.conf
pkill -f ftp
systemctl enable vsftpd 
systemctl start vsftpd 
