COMPOSER= composer
PHPCS= ./bin/phpcs
PHPUNIT= ./bin/phpunit

install:
	$(COMPOSER) install

update:
	$(COMPOSER) update

test: update
	$(PHPUNIT) -c .

php-lint:
	$(PHPCS) --colors --standard=psr2 -nq src

ci: install php-lint test
