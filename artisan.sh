#!/usr/bin/env sh

php artisan make:model Profile -fm
php artisan make:model Role -fm
php artisan make:model UserRole -fm
php artisan make:model Category -fmcrs
php artisan make:model Tag -fmcrs
php artisan make:model Post -fmcrs
php artisan make:model PostTag -fmcr
php artisan make:model Comment -fmcr
php artisan make:model Like -fmcr
php artisan make:model Favorite -fmcr
php artisan make:model CommentLike -fmcr

php artisan make:seeder UserSeeder
