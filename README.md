## 简介
后台服务开发过程中，总是需要做一些重复的事情，如安装zsh, ftp等，所以将使用过的服务做成了一键安装脚本，避免重复，程序员已经够苦了，不应该再在这种屁事上浪费生命。

开发过程中常用的工具，如一键安装vpn, ss, zsh, 以及配置文件如vimrc, zshrc等, 注意以下安装脚本仅在ubuntu 14.04下经过测试。

## 一键安装脚本

### 安装pptp vpn服务
参考文档https://help.ubuntu.com/community/PPTPServer
执行下述命令，将创建一个pptp账户，用户名为user，密码为passwd
```sh
curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-pptp.sh | sh -s -- user passwd
```
### 安装vsftp服务
执行下述命令，将创建一个ftp账户，用户名为chuck，密码为love
```sh
curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-ftp.sh | sh -s chuck love
```

### 安装shadowsocks server和client
参考文档: https://github.com/shadowsocks/shadowsocks/wiki, 和https://github.com/shadowsocks/shadowsocks/wiki/Configuration-via-Config-File
执行下述命令，将创建一个shaowsocks server密码为love。使用supervisord管理shadowsocks服务，为supervisord增加了开机启动脚本，所以每次重启, shadowsocks服务也会跟着启动。
```sh
curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-shadowsock-server.sh | sh -s -- love
```

shadowsocks client参考https://github.com/shadowsocks/shadowsocks/wiki/Ports-and-Clients，就可以了，mac, ubuntu, windows, iphone, android经测试都可以正常使用，但iphone要越狱


### 安装zsh, 已经配置好相应插件
使用zle-vi-visual vi-mode git-prompt autojump history history-substring-search jump sudo 这些插件。
视频讲解: http://v.youku.com/v_show/id_XODkyNTc0NDIw.html
```
 curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-zsh.sh | sh
```

## Bugs and Feature Requests
有bug或者feature的requests，欢迎提交！
