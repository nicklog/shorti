#!/usr/bin/env bash

echo 'Starting yarn at:'; date
yarn install --force || exit $?

echo 'Starting composer at:'; date
composer install --no-interaction --no-progress --no-ansi --working-dir="${PWD}" || exit $?

echo 'Starting yarn prod at:'; date
yarn dev || exit $?

echo 'Starting doctrine:database:create -n at:'; date
php bin/console doctrine:database:create --if-not-exists || exit $?

echo 'Starting doctrine:migration:migrate at:'; date
php bin/console doctrine:migration:migrate --no-interaction || exit $?

echo 'Finished at:'; date
