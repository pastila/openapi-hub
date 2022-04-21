FROM php:7.4-fpm AS base

ARG GROUP_ID=1000
ARG USER_ID=1000
ARG USER_NAME=deployer

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libicu-dev \
    libpq-dev

# Install extensions
RUN docker-php-ext-install pdo_pgsql zip exif pcntl

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /home/$USER_NAME/.ssh
RUN echo "Host git.accurateweb.ru\n\t HostName git.accurateweb.ru\n\t Port 2022\n" >> /home/$USER_NAME/.ssh/config

# Add user for laravel application
RUN groupadd -g $GROUP_ID $USER_NAME
RUN useradd -u $USER_ID -ms /bin/bash -g $USER_NAME $USER_NAME

RUN mkdir -p /home/$USER_NAME/.config
RUN chown -R $USER_NAME /home/$USER_NAME/.config

USER $USER_NAME

WORKDIR /var/www

EXPOSE 9000
CMD ["php-fpm"]
