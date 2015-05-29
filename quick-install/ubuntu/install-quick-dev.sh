#!/bin/sh
sudo apt-add-repository ppa:brightbox/ruby-ng
sudo apt-get update
sudo apt-get install --yes unzip build-essential mysql-client-5.5 python-mysqldb libxml2-dev libxslt1-dev python-dev redis-server nginx gcc python-pip  python-lxml python-tk watchdog ruby2.2 ruby2.2-dev rubygems-integration
sudo gem install nokogiri -v '1.6.6.2'
sudo useradd $1
sudo mkdir "/home/$1"
sudo chown "$1:$1" "/home/$1"
sudo echo "$1:$2" | /usr/sbin/chpasswd
sudo adduser $1 sudo
curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-zsh.sh | sh
curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-pip-1.3.sh | sh
sudo pip install werkzeug jinja2 celery service_identity scrapy beautifulsoup4 wechat_sdk supervisor gunicorn flask redis
sudo mkdir -p /etc/supervisord/conf.d
sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/supervisord.conf -O /etc/supervisord.conf
wget https://raw.githubusercontent.com/seaify/tools/master/files/.gitconfig -O ~/.gitconfig
wget https://raw.githubusercontent.com/seaify/tools/master/files/.vimrc -O ~/.vimrc
sudo wget https://gist.github.com/howthebodyworks/176149/raw/88d0d68c4af22a7474ad1d011659ea2d27e35b8d/supervisord.sh -O /etc/init.d/supervisord
sudo chmod +x /etc/init.d/supervisord
sudo update-rc.d supervisord defaults
sudo service supervisord restart
#mysql-server-5.5

