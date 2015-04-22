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
if [ ! -z "$2" ]
    then
        file_name=$2
fi
config_path="/etc/logrotate.d/$file_name"
echo $file_name
echo $1
echo $2
echo $content
echo $content > /tmp/test
sudo mv /tmp/test  $config_path
sudo /usr/sbin/logrotate -f $config_path
