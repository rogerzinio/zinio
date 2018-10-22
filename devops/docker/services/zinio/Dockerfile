FROM ubuntu:18.04

# Prepare environment
WORKDIR /var/www
ENV DEBIAN_FRONTEND noninteractive
ENV SHELL /bin/bash

# Update the package repository
RUN apt-get update && apt-get install -y software-properties-common wget curl git tzdata iputils-ping locales zip unzip

# Configure timezone and locale
RUN echo "Europe/Madrid" > /etc/timezone
RUN export LANGUAGE=es_ES.UTF-8 && export LANG=es_ES.UTF-8 && export LC_ALL=es_ES.UTF-8 && locale-gen es_ES.UTF-8 && dpkg-reconfigure -f noninteractive tzdata locales

RUN LC_ALL=es_ES.UTF-8 add-apt-repository -y ppa:ondrej/php
RUN apt-get update

# Install dependencies
RUN apt-get install -y \
    apache2 \
    php7.2 \
    php7.2-cli \
    php7.2-common \
    php7.2-mbstring \
    php7.2-zip \
    php7.2-dev \
    php7.2-xdebug \
    php-apcu

# Add PHP configurations
ADD templates/xdebug.ini /etc/php/7.2/mods-available/xdebug.ini
ADD templates/apcu.ini /etc/php/7.2/mods-available/apcu.ini

# Composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/bin/composer
RUN chmod 777 /usr/bin/composer

#PHPUNIT
RUN wget https://phar.phpunit.de/phpunit-7.4.phar
RUN chmod +x phpunit-7.4.phar
RUN mv phpunit-7.4.phar /usr/local/bin/phpunit

RUN apt-get update

ADD templates/run.sh /run.sh
RUN chmod -v +x /run.sh

EXPOSE 80
EXPOSE 8080
CMD ["/run.sh"]