#!/bin/sh
yum update -y
yum groupinstall -y "Development tools"
yum install -y zlib-devel bzip2-devel openssl-devel ncurses-devel sqlite-devel
yum install -y zlib1g-dev curl wget git zsh autojump xz-libs xz
wget http://www.python.org/ftp/python/2.7.6/Python-2.7.6.tar.xz
xz -d Python-2.7.6.tar.xz
tar -xvf Python-2.7.6.tar
cd Python-2.7.6
./configure --prefix=/usr/local
make && make altinstall
cp /usr/bin/python /usr/bin/python26
cp /usr/local/bin/python2.7 /usr/bin/python
wget --no-check-certificate https://pypi.python.org/packages/source/s/setuptools/setuptools-1.4.2.tar.gz
tar -xvf setuptools-1.4.2.tar.gz
cd setuptools-1.4.2
python setup.py install
curl https://raw.githubusercontent.com/pypa/pip/master/contrib/get-pip.py | python
