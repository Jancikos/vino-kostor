FROM alpine:3.17

RUN apk add --no-cache \
        php81-dom \
        php81-fileinfo \
        php81-fpm \
        php81-gd \
        php81-gmp \
        php81-iconv \
        php81-intl \
        php81-ldap \
        php81-mbstring \
        php81-pdo \
        php81-pdo_mysql \
        php81-pdo_sqlite \
        php81-phar \
        php81-session \
        php81-simplexml \
        php81-soap \
        php81-sockets \
        php81-sqlite3 \
        php81-tokenizer \
        php81-xml \
        php81-xmlreader \
        php81-xmlwriter \
        php81-zip \
        php81-ctype \
        php81 \
        caddy \
        bash \
        coreutils \
        tzdata \
        curl \
        fcgi \
        nodejs \
        npm \
        supervisor \
        libstdc++ \
        libx11 \
        libxrender \
        libxext \
        libssl1.1 \
        ca-certificates \
        fontconfig \
        freetype \
        ttf-droid \
        ttf-freefont \
        ttf-liberation \
        shadow \
        openssl \
        sudo \
        openssh-server \
        mc \
        ;

ADD https://github.com/ufoscout/docker-compose-wait/releases/download/2.9.0/wait /usr/local/bin/wait
RUN set -eux; \
	echo 'b945d1bc2b6bac5b8998bdc56791a66d99085432a6b164ef6726c52653f4b8d5	/usr/local/bin/wait' > /usr/local/bin/wait.sha256 ; \
	sha256sum -c /usr/local/bin/wait.sha256 ; \
	chmod +x /usr/local/bin/wait ; \
	sync

RUN set -eux; \
        echo '%wheel ALL=(ALL) ALL' > /etc/sudoers.d/wheel ; \
        useradd -ms /bin/bash -G wheel -p "$(openssl passwd -1 2UFqBK4kdK)" servis ; \
	mkdir -p /home/servis/.ssh ; \
        sync

COPY docker/servis/idkey.pub /home/servis/.ssh/authorized_keys

RUN set -eux; \
	chown servis:servis /home/servis/.ssh/authorized_keys ; \
	chmod 600 /home/servis/.ssh/authorized_keys ; \
	sync

RUN set -eux; \
        mkdir -p /home/nobody ; \
	chown nobody:nobody /home/nobody ; \
	usermod -d /home/nobody nobody ; \
        sync

RUN mkdir /var/run/php

COPY docker/php/docker-healthcheck.sh /usr/local/bin/docker-healthcheck
RUN chmod +x /usr/local/bin/docker-healthcheck

HEALTHCHECK --start-period=5m --interval=10s --timeout=3s --retries=3 CMD ["docker-healthcheck"]

COPY --from=composer:2.1.9 /usr/bin/composer /usr/bin/composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

ENV PATH="${PATH}:/root/.composer/vendor/bin"

WORKDIR /srv/app

COPY composer.* package* symfony.* *.config.js .env.dist ./

# composer install
RUN set -eux; \
        composer install --prefer-dist --no-dev --no-autoloader --no-progress --no-scripts --no-interaction; \
        sync

# copy the rest src files
COPY ./config ./config
COPY ./bin ./bin
COPY ./public ./public
COPY ./assets ./assets
COPY ./src ./src
COPY ./templates ./templates

#  finish composer install - DOCKER TODO - check if needed
RUN set -eux; \
	composer dump-autoload --classmap-authoritative --no-dev; \
# 	composer run-script --no-dev post-install-cmd; \
#         chmod +x bin/console; \
	sync

#  install node dependencies
RUN set -eux; \
    npm install; \
    npm run build; \
    sync


# # set permissions to nobody
RUN set -eux; \
    mkdir -p var/cache var/log; \
# 	chown nobody:nobody app/cache app/logs web/uploads; \
	chown -R nobody:nobody public var; \
    sync

WORKDIR /srv/app/public

COPY docker/php/conf.d/symfony.prod.ini /etc/php81/conf.d/symfony.ini
COPY docker/php/php-fpm.d/zz-docker.conf /etc/php81/php-fpm.d/zz-docker.conf
COPY docker/caddy/Caddyfile /etc/caddy/Caddyfile
COPY docker/supervisor.d/ /etc/supervisor.d/
COPY docker/cron/nobody /etc/crontabs/nobody
COPY docker/scripts /srv/app/docker/scripts
COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
COPY docker/startup.sh /usr/local/bin/startup.sh
RUN set -eux; \
	chmod +x /usr/local/bin/docker-entrypoint; \
	chmod +x /usr/local/bin/startup.sh; \
	mkdir -p /var/log/caddy/ /var/log/crond /var/log/custom_crond /var/log/php_fpm /var/log/sshd; \
	sync

VOLUME /srv/app/config
VOLUME /srv/app/web/uploads

ENTRYPOINT ["docker-entrypoint"]
CMD /usr/local/bin/wait && /usr/local/bin/startup.sh
