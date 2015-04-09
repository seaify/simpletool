# Path to your oh-my-zsh installation.
export ZSH=$HOME/.oh-my-zsh

# Set name of the theme to load.
# Look in ~/.oh-my-zsh/themes/
# Optionally, if you set this to "random", it'll load a random theme each
# time that oh-my-zsh is loaded.
ZSH_THEME="robbyrussell"


# Uncomment the following line to use case-sensitive completion.
# CASE_SENSITIVE="true"

# Uncomment the following line to disable bi-weekly auto-update checks.
# DISABLE_AUTO_UPDATE="true"

# Uncomment the following line to change how often to auto-update (in days).
# export UPDATE_ZSH_DAYS=13

# Uncomment the following line to disable colors in ls.
# DISABLE_LS_COLORS="true"

# Uncomment the following line to disable auto-setting terminal title.
# DISABLE_AUTO_TITLE="true"

# Uncomment the following line to enable command auto-correction.
# ENABLE_CORRECTION="true"

# Uncomment the following line to display red dots whilst waiting for completion.
# COMPLETION_WAITING_DOTS="true"

# Uncomment the following line if you want to disable marking untracked files
# under VCS as dirty. This makes repository status check for large repositories
# much, much faster.
# DISABLE_UNTRACKED_FILES_DIRTY="true"

# Uncomment the following line if you want to change the command execution time
# stamp shown in the history command output.
# The optional three formats: "mm/dd/yyyy"|"dd.mm.yyyy"|"yyyy-mm-dd"
# HIST_STAMPS="mm/dd/yyyy"

# Would you like to use another custom folder than $ZSH/custom?
# ZSH_CUSTOM=/path/to/new-custom-folder

# Which plugins would you like to load? (plugins can be found in ~/.oh-my-zsh/plugins/*)
# Custom plugins may be added to ~/.oh-my-zsh/custom/plugins/
# Example format: plugins=(rails git textmate ruby lighthouse)
# Add wisely, as too many plugins slow down shell startup.
plugins=(zle-vi-visual vi-mode git-prompt autojump history history-substring-search jump sudo)
#plugins=(zle-vi-visual vi-mode git-prompt django pip z autojump autopep8 copyfile history history-substring-search jump tmuxinator web-search sudo)
#plugins=(git-prompt django pip z autojump autopep8 copyfile history-substring-search jump tmuxinator web-search sudo)


source $ZSH/oh-my-zsh.sh


[[ -s ~/.autojump/etc/profile.d/autojump.zsh ]] && . ~/.autojump/etc/profile.d/autojump.zsh

source ~/opensource/zsh-git-prompt/zshrc.sh
source ~/opensource/zsh-syntax-highlighting/zsh-syntax-highlighting.zsh
source ~/opensource/zsh-history-substring-search/zsh-history-substring-search.zsh

bindkey -M vicmd 'k' history-substring-search-up
bindkey -M vicmd 'j' history-substring-search-down

#zmodload zsh/terminfo
#bindkey "$terminfo[kcuu1]" history-substring-search-up
#bindkey "$terminfo[kcud1]" history-substring-search-down
# an example prompt
PROMPT='$fg[red]%}%n@%m%{$fg[green]%}:%B%~%b$(git_super_status) %# '

# User configuration
export PATH=~/Dropbox/BackUp/bin:~/opensource/mongodb/bin:$PATH
export PYTHONPATH=~/togic:~/togic/warehouse:$PYTHONPATH

export PATH=~/opensource/phpfarm/inst/current-bin:~/opensource/phpfarm/inst/bin:~/.dropbox-dist:$HOME/bin:/usr/local/bin:$PATH

# export MANPATH="/usr/local/man:$MANPATH"

# You may need to manually set your language environment
# export LANG=en_US.UTF-8

# Preferred editor for local and remote sessions
# if [[ -n $SSH_CONNECTION ]]; then
#   export EDITOR='vim'
# else
#   export EDITOR='mvim'
# fi
export EDITOR='vim'

# Compilation flags
# export ARCHFLAGS="-arch x86_64"

# ssh
# export SSH_KEY_PATH="~/.ssh/dsa_id"

# Set personal aliases, overriding those provided by oh-my-zsh libs,
# plugins, and themes. Aliases can be placed here, though oh-my-zsh
# users are encouraged to define aliases within the ZSH_CUSTOM folder.
# For a full list of active aliases, run `alias`.
#
# Example aliases
# alias zshconfig="mate ~/.zshrc"
# alias ohmyzsh="mate ~/.oh-my-zsh"
export PHPBREW_SET_PROMPT=1

#source ~/.phpbrew/bashrc

alias ls="ls -l"
alias ga="git add"
alias gco="git checkout"
alias gc="git commit"
alias gs="git status"
alias composer="php ~/opensource/composer.phar "
function take () {
    mkdir $1
    cd $1
}

function server () {
    if [ $1 ]
    then
        local port="$1"
    else
        local port="8000"
    fi
    open "http://localhost:$port" && python -m SimpleHTTPServer "$port"
}

alias mongooffline="mongo -u togic -p 'togic4you!@Y' --authenticationDatabase admin"
alias mongoonline="mongo  -u togic -p 'togic4youonline' --authenticationDatabase admin "
alias biggest='find -type f -printf '\''%s %p\n'\'' | sort -nr | head -n 40 | gawk "{ print \$1/1000000 \" \" \$2 \" \" \$3 \" \" \$4 \" \" \$5 \" \" \$6 \" \" \$7 \" \" \$8 \" \" \$9 }"'
function url-encode; {
            setopt extendedglob
                    echo "${${(j: :)@}//(#b)(?)/%$[[##16]##${match[1]}]}"
}

#export HOST="hello"
#export SOCKS_SERVER=127.0.0.1:1080
export DOCKER_TLS_VERIFY=1
export DOCKER_HOST=tcp://192.168.59.103:2376
export DOCKER_CERT_PATH=/Users/chuck/.boot2docker/certs/boot2docker-vm

# Search google for the given keywords.
function google; {
            $VIEW "http://www.google.com/search?q=`url-encode "${(j: :)@}"`"
}
export NODE_PATH="/usr/local/lib/node_modules"
