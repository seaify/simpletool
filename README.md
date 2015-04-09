开发过程中常用的工具，如一键安装vpn, ss, zsh, 以及配置文件如vimrc, zshrc等, 注意以下安装脚本仅在ubuntu 14.04下经过测试。

## 一键安装脚本

### 安装pptp vpn
根据文档https://help.ubuntu.com/community/PPTPServer来安装pptp
```
curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-pptp.sh | sh
```


### 安装shadowsocks server
 curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-shadowsock-server.sh | sh

### 安装vsftp
 curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-ftp.sh | sh

### 安装zsh, 已经配置好相应插件
 curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-zsh.sh | sh
