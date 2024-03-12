## Setup
```bash
    php -r "file_exists('.env') || copy('.env.example', '.env')
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

## Endpoints
POST Login `/api/login` (returns `apiToken`)

> Use that with `Authorization: Bearer {{apiToken}}`

GET Travels `/api/travels` (admin)

GET Tours `/api/travel/{{travels.id}}/tours` (admin)

POST Travel `/api/travel` (admin)

Body: 
```json
{
    "name": "Test Travel2 ",
    "description": "Test Desc2 ",
    "numberOfDays": 6,
    "public": true,
    "moods": {
        "nature": 10,
        "relax": 10,
        "history": 40,
        "culture": 10,
        "party": 40
    }
}
```

POST Tour `/api/travel/{{travels.id}}/tour` (admin)

Body: 
```json
{
    "name": "ITJOR20211101",
    "startingDate": "2024-03-25",
    "endingDate": "2024-03-30",
    "price": 10000 
}
```

PUT Tour `/api/tour/{{tour.id}}` (editor)

Body: 
```json
{
    "name": "ITJOR20211125",
    "startingDate": "2024-03-25",
    "endingDate": "2024-03-30",
    "price": 10000 
}
```

GET Tours (search) `/api/search/{{travel:slug}}` (open - no login required)

Query Params examples: 
```json
    dateFrom=2024-03-15
    dateTo=2024-03-16
    priceFrom=100000 (1000.00)
    priceTo=430000 (4,300.00)
    orderBy=price 
```

## Github Actions
Also added `tests` running on Github Actions, last run [here](https://github.com/sjunior-dev/weroad-api/actions/runs/8246618543/job/22553016329), it run every PR on `develop/main` branches.
