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

# publish laravel-filemanager
#php artisan vendor:publish --tag=lfm_public
#php artisan vendor:publish --tag=lfm_config

# publish telescope
#php artisan vendor:publish --tag=telescope-migrations

# make migration
php artisan migrate --force

chmod 664 -R /var/www/html/storage/logs

/usr/bin/supervisord -c /etc/supervisord.conf
