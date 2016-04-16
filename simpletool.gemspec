Gem::Specification.new do |s|
  s.name        = 'simpletool'
  s.version     = '0.0.3'
  s.date        = '2016-04-16'
  s.summary     = "convience simple tools for ubuntu"
  s.description = "provide quick install command for pptp vpn, shadowsocks server, phpmyadmin, oh-my-zsh"
  s.authors     = ["seaify"]
  s.email       = 'dilin.life@gmail.com'
  s.files       = Dir["lib/simpletool.rb", "lib/support/**/**/*"]
  s.homepage    = 'https://github.com/seaify/simpletool'
  s.license     = 'MIT'

  s.executables << 'simpletool'

  s.add_development_dependency 'rspec', '~> 3.3'
  s.add_dependency 'thor', '~> 0.14'
  s.add_dependency 'awesome_print', '~> 1.6'
end
