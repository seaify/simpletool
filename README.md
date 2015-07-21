# [simpletool 中文版](README.zh-CN.md)

# simpletool

simpletool provide pptp vpn, ftp, phpmyadmin, oh-my-zsh quick install without config, only one command.

Install
--------

```shell
gem install simpletool
```
or add the following line to Gemfile:

```ruby
gem 'simpletool'
```
and run `bundle install` from your shell.

Usage
--------
```ruby
chuck@chuck-MacBook-Pro:~/seaify/ % simpletool
Commands:
  simpletool help [COMMAND]                    # Describe available commands or one specific command
  simpletool install_ftp username passwd       # install ftp on ubuntu, need provide username & passwd
  simpletool install_phpmyadmin                # quick install phpmyadmin on ubuntu
  simpletool install_pptp_vpn username passwd  # quick install pptp vpn on ubuntu, need provide username & password, remember to reboot machine to check!!!
  simpletool install_zsh                       # quick install oh-my-zsh with plugins configed on ubuntu
```

Environment version
-----------------------

ruby 2.1.5  
ubuntu 14.04

More Information
----------------

* [Rubygems](https://rubygems.org/gems/simpletool)
* [Issues](https://github.com/seaify//issues)