

test:
	@docker exec -it appto-users-php make run-tests

coverage:
	@docker exec -it appto-users-php make run-coverage

phpunit: 
	@docker exec -it appto-users-php make run-phpunit

run-tests:
	mkdir -p build/test_results/phpunit
	./vendor/bin/phpstan analyse -l 5 -c etc/phpstan/phpstan.neon src
	./vendor/bin/phpunit --log-junit build/test_results/phpunit/junit.xml tests

run-phpunit:
	./vendor/bin/phpunit

run-coverage:
	mkdir -p build/test_results/phpunit/coverage
	./vendor/bin/phpunit --coverage-html build/test_results/phpunit/coverage

init:
	@docker exec -it appto-users-php make run-init

run-init:
	composer install

