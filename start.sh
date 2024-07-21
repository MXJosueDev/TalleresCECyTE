#!/bin/sh
set -a
source .env.docker
set +a

docker compose up "$@"