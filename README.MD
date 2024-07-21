#### Welcome to symfony intro ####

To start from scratch:

`docker compose up -d --build `

To start

`docker compose up`

(if the project has not been built):

`docker compose exec php composer create-project symfony/skeleton .`

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

## Creeating Entities (i.e tables) ##

Create with 

`docker compose exec php symfony console make:entity ENTITYNAME`

Migrate with 

`docker compose exec php symfony console make:migration`

and then 

`docker compose exec php symfony console doctrine:migrations:migrate`

to write to the DB

## Fixtures (Dummy Data) ##

