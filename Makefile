DC=docker compose
PHP_CONTAINER=php
PHP_TEST_CONTAINER=php_test
VUE_CONTAINER=vue
COVERAGE_PORT=8000

.DEFAULT_GOAL := help

help:
	@echo "make build            	Build containers"
	@echo "make up            		Start containers"
	@echo "make down          		Stop containers"
	@echo "make logs          		Follow logs of app container"
	@echo "make test          		Run PHPUnit tests"
	@echo "make coverage-server		Start PHP server to view coverage HTML"

build:
	docker-compose -f docker-compose.yml build $(PHP_CONTAINER) $(VUE_CONTAINER)

up:
	$(DC) up -d db
	@sleep 3

	@echo "create db if not already exists"
	@docker-compose -f docker-compose.yml run --rm $(PHP_CONTAINER) bin/console doctrine:database:create --if-not-exists
	@echo "run migrations"
	@docker-compose -f docker-compose.yml run --rm $(PHP_CONTAINER) bin/console doctrine:migrations:migrate --no-interaction

	$(DC) up -d $(PHP_CONTAINER)
	$(DC) up -d $(VUE_CONTAINER)

down:
	$(DC) down

logs-php:
	docker-compose logs -f $(PHP_CONTAINER)

logs-vue:
	docker-compose logs -f $(VUE_CONTAINER)

test-unit:
	docker-compose -f docker-compose.test.yml up -d --build $(PHP_TEST_CONTAINER)
	@sleep 3

	docker-compose -f docker-compose.test.yml run --rm $(PHP_TEST_CONTAINER) vendor/bin/phpunit --testsuite=Unit --coverage-html=var/coverage/unit

	docker-compose -f docker-compose.test.yml down -v

test-integration:
	docker-compose -f docker-compose.test.yml up -d --build
	@sleep 3

	docker-compose -f docker-compose.test.yml run --rm $(PHP_TEST_CONTAINER) bin/console doctrine:database:create --if-not-exists
	docker-compose -f docker-compose.test.yml run --rm $(PHP_TEST_CONTAINER) bin/console doctrine:migrations:migrate --no-interaction

	docker-compose -f docker-compose.test.yml run --rm $(PHP_TEST_CONTAINER) vendor/bin/phpunit --testsuite=Integration --coverage-html=var/coverage/integration

	docker-compose -f docker-compose.test.yml down -v

test-all: test-unit test-integration
	@echo "Alle Tests abgeschlossen. Coverage HTML:"
	@echo " - Unit: var/coverage/unit/index.html"
	@echo " - Integration: var/coverage/integration/index.html"

coverage-server:
	docker-compose run --rm -p $(COVERAGE_PORT):$(COVERAGE_PORT) $(PHP_CONTAINER) \
		php -S 0.0.0.0:$(COVERAGE_PORT) -t var/coverage/unit

lint:
	docker-compose -f docker-compose.yml run --rm $(PHP_CONTAINER) vendor/bin/php-cs-fixer fix --dry-run --diff

cs-fix:
	docker-compose -f docker-compose.yml run --rm $(PHP_CONTAINER) vendor/bin/php-cs-fixer fix

analyse:
	docker-compose -f docker-compose.yml run --rm $(PHP_CONTAINER) vendor/bin/phpstan analyse src tests --level max
