require 'thor'
require 'awesome_print'

class SimpleTool < Thor
  include Thor::Actions

  def self.source_root
    File.dirname(__FILE__)
  end

  no_commands do
    def cp_file(src, dest, sudo=false)
      command = 'cp -r ' + SimpleTool.source_root + '/' + src + ' ' + dest
      command = 'sudo ' + command if sudo
      ap command
      `#{command}`
    end
  end



  desc "install_pptp_vpn username passwd", "quick install pptp vpn on ubuntu, need provide username & password, remember to reboot machine to check!!!"
  def install_pptp_vpn
    `sudo apt-get install --yes pptpd pptp-linux`
    cp_file('support/pptp_vpn/ubuntu/pptpd.conf', '/etc/pptpd.conf', true)
    cp_file('support/pptp_vpn/ubuntu/pptpd-options', '/etc/ppp/pptpd-options', true)
    `sudo bash -c "echo '$1 * $2 *' >> /etc/ppp/chap-secrets"`
    cp_file('support/pptp_vpn/ubuntu/sysctl.conf', '/etc/sysctl.conf', true)
    cp_file('support/pptp_vpn/ubuntu/rc.local', '/etc/rc.local', true)
    `sudo modprobe nf_conntrack_proto_gre nf_conntrack_pptp`
    `sudo /etc/init.d/pptpd restart`
    `echo 'pleaese reboot to make it works'`
  end

  desc "install_phpmyadmin", "quick install phpmyadmin on ubuntu"
  def install_phpmyadmin
    `sudo apt-get -y install nginx php5-cli php5-cgi php5-fpm php5-mcrypt php5-mysql php5-gd php-apc php5-common`

    #modify mysql.ini
    `sudo sed -i'' -e '/bind-address/d' /etc/mysql/my.cnf`
    #
    ##wget nginx default
    #sudo wget https://raw.githubusercontent.com/seaify/tools/master/files/nginx.phpmyadmin.default -O /etc/nginx/sites-enabled/default
    cp_file('support/phpmyadmin/nginx.phpmyadmin.default',  '/etc/nginx/sites-enabled/nginx.phpmyadmin.default', true)
    cp_file('support/phpmyadmin/phpmyadmin',  '/usr/share/nginx/html/', true)
    #
    ##download phpmyadmin files
    #cd /usr/share/nginx/html
    #sudo wget http://superb-dca2.dl.sourceforge.net/project/phpmyadmin/phpMyAdmin/4.4.8/phpMyAdmin-4.4.8-all-languages.tar.bz2
    #sudo tar xvf phpMyAdmin-4.4.8-all-languages.tar.bz2
    #sudo mv phpMyAdmin-4.4.8-all-languages phpmyadmin
    #
    `sudo service nginx reload`
    `sudo service php5-fpm restart`

  end

  desc "install_shadowsocks_server", "quick install shadowsocks server on ubuntu"
  def install_shadowsocks_server

  end

  desc "install_zsh", "quick install oh-my-zsh with plugins configed on ubuntu"
  def install_zsh

  end



end
