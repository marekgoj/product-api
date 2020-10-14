include Makefile-variables

all: | docker-build docker-up composer-deps

composer-deps: | composer-install composer-dump-autoload

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
	docker-compose ${COMPOSE_DEV_FILE} exec ${COMPOSE_EXEC_OPTIONS} php-fpm sh -c "composer install"

composer-dump-autoload:
	docker-compose ${COMPOSE_DEV_FILE} exec ${COMPOSE_EXEC_OPTIONS} app sh -c "composer dump-autoload"

##### console and shell

console:
	docker-compose ${COMPOSE_DEV_FILE} exec ${COMPOSE_EXEC_OPTIONS} php-fpm sh -c "php bin/console ${argument}"

shell-fpm:
	docker-compose ${COMPOSE_DEV_FILE} exec ${COMPOSE_EXEC_OPTIONS} php-fpm /bin/bash

shell-nginx:
	docker-compose ${COMPOSE_DEV_FILE} exec ${COMPOSE_EXEC_OPTIONS} nginx /bin/bash
