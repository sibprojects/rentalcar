# RentalCar Backend Test

## Result of creating test work

### Install composer, start server and docker image
    $ symfony composer install
    $ symfony server:start -d
    $ docker-compose up -d

### Make migrations and seed database
    $ symfony console doctrine:migrations:migrate
    $ symfony console doctrine:fixtures:load

### Compile packages of css / js
    $ symfony run yarn encore dev

### Now you can open server by URL and check User stories
    https://127.0.0.1:8000/

### Then making tests

Before need to reset database by loading fixtures

    $ symfony console doctrine:fixtures:load

Run tests

    $ php bin/phpunit

And wait for results: _OK (8 tests, 44 assertions)_.
There are _Entity_ tests and _Controller_ tests.

There are some web controller tests by library "Panther": 
https://github.com/symfony/panther

## What else can be done on this project with more time
* it is possible to add pictures of cars
* it is possible to add notifications to mail or telegrams on the phone
* it is possible to add an admin panel to view and manage bookings
* etc... :)