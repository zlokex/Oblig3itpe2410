# Oblig3itpe2410
Group project II-Cloud ITPE2410

## About
This repository contains a simple dynamic database-driven Library web application, with functionality for displaying, filtering, adding, and removing book and author entries from a library databases with two tables; books and authors.

The application is designed as a piece in a larger project of designing a 3-tier cloud-based web application service (using virtual machines), with load balancing among four web servers, and database replication with a master and two slave databases.

## Languages
For the web application only PHP, HTML and CSS are used. No third party frameworks. For the database MySQL is used.

## Install
###Software
####Minimum
####Linux
#####Web server
Install Apache2, php5 php5-mysqlnd
apt-get install apache2 php5 libapache2-mod-php5 php5-mysqlnd
Enable apache2
Then install git and clone to /var/www/http
apt-get install git
git clone https://github.com/zlokex/Oblig3itpe2410.git

#####Database server
Install MySQL server
apt-get install mysql-server

####Reccomended
####Linux
#####Web servers
Create 4 Virtual machines with Ubuntu Server 14.04 OS
For each machine install Apache2, php5 php5-mysqlnd
apt-get install apache2 php5 libapache2-mod-php5 php5-mysqlnd
Install git
apt-get install git
Download this repository to /var/www/http/
git clone https://github.com/zlokex/Oblig3itpe2410.git

#####Database servers
