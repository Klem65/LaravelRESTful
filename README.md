# LaravelRESTful

###Запустить контейнеры:

docker-compose up -d

### Установить зависимости 

cd laravelapp

composer install

chmod -R 777 storage

### Подключить БД в файле .env

mv .env .env.example

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravelapp
DB_USERNAME=root
DB_PASSWORD=pass

###Выполнить миграции и наполнение бд:

docker-compose exec fpm php artisan migrate --seed

###Открыть коллекию постман для тестирования api
