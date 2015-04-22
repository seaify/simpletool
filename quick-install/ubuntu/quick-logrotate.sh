#!/bin/sh

sudo apt-get install --yes logrotate

format=" {\n
	copytruncate\n
	dateext\n
	daily\n
	rotate 7\n
	compress\n
	missingok\n
} ";

slash="*"

cpath=$(pwd)

content="$cpath""/$slash""$1""$format"
file_name=$(basename $cpath)
config_path="/etc/logrotate.d/$file_name"
echo $content
sudo echo $content > $config_path
sudo /usr/sbin/logrotate -f $config_path
