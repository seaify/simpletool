#!/bin/sh
#for centos
yum update
yum install -y wget curl gcc build-essential libxml2-dev libxslt1-dev python-dev python-lxml libffi-devel python-devel libxml2-devel libxslt-devel
curl https://raw.githubusercontent.com/pypa/pip/master/contrib/get-pip.py | python
pip install service_identity scrapy beautifulsoup4
