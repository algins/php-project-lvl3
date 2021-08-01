start:
	php artisan serve --host 0.0.0.0

setup:
	composer install
	cp -n .env.example .env || true
	php artisan key:gen --ansi
	touch database/database.sqlite
	npm install

test:
	php artisan test

deploy:
	git push heroku main

lint:
	composer phpcs
