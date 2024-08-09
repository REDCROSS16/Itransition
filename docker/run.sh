#!/bin/sh
echo running script
cd /var/www/html

# change storage rights
chmod -R 777 storage

# update php packages
composer install

# generate key
php artisan key:generate

# link storage data
php artisan storage:link

chmod 664 -R /var/www/html/storage/logs

/usr/bin/supervisord -c /etc/supervisord.conf
