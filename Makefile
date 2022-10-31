build:
	./vendor/bin/sail up -d
	./vendor/bin/sail composer install
	docker build --target local -t local/architect .

run-docker-schema:
	docker run --rm --name=architect \
	  -v $(shell pwd):/var/www/project \
	  -e PROJECT_PATH_PREFIX=/var/www/project \
	  -e CODEGEN_PATH=src/Architect \
	  -e SCHEMA_PATH=src/schema-laravel-ddv1.json \
	  -e LINTER_CONFIG_PATH=config/abstractions.php \
	  -e ARCHITECT_PATH=architect.yaml \
	  local/architect \
  	-c "php /var/www/html/artisan schema:laravel-ddv1"

run-docker-codegen:
	docker run -it --rm --name=architect \
	  -v $(shell pwd):/var/www/project \
	  -e PROJECT_PATH_PREFIX=/var/www/project \
	  -e CODEGEN_PATH=src/Architect \
	  -e SCHEMA_PATH=src/schema-laravel-ddv1.json \
	  -e LINTER_CONFIG_PATH=config/abstractions.php \
	  -e ARCHITECT_PATH=architect.yaml \
	  local/architect \
	-c "php /var/www/html/artisan codegen:laravel-ddv1"

build-production-and-push:
	docker build --target production -t vladitot/architect:$(tag) .
	docker push vladitot/architect:$(tag)

build-production:
	docker build --target production -t vladitot/architect:$(tag) .
