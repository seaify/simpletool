#!/bin/sh
sudo apt-get update
sudo apt-get --yes install git zsh autojump
mkdir ~/opensource
cd ~/opensource
git clone https://github.com/robbyrussell/oh-my-zsh ~/.oh-my-zsh
git clone https://github.com/zsh-users/zsh-syntax-highlighting.git
git clone https://github.com/zsh-users/zsh-history-substring-search.git
git clone https://github.com/olivierverdier/zsh-git-prompt.git
cd ~
wget https://raw.githubusercontent.com/seaify/tools/master/files/.zshrc -O ~/.zshrc
sudo chsh -s $(which zsh)
zsh
