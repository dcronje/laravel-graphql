#!/bin/bash

# Install supporting images
echo "Installing Dependencies:"
echo "     *****     "
echo " "

## MYSQL ##
echo "Installing MySQL"
docker stop mysql || true && docker rm mysql || true
docker -D run -d \
  --restart=always \
  --name mysql \
  -e MYSQL_ROOT_PASSWORD=root \
  -p 3306:3306 \
  -v ~/docker/mysql/backups:/home/backups \
  -v ~/docker/mysql/db:/var/lib/mysql \
  mysql
docker start mysql

## Redis ##
echo "Installing Redis"
docker stop redis || true && docker rm redis || true
docker -D run -d \
  --name=redis \
  --restart=always \
  -e TZ=Africa/Johannesburg \
  -p 6379:6379 \
  redis:4

## NGINX ##
echo "Installing NGINX"
docker stop nginx || true && docker rm nginx || true
docker -D run -d \
  --restart=always \
  --name nginx \
  -p 80:80 \
  -p 443:443 \
  -v ~/docker/nginx-proxy/conf.d:/etc/nginx/conf.d/ \
  -v ~/docker/nginx-proxy/certs:/etc/nginx/certs \
  -v ~/docker/nginx-proxy/vhosts:/etc/nginx/vhost.d \
  -v ~/docker/nginx-proxy/passwords:/etc/nginx/htpasswd \
  -v ~/docker/nginx-proxy/www:/usr/share/nginx/html \
  -v /var/run/docker.sock:/tmp/docker.sock:ro \
  jwilder/nginx-proxy:latest
docker start nginx

echo "Configuring SSL"
cp ./dev_setup/local_ssl/server.crt ~/docker/nginx-proxy/certs/laravel-graphql.dev.crt
cp ./dev_setup/local_ssl/server.key ~/docker/nginx-proxy/certs/laravel-graphql.dev.key
cp ./dev_setup/local_ssl/dhparam.pem ~/docker/nginx-proxy/certs/laravel-graphql.dev.pem
cp ./dev_setup/nginx.conf ~/docker/nginx-proxy/vhosts/laravel-graphql.dev.conf

docker restart nginx

# Compse dev image
echo "Building docker development image"
echo "     *****     "
echo " "
docker-compose --project-name laravel-graphql build web

# Remove previous instances
echo "Removing previous image"
echo "     *****     "
echo " "
docker stop laravel-graphql-web || true && docker rm laravel-graphql-web || true

# Run image
echo "Running image"
echo "     *****     "
echo "in event of error please run: sudo apachectl stop"
docker -D run -d \
  --name laravel-graphql-web \
  -v $(pwd):/var/www \
  -e VIRTUAL_HOST=laravel-graphql.dev \
  -e VIRTUAL_PORT=8001 \
  -p 8001:8001 \
  --link mysql:mysql \
  --link redis:redis \
  --net=bridge \
  laravelgraphql_web

# Start image
echo "Starting image"
echo "     *****     "
echo " "
docker start laravel-graphql-web

# Install dependencies
echo "Installing Dependencies"
echo "     *****     "
echo " "
docker exec -it laravel-graphql-web /bin/bash -c "cp .env.docker .env && cp ./dev_setup/index.html ./public/index.html && rm ./public/index.php && composer install && cp ./dev_setup/index.php ./public/index.php && rm ./public/index.html"
