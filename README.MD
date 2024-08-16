#### Welcome to symfony template ####

A Docker based Symfony skeleton with some basic set up items:

- Tailwindcss
- Webpack for symfony
- Encore
- Doctrine

Should be enough to clone and get started. 

To start from scratch:

`docker compose up -d --build `

To start

`docker compose up`

(if the project has not been built):

`docker compose exec php composer create-project symfony/skeleton .`

(if it has, you'll need to composer files):

`docker compose exec php symfony composer install`

Then you'll need to ensure you have the  required npm packages used to compile assets. From /symfony run `npm i` and then `npm run watch`.

## Tailwind ##

See this for setup:

https://www.youtube.com/watch?v=qW8v75vMgfk&list=PLFHz2csJcgk-t8ErN1BHUUxTNj45dkSqS&index=16


To stop: 

`docker compose down`

To access the symfony cli once running

`docker compose exec php symfony`

To see active routes:

`docker compose exec php symfony console debug:route`

## Setting up the DB ##

Installing doctrine for the ORM:

`docker compose exec php symfony composer require symfony/orm-pack`

And the maker bundle:

`docker compose exec php symfony composer require --dev symfony/maker-bundle`

## Creating Entities (i.e tables) ##

Create with 

`docker compose exec php symfony console make:entity ENTITYNAME`

Migrate with 

`docker compose exec php symfony console make:migration`

and then 

`docker compose exec php symfony console doctrine:migrations:migrate`

to write to the DB

## Fixtures (Dummy Data) ##

Ensure that there are fixture files in the DataFixtures folder (MODEL.php)

Ru the following to load the fixture data

`docker compose exec php symfony console doctrine:fixtures:load`