#!/usr/bin/env bash

DOCKER_FILE=docker-compose.yml

# stop docker containers
docker compose -f $DOCKER_FILE down --remove-orphans

# rebuild and start docker containers
env UID=$(id -u) GID=$(id -g) docker compose -f $DOCKER_FILE up -d --build

# install dependencies
docker exec -it --user www-data skanderm-php-1 composer install --no-interaction --prefer-dist --optimize-autoloader
docker exec -it --user node skanderm-node_backend-1 npm install
docker exec -it --user node skanderm-node_frontend-1 npm install

# build backend and run admin page (LOCAL ONLY)
docker exec -it -d --user node skanderm-node_backend-1 npm run build -- --watch 
docker exec -it -d --user node skanderm-node_frontend-1 npm run dev -- --port 3000 --host
