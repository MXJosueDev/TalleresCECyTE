#!/bin/sh
set -a
. ./.env.docker
set +a

docker compose up "$@"