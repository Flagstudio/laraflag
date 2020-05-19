#!/usr/bin/make

SHELL = /bin/sh
APP_CONTAINER=docker-compose exec app
HOSTNAME=project_name


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

start-local: ## start project on local
	docker-compose -f docker-compose.local.yml up -d --remove-orphans
	docker-compose -f docker-compose.local.yml exec app composer global require hirak/prestissimo
	docker-compose -f docker-compose.local.yml exec app composer install
	docker-compose -f docker-compose.local.yml exec app npm i
	docker-compose -f docker-compose.local.yml exec app npm run dev

# build-base: ## Build and push BASIC app image
# 	docker build -t registry.gitlab.com/flagstudio/laraflag:base -f docker/app/Dockerfile_base_image .
# 	docker push registry.gitlab.com/flagstudio/laraflag:base

build: ## Build app image
	docker-compose -f docker-compose.build.yml build app

build-ssl-base: ## Build SSL image
	docker build -t registry.gitlab.com/flagstudio/laraflag:ssl-base -f docker/ssl/Dockerfile .
	docker push registry.gitlab.com/flagstudio/laraflag:ssl-base

build-up: ## Build and start app image
	docker-compose -f docker-compose.build.yml up --remove-orphans --build -d app

push: ## Push app image
	docker-compose  -f docker-compose.build.yml push app

pull: ## Pull and start app image
	docker-compose pull app
	docker-compose up --remove-orphans -d app

# pull-ssl: ## Pull and start SSL image
# 	docker-compose pull ssl
# 	docker-compose up --remove-orphans -d ssl

tail: ## Tail laravel.log
	$(APP_CONTAINER) tail -f storage/logs/laravel.log

deploy-settings: ## Deploy settings to prod
	scp docker/ssl/Caddyfile_SSL $(HOSTNAME):its.academy/
	scp docker-compose.prod.yml $(HOSTNAME):its.academy/docker-compose.yml

laraflag-settings: ## Copy settings from Laraflag
	rm -rf docker/
	cp -r ../laraflag/Makefile .
	cp -r ../laraflag/docker* .
	cp -r ../laraflag/docker .
	cp -r ../laraflag/.gitlab-ci.yml .
	cp -r ../laraflag/.env.example .
	cp -r ../laraflag/.dockerignore .
