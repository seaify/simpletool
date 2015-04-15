#!/bin/sh
sudo apt-get --yes install nginx python-pip python-m2crypto supervisor build-essential python-dev
BASEDIR="$PWD"
CURRENT=$(basename $BASEDIR)
PORT=8080
echo $2
if [ ! -z "$2" ]
    then
        PORT=$2
fi
echo $CURRENT
sudo bash -c "curl -X POST http://template.seaify.com/get_template --data 'template_id=2&domain=$1&port=$PORT' > /etc/nginx/sites-enabled/$CURRENT.conf"
config="\n[program:$CURRENT]\ncommand=python -m SimpleHTTPServer $PORT\nautorestart=true\ndirectory=$BASEDIR\nuser=root"
echo $config > /tmp/$CURRENT.conf
sudo mv /tmp/$CURRENT.conf /etc/supervisor/conf.d/$CURRENT.conf
sudo service nginx reload
sudo service supervisor restart
