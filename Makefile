start:
	docker compose up -d php

dependencies:
	docker compose run --rm php composer install

init: start dependencies

start-ci:
	docker compose up -d php-ci

init-ci: start-ci dependencies

init-db-test:
	docker compose run --rm php bin/console doctrine:database:create --env=test
	docker compose run --rm php bin/console doctrine:schema:create --env=test

php-cs-fixer:
	docker compose run --rm --env PHP_CS_FIXER_IGNORE_ENV=1 php vendor/bin/php-cs-fixer fix --dry-run

php-cs-fixer-fix:
	docker compose run --rm --env PHP_CS_FIXER_IGNORE_ENV=1 php vendor/bin/php-cs-fixer fix

test:
	docker compose run --rm php vendor/bin/phpunit

ssh-php:
	docker compose exec php bash

