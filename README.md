# steps needed para malagay sa laptop if galing github yung laravel:

**composer install**,
if permission errors, 

composer install --no-scripts


VENDOR EXIST
rmdir /s /q vendor
del composer.lock
composer install

composer dump-autoload

configure cache 
php artisan config:clear
php artisan cache:clear
php artisan config:cache

show laravel
composer show laravel/framework
if wla yung composer laravel install it using:
**composer require laravel/framework**

modify this shit sa xampp php ini

**;extension=zip** into **extension=zip**

### error 500 server yan need mo ung env
## cp .env.example .env
tapos generate na key
## php artisan key:generate


php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
