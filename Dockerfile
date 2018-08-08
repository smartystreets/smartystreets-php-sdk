FROM php:7-cli-alpine

ADD . /code
WORKDIR /code

RUN apk add --upgrade make git

RUN wget https://phar.phpunit.de/phpunit-6.5.phar \
&& chmod +x phpunit-6.5.phar \
&& mv phpunit-6.5.phar /usr/local/bin/phpunit
