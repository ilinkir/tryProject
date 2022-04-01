FROM ubuntu:focal
#https://github.com/exaco/laravel-octane-dockerfile thx
RUN set -eu \
    && echo "Europe/Moscow" > /etc/timezone \
    && apt-get -y update \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get -y install --no-install-recommends \
       gnupg wget curl software-properties-common vim \
    && add-apt-repository ppa:ondrej/php \
    && add-apt-repository ppa:openswoole/ppa \
    && apt-get -y update \
    && apt-get -y install git libphp8.1-embed php8.1-dev libc-ares-dev libcurl4-openssl-dev supervisor \
    && curl -sL https://deb.nodesource.com/setup_16.x  | bash - \
    && apt-get install -y nodejs \
    && pecl channel-update pecl.php.net

ARG build_env=devel
ENV BUILD_ENV=$build_env
ENV XDEBUG_PORT=9000
ENV XDEBUG_HOST=127.0.0.1
ENV XDEBUG_IDKEY=DEFKEY

RUN DEBIAN_FRONTEND=noninteractive apt-get -y install --no-install-recommends \
    php8.1-{cli,curl,fpm,gd,intl,mbstring,pgsql,xml,zip,redis,opcache,openswoole} \
    && bash -c "if [ "$BUILD_ENV" == "devel" ]; then apt-get -y install --no-install-recommends php8.1-xdebug; fi" \
    && rm -rf /var/lib/apt/lists/*

ARG INSTALL_SWOOLE=true

RUN set -eu \
    && if [ ${INSTALL_SWOOLE} = true ]; then \
      pecl install -D 'enable-openssl="no" enable-http2="yes" enable-swoole-curl="yes" enable-mysqlnd="no" enable-cares="yes"' openswoole \
      && bash -c "echo 'extension=openswoole' >> $(php -i | grep /.+/php.ini -oE)"; \
    fi

ADD ./ /var/www/
#ADD ./docker/service /etc/service
ADD ./docker/conf/php /tmp/php

COPY ./docker/conf/ /etc/supervisor/conf.d/

COPY ./docker/start.sh /usr/local/bin/start

RUN chown -R www-data. /var/www \
    && chmod u+x /usr/local/bin/start

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

WORKDIR /var/www

CMD ["/usr/local/bin/start"]

#CMD php artisan octane:start --server=swoole --host=0.0.0.0 --port=80 --workers=auto --task-workers=auto --max-requests=500 --watch
