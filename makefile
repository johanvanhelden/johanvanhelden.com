.DEFAULT_GOAL := init
TEST_COVERAGE_MINIMUM ?= 95.0
NODE_VERSION ?= 22

.PHONY: $(filter-out vendor node_modules,$(MAKECMDGOALS))

in:
	@docker exec --user=dockerhero -it dockerhero_workspace bash -c "cd /var/www/projects/laravel-template; exec bash"

vendor: composer.json composer.lock
	@composer install

	@# Only executing "composer install" won't affect the modified date of the "vendor" directory.
	@# By touching the directory a better comparison between source and target modifications can be made.
	@touch -c $@

node_modules: package.json package-lock.json
	@make set-nvm

	@npm ci

	@# Only executing "composer install" won't affect the modified date of the "vendor" directory.
	@# By touching the directory a better comparison between source and target modifications can be made.
	@touch -c $@

	@make set-nvm-default

set-nvm:
	@[ -f ~/.nvm/nvm.sh ] && . ~/.nvm/nvm.sh && nvm install ${NODE_VERSION} && nvm use ${NODE_VERSION}

set-nvm-default:
	@[ -f ~/.nvm/nvm.sh ] && . ~/.nvm/nvm.sh && nvm use default

ide-helpers: vendor
	@php artisan ide-helper:models --nowrite

init: vendor node_modules assets
	@cp -n .env.example .env
	@make key
	@make ide-helpers

key: vendor
	@php artisan key:generate

assets: node_modules
	@make set-nvm

	@npm run prod

	@make set-nvm-default

assets-dev: node_modules
	@make set-nvm

	@npm run dev

	@make set-nvm-default

audit:
	@make set-nvm

	@npm audit --omit=dev

	@make set-nvm-default

validate: vendor node_modules code-quality code-style test

code-quality: vendor syntax stan md

code-style: vendor node_modules cs cs-fix-dry validate-fe

syntax:
	@find app config lang routes tests -name "*.php" -print0 | xargs -0 -n1 -P8 php -l

stan: vendor
	@vendor/bin/phpstan analyse --memory-limit=2G --configuration=phpstan.neon

md: vendor
	@phpmd app text ./phpmd.xml

cs: vendor
	@phpcs --standard=./phpcs.xml -p

cs-fix: vendor
	@php-cs-fixer fix app config lang routes tests --diff --config=.php-cs-fixer.php

cs-fix-dry: vendor
	@php-cs-fixer fix app config lang routes tests --dry-run --diff --config=.php-cs-fixer.php

validate-styles: node_modules
	@make set-nvm

	@npm run validate:styles

	@make set-nvm-default

fix-styles: node_modules
	@make set-nvm

	@npm run fix:styles

	@make set-nvm-default

validate-fe: node_modules
	@make set-nvm

	@npm run validate

	@make set-nvm-default

fix-fe: node_modules
	@make set-nvm

	@npm run fix

	@make set-nvm-default

test: vendor node_modules
	@php artisan test --compact
	@npm run test

test-coverage: vendor node_modules
	@php artisan test --compact --coverage --min=${TEST_COVERAGE_MINIMUM}

test-coverage-report: vendor
	@php -d pcov.enabled=1 ./vendor/bin/phpunit --coverage-html public/tests-report
