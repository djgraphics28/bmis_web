#how to install

Note: this is suitable for php 8.0

composer install

copy .env.example and rename it to .env

create database "bmis_web" or choose what you want

php artisan key:generate

migrate tables and initialize everything
php artisan migrate --seed || php artisan migrate:fresh --seed (if not new)

npm install && npm run dev

php artisan serve
