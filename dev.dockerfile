FROM ezsystems/php:7.2
WORKDIR "/var/www"

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get install apt-transport-https lsb-release ca-certificates wget curl build-essential nano dialog net-tools gnupg nginx -y

RUN curl -sL https://deb.nodesource.com/setup_8.x | bash \
    && apt-get install -y nodejs

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN echo "daemon off;" >> /etc/nginx/nginx.conf

RUN rm /etc/nginx/sites-available/default

COPY ./dev_setup/nginx_internal.conf /etc/nginx/conf.d/laravel-graphql.dev.conf

RUN cat /etc/nginx/conf.d/laravel-graphql.dev.conf

EXPOSE 8001

CMD (php-fpm &) && service nginx start
