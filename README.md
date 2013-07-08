chandelier-pi
=============

Code for the Origami Chandelier on Raspberry Pi. Created as a more efficient port of the Origami Chandelier for Arduino.
The core operates as a very simple process manager. The web interface is used to fork a single process which controls PWM output.
PHP must be installed in CGI mode as the [PCNTL](http://us3.php.net/manual/en/ref.pcntl.php) functions are unavailable as an Apache module.

##What is this?
Originating as a final project for 98-169: Modular Origami (a StuCo at CMU) the Origami Chandelier is programmable to glow different patterns of colors.
The device consists of a triangular PCB containing LEDs and other electronic components surrounded by a translucent paper shroud composed of origami modules.

##Prerequisites
* Apache 2.2.22+
* PHP 5.4.4-12+ (MUST be installed in CGI mode, not apache module)
* MySQL 14.14+
* pi-blaster (https://github.com/sarfata/pi-blaster/)

##Installing
```
> cd /home/pi
> git clone git@github.com:cfperrone/chandelier-pi.git chandelier
```
Modify /etc/apache2/sites-available/000-default (or applicable v-hosts file)
```
<VirtualHost *:80>
  ServerAdmin webmaster@localhost
	ServerName raspberrypi
	ServerAlias raspberrypi

	DocumentRoot /home/pi/chandelier/htdocs
	<Directory /home/pi/chandelier/htdocs>
		Options +FollowSymLinks -MultiViews Includes +Indexes
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>

	ErrorLog ${APACHE_LOG_DIR}/error.log
	LogLevel warn
	CustomLog ${APACHE_LOG_DIR}/access.log combined

	#CGI settings
	ScriptAlias /local-bin /usr/bin
	AddHandler application/x-httpd-php5 php
	Action application/x-httpd-php5 /local-bin/php-cgi
</VirtualHost>
```
