#start with our base image (the foundation) - version 7.2
FROM php:7.2-apache

#install all the system dependencies and enable PHP modules 
RUN apt-get update && apt-get install -y \
      libicu-dev \
      libpq-dev \
      libmcrypt-dev \
      git \
      zip \
      nano\
      unzip \
      nodejs \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-install \
      intl \
      mbstring \
      pcntl \
      pdo_mysql \
      opcache

#install composer
RUN apt-get install curl python-software-properties
RUN curl -sL https://deb.nodesource.com/setup_11.12.0 | sudo -E bash -
RUN apt-get install nodejs


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

#set our application folder as an environment variable
ENV APP_HOME /var/www/html

#change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

#change the web_root to laravel /var/www/html/public folder
RUN sed -i -e "s/html/html\/public/g" /etc/apache2/sites-enabled/000-default.conf

# enable apache module rewrite
RUN a2enmod rewrite

#copy source files and run composer
COPY . $APP_HOME

#install all Node
RUN npm install 
# install all PHP dependencies
RUN composer install --no-interaction

RUN php artisan key:generate
RUN composer dumpautoload

#change ownership of our applications
RUN chown -R www-data:www-data $APP_HOME