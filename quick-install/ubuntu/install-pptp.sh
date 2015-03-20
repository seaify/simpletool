#!/bin/sh
#for ubuntu14.04
apt-get install --yes pptpd pptp-linux
wget https://raw.githubusercontent.com/seaify/tools/master/files/pptpd.conf -O /etc/pptpd.conf
wget https://raw.githubusercontent.com/seaify/tools/master/files/pptpd-options -O /etc/ppp/pptpd-options
wget https://raw.githubusercontent.com/seaify/tools/master/files/chap-secrets -O /etc/ppp/chap-secrets
wget https://raw.githubusercontent.com/seaify/tools/master/files/sysctl.conf -O /etc/sysctl.conf
wget https://raw.githubusercontent.com/seaify/tools/master/files/rc.local -O /etc/rc.local
modprobe nf_conntrack_proto_gre nf_conntrack_pptp
/etc/init.d/pptpd restart
