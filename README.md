# LaravelRESTful

###Запустить контейнеры:

docker-compose up -d

###Выполнить миграции и наполнение бд:

docker-compose exec fpm php artisan migrate --seed

###Открыть коллекию постман для тестирования api