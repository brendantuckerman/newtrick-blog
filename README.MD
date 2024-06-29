#### Welcome to symfony intro ####

To start from scratch:

docker compose up -d --build 

(if the project has not been built):

docker compose exec php composer create-project symfony/skeleton .

To stop: 

docker compose down

To access the symfony cli once running

docker compose exec php symfony