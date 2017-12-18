FROM php:7.0-apache

RUN apt-get update

# Install zip
RUN apt-get install -y libzzip-dev zlib1g zlib1g-dbg zlib1g-dev zlibc libmcrypt.

# Installing some PHP extensions
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip

RUN pecl install xdebug-2.5.0 \
    && docker-php-ext-enable xdebug

# Installing mysql extensions
RUN docker-php-ext-install pdo pdo_mysql mcrypt mysqli

RUN apt-get update -y \
  && apt-get install -y \
    libxml2-dev \
    php-soap \
  && apt-get clean -y \
  && docker-php-ext-install soap

RUN echo "Europe/Paris" > /etc/timezone

RUN apt-get update && \
    apt-get -y upgrade && \
		apt-get -y install tzdata openntpd

RUN usermod -u 1000 www-data

RUN cp /usr/share/zoneinfo/Europe/Paris /etc/localtime && \
	echo "Europe/Paris" > /etc/timezone

RUN touch /var/log/php.log && chmod 777 /var/log/php.log
RUN a2enmod rewrite