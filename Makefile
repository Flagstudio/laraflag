#!/usr/bin/make

SHELL = /bin/sh
APP_CONTAINER=docker-compose exec app

#

# This will output the help for each task. thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help: ## Show this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)


# --- [ Application ] -------------------------------------------------------------------------------------------------

update-dev: ## Update project
	$(APP_CONTAINER) composer install
	$(APP_CONTAINER) php artisan migrate:fresh --seed
	$(APP_CONTAINER) php artisan view:clear
	$(APP_CONTAINER) php artisan ide-helper:generate
	chmod -R 777 bootstrap/ storage/

update-prod: ## Update project
	$(APP_CONTAINER) composer install --no-dev
	$(APP_CONTAINER) php artisan migrate --force
	$(APP_CONTAINER) php artisan view:clear
	$(APP_CONTAINER) chmod -R 777 bootstrap/ storage/
	$(APP_CONTAINER) php artisan config:cache
	$(APP_CONTAINER) php artisan route:cache

start-prod: ## start new project
	cp .env.example .env
	make update-prod
	$(APP_CONTAINER) php artisan key:generate
	$(APP_CONTAINER) php artisan storage:link

build: ## Build PHP image
	docker build -t registry.gitlab.com/flagmaker/laraflag:latest -f docker/php-fpm/Dockerfile .

build-up: ## Build and start PHP image
	docker-compose -f docker-compose.build.yml up --build -d app

buildbase: ## Build and start PHP image
	docker build -t registry.gitlab.com/flagmaker/laraflag:base -f docker/php-fpm/Dockerfile_base_image .
	docker push registry.gitlab.com/flagmaker/laraflag:base

push: ## Build PHP image
	docker push registry.gitlab.com/flagmaker/laraflag:latest

pull: ## Pull and start PHP image
	docker-compose pull app
	docker-compose up --remove-orphans -d app

tail: ## Tail laravel.log
	$(APP_CONTAINER) tail -f storage/logs/laravel.log
