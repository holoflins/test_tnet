start:
	docker-compose up -d

stop:
	docker-compose stop

init:
	docker-compose up -d
	docker exec -it test_tnet_php composer install
	docker exec -it test_tnet_php bin/console doctrine:schema:drop --force
	docker exec -it test_tnet_php bin/console doctrine:schema:update --force
	docker exec -it test_tnet_php bin/console doctrine:fixtures:load
	docker exec -it test_tnet_php vendor/bin/phpunit

down:
	docker-compose down --rmi all -v --remove-orphans

install-vendor:
	docker exec -it test_tnet_php composer install

update-vendor:
	docker exec -it test_tnet_php composer install

shell-php:
	docker exec -it test_tnet_php ash

shell-sql:
	docker exec -it test_tnet_sql bash

test:
	docker exec -it test_tnet_php bin/console doctrine:schema:drop --force
	docker exec -it test_tnet_php bin/console doctrine:schema:update --force
	docker exec -it test_tnet_php bin/console doctrine:fixtures:load
	docker exec -it test_tnet_php vendor/bin/phpunit

test-small:
	docker exec -it test_tnet_php vendor/bin/phpunit --testsuite=Small

test-medium:
	docker exec -it test_tnet_php vendor/bin/phpunit --testsuite=Medium

test-large:
	docker exec -it test_tnet_php vendor/bin/phpunit --testsuite=Large
