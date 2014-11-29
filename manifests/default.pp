package {'php5-xdebug':
  ensure => latest
}
file {'/etc/php5/mods-available/xdebug.ini':
  ensure => file,
  source => '/vagrant/vm_config/xdebug.ini',
  owner => 'root',
  group => 'root',
  mode => 0644
}

file {'/etc/apache2/sites-available/000-default.conf':
  ensure => file,
  source => '/vagrant/vm_config/000-default.conf',
  owner => 'root',
  group => 'root',
  mode => 0644
}

service {'apache2':
  ensure => running,
  status => restart
}
