# Introduction

The API has been developer using Lumen Framework and SQLite with TDD and SOLID methodologies

- I'm using the route-binding package to use route-binding as laravel
- JWTAuth to management the auth tokens
- laravel excel to export csv, it could be usefull if it needs export for more formats
- php-whois to find information about domain
- I chose to create a job to update values because whois could be a slow process
- It's possible to use database/redis to manager the queue job, all configuration has been done, but I set as default to use a sync, but the process to update domains could be a litle bit slowly to get info by whois ( to do that the best solution is configured a supervisor system or run php artisan queue:work )
- I'm using Mailtrap to send emails, but you could use any system like SES or mailgun, just configure on .env file and do some changes if necessary
- I also configure to check expiring domains every 30 days but this need some extra configurations could be necessary as required on laravel/lumen, or to run manually using (php artisan CheckExpiringDomains 30)


# Instructions

- PHP >= 7.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- SQLite PHP Extension
- php-curl Extension
- Open port 43 in firewall

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan jwt:secret
vendor/bin/phpunit
php -S localhost:8000 -t public  
```
# Documentation
the API documentation has created with Postman, the DomainAPI.postman_collection.json could be imported to all requests
https://documenter.getpostman.com/view/3587714/UzBgtUcF#90d996c3-cd84-48be-8575-0166ad7ab5ec

# Todo
- Maybe next steps are improve documentation and convert to OAS, this package could help (https://github.com/DarkaOnLine/L5-Swagger)
- Create the frontend
