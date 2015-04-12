## 简介
后台服务开发过程中，总是需要做一些重复的事情，如安装zsh, ftp等，所以将使用过的服务做成了一键安装脚本，避免重复，程序员已经够苦了，不应该再在这种屁事上浪费生命。

开发过程中常用的工具，如一键安装vpn, ss, zsh, 以及配置文件如vimrc, zshrc等, 注意以下安装脚本仅在ubuntu 14.04下经过测试。

## 一键安装脚本

### 安装pptp vpn服务
参考文档https://help.ubuntu.com/community/PPTPServer
执行下述命令，将创建一个pptp账户，用户名为user，密码为passwd。
注意: 执行完后，需要重启机器生效。另外如果你连接不上vpn，可能是你家路由器没有vpn穿透功能，或者路由器未开启vpn穿透配置，我家的就是这样，只能手机3g使用vpn。
```sh
curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-pptp.sh | sh -s -- user passwd
```
### 安装vsftpd服务
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
执行完下述命令，就安装好了zsh以及其插件，配置文件查看.zshrc, 输入zsh开始体验吧。
```
 curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-zsh.sh | sh
```


## textexpander有用的snippets分享
### [ftime.textexpander](textexpander/ftime.textexpander)
用法: 复制一个10位的数字后，输入指定的abbreviation后，将该数字转化为2015-03-01 00:00:00格式的字符串。
如复制1428846374后，输入;ftime, 替换为2015-04-12 21:46:14。

### [time.textexpander](textexpander/time.textexpander)
用法: 输入指定的abbreviation后，输出当前的时间戳(10位字符)
如输入;time, 替换为1428846535。

### [jsonp.textexpander](textexpander/jsonp.textexpander)
用法: 复制jsonp的目标url，输入指定的abbreviation后，自动输出下列jsonp api的请求代码，且光标定位在console.log这句的下一行。
```javascript
jquery.ajax({
      url: "https://github.com/robbyrussell/oh-my-zsh/tree/master/plugins",
      dataType: "jsonp",
      success: function(data){
        console.log(data);
        
      }});
```

### [nginx.textexpander](textexpander/nginx.textexpander)
用法: 输入指定的abbreviation后, 在弹出的输入框中填入好域名test和端口5000(菜单已指定，不用输入默认即可)，即可配置好一个简单的nginx配置文件。
```ngnix
server {
        listen   80;

        server_name test.seaify.com;
        access_log  /var/log/nginx/test_access.log;
       error_log  /var/log/nginx/test_error.log;


        location / {
                proxy_pass http://127.0.0.1:5000;
                proxy_set_header Host $host;
                proxy_set_header X-Real-IP $remote_addr;
                proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        }
}
```


### [add_sudo_user.textexpander](textexpander/add_sudo_user.textexpander)
用法: 输入指定的abbreviation后, 在弹出的输入框中填入用户名和密码，即可创建一个有sudo权限的新账户。


### [ip.textexpander](textexpander/ip.textexpander)
用法: 输入指定的abbreviation后, 替换为系统的外网ip(有时候填配置文件，需要外网ip，这时候我们去百度搜ip，或者终端下敲curl ifconfig.me都太慢了，还得重新回编辑器)


## Bugs and Feature Requests
有bug或者feature的requests，欢迎提交！

## 后续
- 会添加textexpander中有用的sinppet，以及alfred workflow, automator。
- 关注能提高开发效率的工具。
