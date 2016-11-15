#!/usr/bin/env bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS helpmeabstract;"
mysql -u root -e "CREATE USER '${MYSQL_USER}'@'localhost' IDENTIFIED BY '${MYSQL_PASSWORD}';"
mysql -u root -e "GRANT ALL ON helpmeabstract.* TO '${MYSQL_USER}'@'localhost';"