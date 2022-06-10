# Introduction

The API has been developer using Lumen Framework and SQLite with TDD and SOLID methodologies


- I'm using the route-binding package to use route-binding as a laravel
- JWTAuth to management the auth tokens
- laravel excel to export csv, it's could be usefull if needs export for more formats
- php-whois to find information about domain


- I choose create a job to update values because whois could be a slowly process
- It's posible use database/redis to manager the queue job, all configuration has been done, but I set as default to sync, but the process to update domains could be a litle bit slowly to get info by whois ( to do that best solution is configure a supervisor system or run php artisan queue:work )
- I try use diferents designer patterns just to show my skills
- I'm using Mailtrap to send emails but you could use any system like SES or mailgun, just configure on .env file and do some changes if necessary
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
```
