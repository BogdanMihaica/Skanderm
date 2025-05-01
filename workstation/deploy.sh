#!/usr/bin/env bash

# stop docker containers
docker compose down --remove-orphans

# rebuild and start docker containers
docker compose up -d --build