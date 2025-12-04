#!/usr/bin/env bash
set -e

echo "Building Docker images..."
./vendor/bin/sail build --no-cache

echo "Starting containers..."
./vendor/bin/sail up -d

echo "Running database migrations..."
./vendor/bin/sail artisan migrate --force

echo "Dockerized Laravel REST API is available at http://localhost"
