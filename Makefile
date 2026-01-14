DC=docker compose

.DEFAULT_GOAL := help

help:
	@echo "make up            Start containers"
	@echo "make down          Stop containers"

up:
	$(DC) up -d

down:
	$(DC) down
