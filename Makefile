include Makefile-variables

dev: | docker-build docker-up composer-install

##### docker compose

docker-build:
	docker-compose ${COMPOSE_DEV_FILE} build

docker-up:
	docker-compose ${COMPOSE_DEV_FILE} up -d

docker-down:
	docker-compose ${COMPOSE_DEV_FILE} down -v

docker-stop:
	docker-compose ${COMPOSE_DEV_FILE} stop

docker-rm:
	docker-compose ${COMPOSE_DEV_FILE} rm -v

docker-logs:
	docker-compose ${COMPOSE_DEV_FILE} logs --tail 50 -f

docker-ps:
	watch docker-compose ${COMPOSE_DEV_FILE} ps

##### composer

composer-install:
	docker-compose ${COMPOSE_DEV_FILE} exec php-fpm sh -c "composer install"

##### console and shell

console:
	docker-compose ${COMPOSE_DEV_FILE} exec php-fpm sh -c "php bin/console ${argument}"

shell-fpm:
	docker-compose ${COMPOSE_DEV_FILE} exec php-fpm /bin/bash

shell-nginx:
	docker-compose ${COMPOSE_DEV_FILE} exec nginx /bin/bash

##### db

db-migrate:
	docker-compose ${COMPOSE_DEV_FILE} exec php-fpm sh -c "php bin/console doctrine:migrations:migrate"

db-diff:
	docker-compose ${COMPOSE_DEV_FILE} exec php-fpm sh -c "php bin/console doctrine:migrations:diff"

##### tests

test: | test-unit test-functional

test-unit:
	docker-compose ${COMPOSE_DEV_FILE} exec --env APP_ENV=test php-fpm sh -c "bin/phpunit --testsuite unit"

test-functional:
	docker-compose ${COMPOSE_DEV_FILE} exec --env APP_ENV=test php-fpm sh -c "bin/phpunit --testsuite functional"
