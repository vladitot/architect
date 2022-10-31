build:
	./vendor/bin/sail up -d
	./vendor/bin/sail composer install
	docker build -t local/architect .

run-docker-schema:
	docker run --rm --name=architect \
	  -v ./:/var/www/project \
	  -e PROJECT_PATH_PREFIX=/var/www/project \
	  -e CODEGEN_PATH=src/Architect \
	  -e SCHEMA_PATH=src/schema-laravel-ddv1.json \
	  -e LINTER_CONFIG_PATH=config/abstractions.php \
	  local/architect \
  	-c "artisan schema:generate-ddv1"
