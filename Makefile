DC=docker compose
APP_CONTAINER=app
COVERAGE_PORT=8000

.DEFAULT_GOAL := help

help:
	@echo "make up            		Start containers"
	@echo "make down          		Stop containers"
	@echo "make logs          		Follow logs of app container"
	@echo "make test          		Run PHPUnit tests"
	@echo "make coverage-server		Start PHP server to view coverage HTML"

up:
	$(DC) up -d

down:
	$(DC) down

logs:
	docker-compose logs -f $(APP_CONTAINER)

test:
	docker-compose run --rm $(APP_CONTAINER) vendor/bin/phpunit

coverage-server:
	docker-compose run --rm -p $(COVERAGE_PORT):$(COVERAGE_PORT) $(APP_CONTAINER) \
		php -S 0.0.0.0:$(COVERAGE_PORT) -t var/coverage/html
