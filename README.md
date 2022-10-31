# Welcome to Architect
Architect is community supported code generation solution. 

With Architect you can create abstract architecture of your project fast and controllable.

### Ready to use profiles:
 1. Laravel Custom Architecture, based on Domain Problems: "laravel-ddv1"
 2. More coming soon.

### Using laravel-ddv1

    `docker run --rm --name=architect \
	  -v `pwd`:/var/www/project \ ## pwd is your current project directory
	  -e PROJECT_PATH_PREFIX=/var/www/project \ ## just leave as here
	  -e CODEGEN_PATH=src/Architect \ ## directory inside your project, where to generate code
	  -e SCHEMA_PATH=schema-laravel-ddv1.json \ ## path, where json schema will be generated
	  -e LINTER_CONFIG_PATH=config/abstractions.php \ ## file, where all abstractions in array will be written
	  -e ARCHITECT_PATH=architect.yaml \  ## file, where your architecture schema should be
	  vladitot/architect:v0.0.9 \
  	    -c "php /var/www/html/artisan schema:laravel-ddv1"`


    `docker run -it --rm --name=architect \
        -v `pwd`:/var/www/project \ ## pwd is your current project directory
        -e PROJECT_PATH_PREFIX=/var/www/project \ ## just leave as here
        -e CODEGEN_PATH=src/Architect \ ## directory inside your project, where to generate code
        -e SCHEMA_PATH=schema-laravel-ddv1.json \ ## path, where json schema will be generated
        -e LINTER_CONFIG_PATH=config/abstractions.php \ ## file, where all abstractions in array will be written
        -e ARCHITECT_PATH=architect.yaml \ ## file, where your architecture schema should be
        vladitot/architect:v0.0.9 \
        -c "php /var/www/html/artisan codegen:laravel-ddv1"`
