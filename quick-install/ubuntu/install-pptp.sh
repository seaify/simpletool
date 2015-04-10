#!/bin/sh
#for ubuntu14.04
sudo apt-get install --yes pptpd pptp-linux
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/pptpd.conf -O /etc/pptpd.conf
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/pptpd-options -O /etc/ppp/pptpd-options
sudo echo "$1 * $2 *" >> /etc/ppp/chap-secrets
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/sysctl.conf -O /etc/sysctl.conf
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/rc.local -O /etc/rc.local
sudo modprobe nf_conntrack_proto_gre nf_conntrack_pptp
sudo /etc/init.d/pptpd restart
