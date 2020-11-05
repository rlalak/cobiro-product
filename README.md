#Interview app

To run app use command `docker-compose up --build`
App will be available on `http://127.0.0.1:8081/`

For dev purposes uncomment mounting code into container in `docker-compose.yml` (uncomment section volumes) and run command `bin/bootstrap` to prepare application.

To run unit tests use command `bin/phpunit`

Is better to call all scripts from `bin` directory inside application container to make sure environment where we run this script has all requiredments.
You can log into container using command `docker exec -it cobiro-product_app_1 bash`.
