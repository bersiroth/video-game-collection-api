start:
	docker compose up -d php

dependencies:
	docker compose exec -T php composer install

init: start dependencies

php-cs-fixer-fix:
	docker compose exec -T --env PHP_CS_FIXER_IGNORE_ENV=1 php vendor/bin/php-cs-fixer fix

ssh-php:
	docker compose exec php bash

init-db-test:
	docker compose exec -T php bin/console doctrine:database:create --env=test
	docker compose exec -T php bin/console doctrine:schema:create --env=test

test:
	docker compose exec -T php vendor/bin/phpunit