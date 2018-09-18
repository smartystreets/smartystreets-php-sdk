FROM php:7-cli-alpine

ADD . /code
WORKDIR /code

RUN apk add --upgrade make git

RUN wget https://phar.phpunit.de/phpunit-6.5.phar \
	&& chmod +x phpunit-6.5.phar \
	&& mv phpunit-6.5.phar /usr/local/bin/phpunit \
	&& wget -O - "https://github.com/smartystreets/version-tools/releases/download/0.0.6/release.tar.gz" | tar -xz -C /usr/local/bin/
