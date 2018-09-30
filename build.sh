#!/usr/bin/env bash
rm .env
if [ ! -f .env ]; then
    touch .env
    echo PHP_SSH_PORT=23 >> .env
    echo KILABS_SERVER_PORT=81 >> .env
    echo VENDOR_DIR=/var/www/vendor >> .env
    echo LOCAL_IP=0.0.0.0 >> .env
    echo MYSQL_PORT=3307 >> .env
    echo LOCAL_DEV_DIR=$(pwd) >> .env
    echo APP_ENV=dev >> .env
    APP_SECRET=e5565d22e6b3514549e6fa218ef7555b >> .env
    DATABASE_URL="mysql://root:root@mysql:3306/kilab_db" >> .env

fi

docker-compose build
docker-compose up -d
docker-compose exec worker composer install
docker-compose down
docker-compose up -d

