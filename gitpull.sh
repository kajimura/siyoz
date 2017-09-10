#!/bin/bash

cd $(dirname $0)
git pull origin master

php artisan cache:clear
php artisan route:cache
composer dump-autoload

sh /var/www/html/gitpull.sh


