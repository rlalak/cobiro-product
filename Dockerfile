FROM php:7.4

ENV TZ=Europe/Warsaw

WORKDIR /app
EXPOSE 8081

COPY . /app
RUN apt-get update && apt-get install -y git libzip-dev unzip \
  && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
  && pecl install xdebug \
  && docker-php-ext-install pdo_mysql && docker-php-ext-install zip && docker-php-ext-enable xdebug \
  && bin/bootstrap.sh

HEALTHCHECK --start-period=1m --interval=10s CMD curl --fail --silent -o /dev/null http://127.0.0.1:8081/ || exit 1

WORKDIR /app/public

CMD ["php", "-S", "0.0.0.0:8081"]