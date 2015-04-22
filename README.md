## 简介
后台服务开发过程中，总是需要做一些重复的事情，如安装zsh, ftp等，所以将使用过的服务做成了一键安装脚本，避免重复，程序员已经够苦了，不应该再在这种屁事上浪费生命。

开发过程中常用的工具，如一键安装vpn, ss, zsh, 以及配置文件如vimrc, zshrc等, 注意以下安装脚本仅在ubuntu 14.04下经过测试。

## 经验文章
### [后台开发原则篇](rules/后台开发经验.md)

## Mac app推荐篇
- [1password](https://agilebits.com/onepassword), 装上相应chrome插件后，登陆网站再也不需要记得各种密码了，只需要记得1password的主密码，大爱。
- [textexpander](https://smilesoftware.com/TextExpander/index.html), 每天都在用的神器, 大量减少重复的输入，最简单例子比如输入;addr，就能出现你家的完整地址, 当然高端功能还有不少。
- [alfred](http://www.alfredapp.com/), 网络上大量的alfred workflow，你能很方便的定制自己想要的workflow，mac上最惊艳的app。
- [screenflow](http://www.telestream.net/screenflow/overview.htm), 录制视频，给你组内其它程序员讲讲课哈。
- [slack](https://slack.com/), 很好的企业协同办公工具，我每天都往slackbot上发消息，记录一些临时想法。
- [things](https://culturedcode.com/things/), gtd工具，管理你的工作效率
- [fantastical 2](http://flexibits.com/Fantastical), 很好的日历软件，界面很漂亮，功能很简洁
- [airmail](http://airmailapp.com/), 邮件真的需要个本地客户端，它支持markdown，支持定制规则
- [haroopad](http://pad.haroopress.com/), 我最喜欢的markdown编辑器, 支持vi 模式，实时预览
- [bartender](http://www.macbartender.com/), app装的多了，都显示在右上侧，就太挤了，它就是管理任务栏的
- [vagrant manager](http://vagrantmanager.com/), 不少软件还是要用windows的，所以要虚拟机，这个软件便是管理vagrant虚拟机的
- [teamviewer](https://www.teamviewer.com/en/index.aspx), 自由职业的，远程控制，访问
- [moom](http://manytricks.com/moom/), 很方便的管理窗口，最大化，最小化，移到其它桌面，指定到桌面的位置
- [clearmymac3](http://cleanmymac.com/), 有一天，你发现电脑硬盘空间不够了，或者想方便删软件，就是它了

另外附一个淘宝店，http://macsofts.taobao.com/, 我的大部分软件是在这买的，不是盗版，是那种家庭版，或者id共享版，也有个人版, 比appstore要便宜一些。
当然最稳妥的就是直接去appstore里买，或者官网里买。但真的，最好别去盗版，或者盗版了，有点钱后，还是买下正版的吧。

## 一键安装脚本
### 一键将当前目录下的文件加入logrotate, 每日自动化进行压缩, 默认保留7天备份
nginx, redis, mysql等许多系统服务在安装时，都会安装一份logrotate的配置文件，用来管理日志. 下面的这个脚本，就是用来运维值班人员，发现某台机器上磁盘空间不足，并找到了目录后，方便一键使用logrotate管理该目录的文件压缩，而不是简单的删除文件，下次又报警。
下列脚本在日志目录如/var/logs/tomcat或类似的任意目录下，执行后，会对匹配到.log的文件，使用日志压缩，规则是保留7天的备份，gz压缩, 如1.log, 会生成1.log-20150422.gz这样的备份文件。
```sh
curl https://raw.githubusercontent.com/seaify/tools/master/auto/quick-logrotate.sh | sudo sh -s .log
```

### 安装simplehttpserver
在当前目录下，执行下列命令，将该目录自动对外开放, 可用来托管图片，书籍等, 下面的脚本实际配置了相应的nginx，以及supervisor使用python -m SimpleHTTPServer。
sh -s -- 后的第一个参数为域名地址，第二个为程序端口，默认8080，可选参数。
```
curl https://raw.githubusercontent.com/seaify/tools/master/quick-install/ubuntu/install-simpleserver.sh | sh -s -- static.seaify.com [port]
```

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
