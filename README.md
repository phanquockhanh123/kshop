# k-shop
## Enviroment
### Build docker
- `docker-compose build`
### Run docker
- `docker-compose up`
### ssh to docker instance
- `docker exec -it gate-api-php bash`
### Install laravel's packages
- `composer install`
### DB migration
- `php artisan migrate`
### Run application
- http://localhost:8010
### Doc API
- http://localhost:8010/api/v1/documentation
### Debug query for perfomance
- http://localhost:8010/clockwork/app
### Check coding convention
- `./vendor/bin/phpcs --ignore=./vendor/,./storage,./resources,./bootstrap,./database,./public,./config,./docs --standard=PSR12 --extensions=php ./`
