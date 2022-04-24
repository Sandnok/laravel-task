FROM php:8.0-fpm

RUN /bin/cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

# install module
RUN apt-get update && \
    apt-get install -y \
    sudo \
    gzip \
    rsyslog \
    ca-certificates \
    curl \
    xz-utils \
    vim \
    cron \
    procps \
    zip \
    gnupg \
    unzip &&\
    docker-php-ext-install pdo_mysql

# copy files from host
RUN mkdir /var/run/php-fpm
COPY conf/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf
COPY conf/php.ini /usr/local/etc/php/conf.d/php.ini

# install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# install node
COPY --from=node /usr/local/bin/node /usr/local/bin/
COPY --from=node /usr/local/lib/node_modules/ /usr/local/lib/node_modules/

# install npx
RUN ln -s /usr/local/bin/node /usr/local/bin/nodejs \
    && ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npx

WORKDIR /var/www/html