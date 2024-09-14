#!/usr/bin/make
# Makefile readme (ru): <http://linux.yaroslavl.ru/docs/prog/gnu_make_3-79_russian_manual.html>
# Makefile readme (en): <https://www.gnu.org/software/make/manual/html_node/index.html#SEC_Contents>

SHELL = /bin/bash
RUN_APP_ARGS = --rm --user "$(shell id -u):$(shell id -g)"

.PHONY : help build setup up down pint test shell clean
.DEFAULT_GOAL : help

# This will output the help for each task. thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help: ## Show this help
	@printf "\033[33m%s:\033[0m\n" 'Available commands'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[32m%-14s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build docker images, required for the current project environment
	docker-compose build

setup: ## Setup project
	docker compose run $(RUN_APP_ARGS) php chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
	docker compose run $(RUN_APP_ARGS) php chmod -R 775 /var/www/storage /var/www/bootstrap/cache
	docker-compose run $(RUN_APP_ARGS) php composer setup

up: ## Up all containers
	docker-compose up --detach --remove-orphans

down: ## Down all containers
	docker-compose down

pint: ## Execute laravel pint
	docker-compose run $(RUN_APP_ARGS) php composer pint

test: ## Execute php tests
	docker-compose run $(RUN_APP_ARGS) php composer test

shell: ## Start shell into container with php
	docker-compose run $(RUN_APP_ARGS) php bash

clean: ## Remove all dependencies and unimportant files
	-rm -rf ./composer.lock ./vendor ./coverage ./tests/temp
