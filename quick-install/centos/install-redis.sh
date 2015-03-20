#!/bin/sh
cd /usr/src
wget http://download.redis.io/releases/redis-2.8.13.tar.gz
tar xzf redis-2.8.13.tar.gz
cd redis-2.8.13
make
make install
