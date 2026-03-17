FROM dunglas/frankenphp:1.12.1-php8.5

RUN install-php-extensions \
	pdo_mysql \
	redis \
	zip \
	opcache \
	intl \
	pcntl

ENV SERVER_NAME=:80