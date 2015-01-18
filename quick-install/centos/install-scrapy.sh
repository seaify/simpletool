#!/bin/sh
#for centos
yum update -y
yum install -y openssl-devel wget curl gcc build-essential libxml2-dev libxslt1-dev python-dev python-lxml libffi-devel python-devel libxml2-devel libxslt-devel
curl https://raw.githubusercontent.com/pypa/pip/master/contrib/get-pip.py | python
wget http://launchpadlibrarian.net/58498441/pyOpenSSL-0.11.tar.gz -P /opt
cd /opt
tar zxvf pyOpenSSL-0.11.tar.gz 
cd pyOpenSSL-0.11
python setup.py install
pip uninstall -y six
pip install six==1.4.1
pip install service_identity scrapy beautifulsoup4
#service_identity
