#!/bin/sh
mkdir ~/opensource
sudo apt-get install zsh autojump
git clone https://github.com/robbyrussell/oh-my-zsh ~/.oh-my-zsh
git clone https://github.com/zsh-users/zsh-syntax-highlighting.git ~/opensource
git clone https://github.com/zsh-users/zsh-history-substring-search.git ~/opensource
wget https://github.com/seaify/tools/blob/master/files/.zshrc ~/.zshrc
