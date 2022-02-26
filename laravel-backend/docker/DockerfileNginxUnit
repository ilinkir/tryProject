FROM ubuntu:focal
#https://github.com/nginx/unit/issues/625 https://github.com/nginx/unit/issues/515
RUN set -xe \
    && echo "Europe/Moscow" > /etc/timezone \
    && apt-get -y update \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get -y install --no-install-recommends \
       gnupg wget curl software-properties-common vim \
    && curl http://nginx.org/keys/nginx_signing.key | apt-key add - \
    && echo "deb https://packages.nginx.org/unit/ubuntu/ focal unit"  | tee -a /etc/apt/sources.list \
    && add-apt-repository ppa:ondrej/php \
    && apt-get -y update \
    && apt-get -y install git runit libphp8.1-embed php8.1-dev
    ##&& unitd --version \
    ##unit unit-php
RUN curl -O https://unit.nginx.org/download/unit-1.26.1.tar.gz
RUN tar xzf unit-1.26.1.tar.gz && cd unit-1.26.1 \
    && ./configure --prefix=/usr --state=/var/lib/unit --control=unix:/var/run/control.unit.sock \
    --pid=/var/run/unit.pid --log=/var/log/unit.log --tmp=/var/tmp --user=www-data --group=www-data --tests  \
    --openssl --modules=/usr/lib/unit/modules --libdir=/usr/lib/x86_64-linux-gnu \
    && ./configure php --module=php81 --config=php-config8.1 \
    && make php81 \
    && make install php81-install && unitd --version

ARG build_env=devel
ENV BUILD_ENV=$build_env
ENV XDEBUG_PORT=9000
ENV XDEBUG_HOST=127.0.0.1
ENV XDEBUG_IDKEY=DEFKEY

RUN DEBIAN_FRONTEND=noninteractive apt-get -y install --no-install-recommends \
    php8.1-cli php8.1-curl php8.1-fpm php8.1-gd \
    php8.1-intl php8.1-mbstring \
    php8.1-pgsql php8.1-xml php8.1-zip php8.1-redis \
    && bash -c "if [ "$BUILD_ENV" == "devel" ]; then apt-get -y install --no-install-recommends php8.1-xdebug; fi" \
    && rm -rf /var/lib/apt/lists/*

ADD ./ /var/www/
ADD ./docker/conf/unit/config.json /tmp/config.json
#ADD ./docker/service /etc/service
ADD ./docker/runit_entry /runit_entry
ADD ./docker/conf/php /tmp/php

RUN chmod a+x /runit_entry && \
#    chmod -R a+x /etc/service/ && \
    chown -R www-data. /var/www

RUN bash -c "if [ "$BUILD_ENV" == "devel" ]; \
    then { \
        echo 'zend_extension=xdebug'; \
        echo 'xdebug.default_enable = 1'; \
        echo 'xdebug.remote_enable = 1'; \
        echo 'xdebug.remote_autostart=1'; \
        echo 'xdebug.remote_connect_back=0'; \
        echo 'xdebug.remote_host = $XDEBUG_HOST'; \
        echo 'xdebug.remote_port = $XDEBUG_PORT'; \
        echo 'xdebug.remote_handler = dbgp'; \
        echo 'xdebug.idekey = $XDEBUG_IDKEY'; \
        } > /etc/php/8.1/mods-available/xdebug.ini; \
    fi"

RUN bash -c "if [ "$BUILD_ENV" == "devel" ]; \
   then \
       cp /tmp/php/params-dev.ini /etc/php/8.1/mods-available/params.ini; \
       ln -s /etc/php/8.1/mods-available/params.ini /etc/php/8.1/embed/conf.d/90-params.ini; \
       ln -s /etc/php/8.1/mods-available/params.ini /etc/php/8.1/cli/conf.d/90-params.ini; \
   else \
       cp /tmp/php/params-prod.ini /etc/php/8.1/mods-available/params.ini; \
       ln -s /etc/php/8.1/mods-available/params.ini /etc/php/8.1/embed/conf.d/90-params.ini; \
       ln -s /etc/php/8.1/mods-available/params.ini /etc/php/8.1/cli/conf.d/90-params.ini; \
   fi"

ADD https://getcomposer.org/installer /tmp/composer
RUN php /tmp/composer --install-dir=/usr/bin --filename=composer \
    && su -s /bin/bash www-data -c "if [ "$BUILD_ENV" == "devel" ]; then echo 'Skipping deps installing...'; else cd /var/www && composer install; fi"

RUN unitd --control unix:/var/run/unit.sock \
    && curl -X PUT --data-binary @/tmp/config.json --unix-socket \
    /var/run/unit.sock http://localhost/config/ \
    && kill `pidof unitd` && cat /var/log/unit.log

CMD ["unitd", "--no-daemon"]
