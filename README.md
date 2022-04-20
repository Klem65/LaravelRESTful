# LaravelRESTful

###Запустить контейнеры:

docker-compose up -d

### Установить зависимости 

cd laravelapp

composer install

chmod -R 777 storage

###Выполнить миграции и наполнение бд:

docker-compose exec fpm php artisan migrate --seed

###Открыть коллекию постман для тестирования api
