#!/bin/sh
wget https://dl.bintray.com/mitchellh/vagrant/vagrant_1.7.2_x86_64.deb
sudo dpkg -i vagrant_1.7.2_x86_64.deb
wget http://download.virtualbox.org/virtualbox/4.3.20/virtualbox-4.3_4.3.20-96996~Ubuntu~raring_amd64.deb
sudo dpkg -i virtualbox-4.3_4.3.20-96996\~Ubuntu\~raring_amd64.deb
sudo sh -c 'echo "deb http://download.virtualbox.org/virtualbox/debian trusty contrib" >> /etc/apt/sources.list'
sudo apt-get update
sudo apt-get install virtualbox-4.3
