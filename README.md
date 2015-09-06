## Topup Frontend

## Server setup
* Apache, PHP, PHPMyadmin, Git & Maven
```sh
$ yum update
$ rpm -Uvh https://mirror.webtatic.com/yum/el6/latest.rpm
$ yum install wget nano curl curl-devel
$ yum groupinstall -y "Development Tools"
$ yum install ntp ntpdate ntp-doc
$ yum install httpd
$ service httpd start
$ chkconfig httpd on
$ chkconfig ntpd on
$ ntpdate pool.ntp.org
$ service ntpd start
$ yum install libmcrypt libmcrypt-devel libpng libjpeg php55w
$ service httpd restart
$ nano /var/www/html/info.php
$ yum install php55w-gd php55w-mbstring php55w-mysql php55w-odbc php55w-pear php55w-tidy
$ service httpd restart
$ curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin
$ yum install php55w-mcrypt
$ service httpd restart
$ wget https://files.phpmyadmin.net/phpMyAdmin/4.4.11/phpMyAdmin-4.4.11-all-languages.zip
$ unzip phpMyAdmin-4.4.11-all-languages.zip
$ mv phpMyAdmin-4.4.11-all-languages /mnt/phpMyAdmin
$ cp /mnt/phpMyAdmin/config.sample.inc.php /mnt/phpMyAdmin/config.inc.php
$ nano /etc/httpd/conf.d/phpMyAdmin.conf
$ nano /mnt/phpMyAdmin/config.inc.php
$ service httpd restart
$ yum install git
$ wget http://www.interior-dsgn.com/apache/maven/maven-3/3.3.3/binaries/apache-maven-3.3.3-bin.tar.gz
$ mv apache-maven-3.3.3 /usr/maven
$ ln -s /usr/maven/bin/mvn /usr/bin/mvn
$ nano /etc/profile.d/maven.sh
$ chmod +x /etc/profile.d/maven.sh
$ source /etc/profile.d/maven.sh
```

## Deployment
* Clone code from git to home directory and move to virtual directory
```sh
```