## Setup
```bash
    composer install
    docker compose up -d

```
To enter the container:
```bash
    docker compose exec app-weroad /bin/sh
    php artisan migrate:fresh
    php artisan db:seed 
    // or specifc 
    php artisan db:seed --class=TravelsAndToursTableSeeder
```
Create/Refresh Database
```bash
    php artisan migrate:fresh
    php artisan db:seed 
    //or specifc 
    php artisan db:seed --class=TravelsAndToursTableSeeder
    // or
    sh infra/scripts/rebuild-db.sh
```

## Tests
```bash
    php vendor/bin/phpunit tests/Feature/BusinessCaseTest.php
    // or all
    php vendor/bin/phpunit 
```

There is also a `.http` file, using `VSCODE Rest Client` to help running the endpoints.

## Users
In the seed, we created 2 users:
```
    email: sjunior.dev@gmail.com
    password: password
    role: admin
```
```
    email: sjunior.dev1@gmail.com
    password: password
    role: editor
```
