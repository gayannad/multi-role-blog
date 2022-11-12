# **Multiple-role blog system**

##Setup Instructions


```
composer install

npm install 

npm run dev 

php artisan key:generate
``` 

Copy .env file  for configurations

```
cp .env.example .env
```

Database migration and seed data
```
php artisan migrate:fresh --seed
```

Run the local server

```
php artisan serve
```
