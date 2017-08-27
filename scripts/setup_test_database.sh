#!/usr/bin/env bash
echo "Setting up test database 'helpmeabstract' with user '${MYSQL_USER}'"
mysql -u root -e "CREATE DATABASE IF NOT EXISTS helpmeabstract;"
mysql -u root -e "CREATE USER '${MYSQL_USER}'@'localhost' IDENTIFIED BY '${MYSQL_PASSWORD}';"
mysql -u root -e "GRANT ALL ON helpmeabstract.* TO '${MYSQL_USER}'@'localhost';"