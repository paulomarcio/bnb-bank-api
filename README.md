# BNB Bank API

A PHP API developed with Lumen framework version 8.

## Requirements

-   PHP ^7.3 and MySQL 8 for running on a virtual machine
-   Docker ^20.10.9 or docker-compose ^1.29.2 to run anywhere :-)

## Usage with Docker and docker-compose

-   Copy env.example to .env and configure your settings
-   Then run `docker-composer up` or `docker-composer up -d` for a detached mode

## Installation

-   With Docker and docker-compose run `docker-compose exec app php artisan migrate:refresh --seed` to create tables and essential data.
-   With PHP just run `php artisan migrate:refresh --seed` to do the same.
-   After seeding the database an admin user will be created with email `admin@bnbbank.com` and password `admin123`
