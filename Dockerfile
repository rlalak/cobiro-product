FROM php:7.4

ENV TZ=Europe/Warsaw

WORKDIR /app
EXPOSE 8081

COPY . /app
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
  && docker-php-ext-install pdo_mysql \
  && bin/bootstrap.sh

HEALTHCHECK --start-period=1m --interval=10s CMD curl --fail --silent -o /dev/null http://127.0.0.1:8081/ || exit 1

CMD ["php", "-S", "0.0.0.0:8081"]