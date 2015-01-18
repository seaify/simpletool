#!/bin/sh
yum update -y
yum install -y git zsh autojump
git config --global user.email "dilin.life@gmail.com"
git config --global user.name "chuck.lei"
wget https://raw.githubusercontent.com/seaify/tools/master/files/.vimrc -O ~/.vimrc
