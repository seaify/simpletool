#!/bin/sh
curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-zsh.sh | sudo sh
curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-pip-1.3.sh | sudo sh
sudo mkdir -p /etc/supervisord/conf.d
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/supervisord.conf -O /etc/supervisord.conf 
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/.gitconfig -O ~/.gitconfig
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/.vimrc -O ~/.vimrc
sudo apt-get install --yes build-essential libxml2-dev libxslt1-dev python-dev redis-server nginx gcc python-pip build-essential libxml2-dev libxslt1-dev python-dev python-lxml python-tk watch-dog
sudo pip install werkzeug jinja2 celery service_identity scrapy beautifulsoup4 wechat_sdk supervisor gunicorn flask redis
