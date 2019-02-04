Copy .env.example to .env and set DB credentials
```bash 
cp .env.example .env 
```
Run composer and generate application key 
```bash 
composer install
php artisan key:generate
```
Run migrations and seed DB by test data
```bash 
php artisan migrate
php artisan db:seed
```
Give permissions
```bash 
chmod 777 -R storage/
chmod 777 -R bootstrap/cache/
```
Login
```bash 
You can login as 
user@mail.com / qweqwe
or register a new user
```