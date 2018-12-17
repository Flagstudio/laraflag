#!/usr/bin/make

SHELL = /bin/sh


#

# This will output the help for each task. thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help: ## Show this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)


# --- [ Application ] -------------------------------------------------------------------------------------------------

install: ## Update project
	composer install
	php artisan migrate:fresh --seed
	php artisan view:clear
	php artisan ide-helper:generate
	chmod -R 777 bootstrap/ storage/
	npm i
	npm run dev

start: ## start new project
	composer install
	php artisan storage:link
	cp .env.example .env
	php artisan key:generate
	echo "\033[1;31mNow you need to set your DB credentials!\033[0m"

test: ## Run tests
	./vendor/bin/phpunit --testdox
