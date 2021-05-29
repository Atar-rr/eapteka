FROM php:7.4-fpm

#RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
#
#COPY ./conf.d /usr/local/etc/php/conf.d

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
        git \
        curl \
        wget \
        zip \
        unzip \
        libonig-dev \
        libfreetype6-dev \
    # Clear cache
    && apt-get clean \
    && rm -r /var/lib/apt/lists/* \
    # Install xdebug
    && pecl install xdebug-2.8.0 \
    && docker-php-ext-enable xdebug \
    # Install PHP extensions
    && docker-php-ext-install json \
    && docker-php-ext-install pdo \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install pdo_mysql

RUN wget https://getcomposer.org/installer -O - -q \
        | php -- --install-dir=/bin --filename=composer --quiet

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
            chown -R $user:$user /home/$user

ADD ./conf.d/php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www
#права на исполнение
RUN chown -R www-data:www-data /var/www

USER $user
