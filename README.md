# Interview app

## Downloading 
Download app: `git clone https://github.com/rlalak/cobiro-product.git`

## Run
Run app: `docker-compose up --build`.

App will be available on `http://127.0.0.1:8081/` 

## Important
All scripts you have to run inside application container to make sure environment where you run this script meet all requirements.
To call command inside container you have to run application and then use command like this `docker exec -it cobiro-product_app_1 bin/phpunit`.

## Configure database
Run migrations to prepare database: `bin/console doctrine:migration:migrate`.

## Tests
To run unit tests use command `bin/phpunit`
To run integration tests use command `bin/phpunit -c phpunit.integration.xml`

## Example request
```
curl -X POST -d '{"name":"Super produkt","priceAmount":"10023", "priceCurrency": "USD"}' http://127.0.0.1:8081/products/
```

## Development
For dev purposes uncomment mounting code into container in `docker-compose.yml` (uncomment section volumes) and run command `bin/bootstrap` to prepare application.

