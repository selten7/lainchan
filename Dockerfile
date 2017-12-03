FROM php:7.2-cli

RUN apt-get update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev imagemagick graphicsmagick gifsicle
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install gd mbstring pdo pdo_mysql
RUN mkdir /app

WORKDIR /app

CMD ["php", "-S", "0.0.0.0:8080"]
