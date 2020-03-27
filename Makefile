#!/usr/bin/make


# This will output the help for each task. thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help: ## Show this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)


# --- [ Application ] -------------------------------------------------------------------------------------------------

start-prod: ## Start Prod
	docker-compose exec workspace composer install --no-dev -q
	docker-compose exec workspace php artisan key:generate
	docker-compose exec workspace php artisan storage:link
	docker-compose exec workspace php artisan config:cache
	docker-compose exec workspace php artisan route:cache
	docker-compose exec workspace npm i
	docker-compose exec workspace npm run prod
	chmod -R 777 bootstrap/ storage/

update-prod: ## Update prod
	git stash
	git fetch origin master
	git checkout master
	git reset --hard origin/master
	docker-compose exec workspace composer install --no-dev -q
	docker-compose exec workspace php artisan migrate --force --quiet
	docker-compose exec workspace php artisan view:clear
	docker-compose exec workspace php artisan config:cache
	docker-compose exec workspace php artisan route:cache
	docker-compose exec workspace npm run prod
	chmod -R 777 bootstrap/ storage/

start-local: ## Start Local
	docker-compose exec workspace composer install
	docker-compose exec workspace php artisan migrate --seed
	docker-compose exec workspace php artisan key:generate
	docker-compose exec workspace php artisan storage:link
	docker-compose exec workspace php artisan ide-helper:generate
	docker-compose exec workspace npm i
	docker-compose exec workspace npm run dev

update-local: ## Update Local
	docker-compose exec workspace composer install
	docker-compose exec workspace php artisan ide-helper:generate
	docker-compose exec workspace php artisan ide-helper:models -N
	docker-compose exec workspace npm run dev

mfs: ## Refresh and seed database
	docker-compose exec workspace php artisan migrate --seed

test: ## Run tests
	docker-compose exec workspace ./vendor/bin/phpunit --testdox
