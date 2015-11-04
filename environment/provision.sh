#!/bin/bash

echo "Install basic environment tools"
yum install -y httpd php php-mbstring php-pdo php-intl php-mysqli wget ftp tar bind-utils telnet git

echo "Install php mcrypt extension"
wget http://dl.fedoraproject.org/pub/epel/7/x86_64/e/epel-release-7-5.noarch.rpm -O /tmp/epel-release-7-5.noarch.rpm
rpm -ivh /tmp/epel-release-7-5.noarch.rpm
yum install --enablerepo="epel" php-mcrypt

echo "Install MySQL community edition"
rpm -Uvh http://dev.mysql.com/get/mysql-community-release-el7-5.noarch.rpm
sudo yum install -y mysql-community-server

echo "Enable mysql daemon"
systemctl enable mysqld

echo "Start mysql server"
systemctl start mysqld

echo "Secure mysql installation"
mysql -e "UPDATE mysql.user SET Password = PASSWORD('password') WHERE User = 'root'"
mysql -e "DROP USER ''@'localhost'"
mysql -e "DROP USER ''@'$(hostname)'"
mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' identified by 'password' WITH GRANT OPTION"
mysql -e "FLUSH PRIVILEGES"

echo "Shutdown firewall"
systemctl stop firewalld

mkdir -p /opt/work/bin
cd /opt/work

echo "Install composer to /opt/work/bin"
curl -sS https://getcomposer.org/installer | php -- --install-dir=bin

echo "Add composer to PATH"
ln -s /opt/work/bin/composer.phar /usr/local/sbin/composer

echo "Install flyway"
wget -q "https://bintray.com/artifact/download/business/maven/flyway-commandline-3.2.1-linux-x64.tar.gz" -O /tmp/flyway-3.2.1.tgz
tar xzf /tmp/flyway-3.2.1.tgz -C /usr/local/lib/
chmod -R 755 /usr/local/lib/flyway-3.2.1/
ln -s /usr/local/lib/flyway-3.2.1/flyway /usr/bin/flyway
> /usr/local/lib/flyway-3.2.1/flyway.properties

echo "Create the db schema by default"
mysql -u root -ppassword -e "CREATE DATABASE IF NOT EXISTS replique DEFAULT CHARACTER SET latin1;"
