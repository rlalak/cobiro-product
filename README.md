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

## Configure read model
All queries use different model than command. Read model is updating partially after run command.  
To make full synchronize run command: `bin/console product:synchronize`

## Tests
To run unit tests use command `bin/phpunit`.

To run integration tests use command `bin/phpunit -c phpunit.integration.xml`

## Example request
```
# create new product
curl -X POST -d '{"name":"Super produkt","priceAmount":"10023", "priceCurrency": "USD"}' http://127.0.0.1:8081/products/

# update existing product
curl -X PUT -d '{"name":"Super produkt","priceAmount":"10023", "priceCurrency": "USD"}' http://127.0.0.1:8081/products/340fd687-5528-4701-b6eb-a5f254de0783

# get product details
curl -X GET -d '{"name":"Super produkt","priceAmount":"10023", "priceCurrency": "USD"}' http://127.0.0.1:8081/products/340fd687-5528-4701-b6eb-a5f254de0783

# get all products
curl -X GET -d '{"name":"Super produkt","priceAmount":"10023", "priceCurrency": "USD"}' http://127.0.0.1:8081/products/

# remove product
curl -X DELETE -d '{"name":"Super produkt","priceAmount":"10023", "priceCurrency": "USD"}' http://127.0.0.1:8081/products/340fd687-5528-4701-b6eb-a5f254de0783
```

## Development
For dev purposes uncomment mounting code into container in `docker-compose.yml` (uncomment section volumes) and run command `bin/bootstrap` to prepare application.

