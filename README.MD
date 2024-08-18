#### Welcome to Orchestra School Planner ####

A Docker based Symfony project utilising:

- Tailwindcss
- Webpack for symfony
- Encore
- Doctrine

See composer.json for composer packages and package.json for npm packages.

Should be enough to clone and get started. 

To start from scratch:

`docker compose up -d --build `

To start

`docker compose up`

(if the project has not been built):

`docker compose exec php composer create-project symfony/skeleton .`

(if it has, you'll need to composer files):

`docker compose exec php symfony composer install`

Then you'll need to ensure you have the  required npm packages used to compile assets. From /symfony run `npm i` and then `npm run watch` to fire up the encore webpack watcher.

Local prject should be available on port 8080

## Tailwind ##

See this for setup:

https://www.youtube.com/watch?v=qW8v75vMgfk&list=PLFHz2csJcgk-t8ErN1BHUUxTNj45dkSqS&index=16



## Stopping the project ##

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

## Creating forms with symfony/forms ##

You can use this module to create forms using 'make:from MODELFormType MODEL'. e.g:

`docker compose exec php symfony console make:form TeacherFormType Teacher`


## Start up for existing (cloned) project ##

If you are not re-creating this project from the gorund up, here are the more simple steps needed to get going for development:

TODO: Put these in a startup script
&& add in composer update

1. Start from root
2. docker compose up -d --build 
3. docker compose up
4. docker compose exec php symfony composer install
5. cd symfony/
6. docker compose exec php symfony console doctrine:migrations:migrate
7. docker compose exec php symfony console doctrine:fixtures:load
8. npm i
9. npm run watch
10. Project should be running at localhost:8080