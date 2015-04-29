#!/bin/sh
sudo apt-get -y install ruby ruby1.9.1-dev
mkdir ~/opensource
cd ~/opensource
wget http://production.cf.rubygems.org/rubygems/rubygems-2.4.6.zip
unzip rubygems-2.4.6.zip
cd rubygems-2.4.6
sudo ruby setup.rb
sudo gem install bundler
