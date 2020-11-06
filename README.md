# Interview app

## Downloading 
Download app: `git clone https://github.com/rlalak/cobiro-product.git`

## Important
All scripts you have to run inside application container to make sure environment where you run this script meet all requirements.
To call command inside application you have to run application and then use command like this `docker exec -it cobiro-product_app_1 bin/phpunit`.

## Run
Run app: `docker-compose up --build`. 
Run migrations to prepare database: `bin/console doctrine:migration:migrate`.

App will be available on `http://127.0.0.1:8081/`

## Test
To run unit tests use command `bin/phpunit`



For dev purposes uncomment mounting code into container in `docker-compose.yml` (uncomment section volumes) and run command `bin/bootstrap` to prepare application.

