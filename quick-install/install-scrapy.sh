#!/bin/sh
#for ubuntu
apt-get update
apt-get install --yes gcc python-pip build-essential libxml2-dev libxslt1-dev python-dev python-lxml
pip install service_identity
pip install scrapy
pip install beautifulsoup4
