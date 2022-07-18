install:
	composer install

validate:
	composer validate

lint:
	composer run-script phpcs

test:
	composer run-script phpunit
