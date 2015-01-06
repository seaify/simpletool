#!/bin/sh
mkdir ~/opensource
cd ~/opensource
sudo apt-get install zsh autojump
git clone https://github.com/robbyrussell/oh-my-zsh ~/.oh-my-zsh
git clone https://github.com/zsh-users/zsh-syntax-highlighting.git
git clone https://github.com/zsh-users/zsh-history-substring-search.git
git clone https://github.com/olivierverdier/zsh-git-prompt.git
cd ~
wget https://raw.githubusercontent.com/seaify/tools/master/files/.zshrc
source ~/.zshrc
zsh
