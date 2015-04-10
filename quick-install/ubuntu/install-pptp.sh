#!/bin/sh
#for ubuntu14.04
sudo apt-get install --yes pptpd pptp-linux
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/pptpd.conf -O /etc/pptpd.conf
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/pptpd-options -O /etc/ppp/pptpd-options
sudo bash -c "echo '$1 * $2 *' >> /etc/ppp/chap-secrets"
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/sysctl.conf -O /etc/sysctl.conf
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/rc.local -O /etc/rc.local
sudo modprobe nf_conntrack_proto_gre nf_conntrack_pptp
sudo /etc/init.d/pptpd restart
sudo iptables -t nat -A POSTROUTING -s 192.168.0.0/24 -o eth0 -j MASQUERADE
sudo iptables -A FORWARD -p tcp --syn -s 192.168.0.0/24 -j TCPMSS --set-mss 1356
