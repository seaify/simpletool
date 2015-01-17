#!/bin/sh
yum update -y
yum install -y expect wget
wget https://raw.github.com/zpanel/installers/master/install/CentOS-6_4/10_1_1.sh
wget https://raw.githubusercontent.com/seaify/tools/master/quick-install/second-install-zpanel.sh | sh
