#!/bin/sh
sudo apt-get update
sudo apt-get --yes install wget vsftpd
sudo useradd "$1"
sudo mkdir "/home/$1"
sudo chown "$1:$1" "/home/$1"
sudo bash -c "echo '$1:$2' | /usr/sbin/chpasswd"
sudo rm /etc/pam.d/vsftpd
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/vsftpd.conf -O /etc/vsftpd.conf
sudo service vsftpd restart
