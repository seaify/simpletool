#!/bin/sh
curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-zsh.sh | sh
curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-pip-1.3.sh | sh
mkdir -p /etc/supervisord/conf.d
wget https://raw.githubusercontent.com/seaify/tools/master/files/supervisord.conf -O /etc/supervisord.conf 
wget https://raw.githubusercontent.com/seaify/tools/master/files/.gitconfig -O ~/.gitconfig
wget https://raw.githubusercontent.com/seaify/tools/master/files/.vimrc -O ~/.vimrc
apt-get install --yes nginx gcc python-pip build-essential libxml2-dev libxslt1-dev python-dev python-lxml python-tk watch-dog
pip install service_identity scrapy beautifulsoup4 wechat_sdk supervisor gunicorn flask
