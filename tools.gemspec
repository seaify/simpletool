Gem::Specification.new do |s|
  s.name        = 'seaify'
  s.version     = '0.0.5'
  s.date        = '2015-07-19'
  s.summary     = "convience tools for ubuntu"
  s.description = "provide quick install command for pptp vpn, shadowsocks server, phpmyadmin, oh-my-zsh"
  s.authors     = ["seaify"]
  s.email       = 'dilin.life@gmail.com'
  s.files       = Dir["lib/tools.rb", "lib/support/**/**/*"]
  s.homepage    = 'https://github.com/seaify/tools'
  s.license     = 'MIT'

  s.executables << 'tools'

  s.add_development_dependency 'rspec', '~> 3.3'
  s.add_dependency 'thor', '~> 0.14'
  s.add_dependency 'awesome_print', '~> 1.6'
end
