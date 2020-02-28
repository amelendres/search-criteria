

test:
	@docker exec -it appto-booking-php make run-tests

run-tests:
	mkdir -p build/test_results/phpunit
	./vendor/bin/phpstan analyse -l 5 -c etc/phpstan/phpstan.neon src
	./vendor/bin/phpunit --log-junit build/test_results/phpunit/junit.xml tests

init:
	@docker exec -it appto-booking-php make run-init

run-init:
	composer install
	bin/console d:d:c
	bin/console d:s:u --force
	bin/console d:f:l -n

