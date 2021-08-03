start:
	php artisan serve --host 0.0.0.0

setup:
	composer install
	cp -n .env.example .env || true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm install

watch:
	npm run watch

prod:
	npm run prod

migrate:
	php artisan migrate

test:
	php artisan test

test-coverage:
	php artisan test --coverage-clover build/logs/clover.xml

deploy:
	git push heroku main

lint:
	composer phpcs
