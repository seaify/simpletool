class Tools < Thor
  include Thor::Actions

  def self.source_root
    File.dirname(__FILE__)
  end

  desc "install_pptp_vpn", "quick install pptp vpn on ubuntu"
  def install_pptp_vpn
    `sudo apt-get install --yes pptpd pptp-linux`
    copy_file 'lib/support/pptp_vpn/ubuntu/pptpd.conf', "/etc/pptpd.conf"
    copy_file 'lib/support/pptp_vpn/ubuntu/pptpd-options', "/etc/ppp/pptpd-options"
    `sudo bash -c "echo '$1 * $2 *' >> /etc/ppp/chap-secrets"`
    copy_file 'lib/support/pptp_vpn/ubuntu/sysctl.conf', "/etc/sysctl.conf"
    copy_file 'lib/support/pptp_vpn/ubuntu/rc.local', "/etc/rc.local"
    `modprobe nf_conntrack_proto_gre nf_conntrack_pptp`
    `sudo /etc/init.d/pptpd restart`
  end

  desc "install_phpmyadmin", "quick install phpmyadmin on ubuntu"
  def install_phpmyadmin

  end

  desc "install_shadowsocks_server", "quick install shadowsocks server on ubuntu"
  def install_shadowsocks_server

  end

  desc "install_zsh", "quick install oh-my-zsh with plugins configed on ubuntu"
  def install_zsh

  end



end