FROM ubuntu:22.04 as base

LABEL maintainer="Taylor Otwell"

ARG WWWGROUP
ARG NODE_VERSION=16
ARG POSTGRES_VERSION=14

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2 \
    && mkdir -p ~/.gnupg \
    && chmod 600 ~/.gnupg \
    && echo "disable-ipv6" >> ~/.gnupg/dirmngr.conf \
    && echo "keyserver hkp://keyserver.ubuntu.com:80" >> ~/.gnupg/dirmngr.conf \
    && gpg --recv-key 0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c \
    && gpg --export 0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c > /usr/share/keyrings/ppa_ondrej_php.gpg \
    && echo "deb [signed-by=/usr/share/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.1-cli php8.1-dev \
       php8.1-pgsql php8.1-sqlite3 php8.1-gd \
       php8.1-curl \
       php8.1-yaml \
       php8.1-imap php8.1-mysql php8.1-mbstring \
       php8.1-xml php8.1-zip php8.1-bcmath php8.1-soap \
       php8.1-intl php8.1-readline \
       php8.1-ldap \
       php8.1-msgpack php8.1-igbinary php8.1-redis php8.1-swoole \
       php8.1-memcached php8.1-pcov php8.1-xdebug \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.1

RUN groupadd --force -g 1000 professional
RUN useradd -ms /bin/bash --no-user-group -g 1000 -u 1000 professional

COPY docker/8.1/php.ini /etc/php/8.1/cli/conf.d/99-sail.ini

ENTRYPOINT ["bash"]

FROM base as local
COPY --chown=1000:1000 app /var/www/html/app
COPY --chown=1000:1000 bootstrap /var/www/html/bootstrap
COPY --chown=1000:1000 config /var/www/html/config
COPY --chown=1000:1000 public /var/www/html/public
COPY --chown=1000:1000 resources /var/www/html/resources
COPY --chown=1000:1000 routes /var/www/html/routes
COPY --chown=1000:1000 storage /var/www/html/storage
COPY --chown=1000:1000 tests /var/www/html/tests
COPY --chown=1000:1000 vendor /var/www/html/vendor
COPY --chown=1000:1000 artisan /var/www/html/artisan
COPY --chown=1000:1000 composer.json /var/www/html/composer.json

FROM base as production

COPY --chown=1000:1000 app /var/www/html/app
COPY --chown=1000:1000 bootstrap /var/www/html/bootstrap
COPY --chown=1000:1000 config /var/www/html/config
COPY --chown=1000:1000 public /var/www/html/public
COPY --chown=1000:1000 resources /var/www/html/resources
COPY --chown=1000:1000 routes /var/www/html/routes
COPY --chown=1000:1000 storage /var/www/html/storage
COPY --chown=1000:1000 tests /var/www/html/tests
COPY --chown=1000:1000 artisan /var/www/html/artisan
COPY --chown=1000:1000 composer.json /var/www/html/composer.json
COPY --chown=1000:1000 composer.lock /var/www/html/composer.lock

RUN composer install
RUN rm -rf /var/www/html/composer.lock
