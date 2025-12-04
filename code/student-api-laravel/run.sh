#!/usr/bin/env bash
set -e

echo "Starting Laravel Sail containers..."
./vendor/bin/sail up -d

echo "Running database migrations..."
./vendor/bin/sail artisan migrate --force

echo "Laravel REST API is available at http://localhost"
