include .env

start: docker-up
stop: docker-down
init: \
	docker-down-clear \
	docker-pull \
	docker-build \
	docker-up

docker-up:
	docker compose up -d

docker-down:
	docker compose down --remove-orphans

docker-down-clear:
	docker compose down -v --remove-orphans

docker-pull:
	docker compose pull

docker-build:
	docker compose build



deptrac-layers:
	${PHP_CLI_EXEC} composer deptrac

psalm:
	${PHP_CLI_EXEC} composer psalm

test:
	${PHP_CLI_EXEC} composer test

infection:
	${PHP_CLI_EXEC} composer infection

infection-covered:
	${PHP_CLI_EXEC} composer infection covered

start-infection-server:
	${PHP_CLI_EXEC} php -S localhost:8000 -t var/test/infection

php-cli-version:
	docker-compose run --rm ${COMPOSE_PROJECT_NAME}-php-cli php --version
