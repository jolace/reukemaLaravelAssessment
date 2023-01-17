# Reukema Laravel assessment 20230103

Application is set to work in few docker enviorments.
1.  Docker **app-reukema** contain application code and execute all client requests
2.  Docker **app-reukema-queue** care about executing laravel asynchronous jobs
3.  Docker **app-reukema-scheduler** care about cronjob commands
4.  Docker **mysql-reukema** is mysql 8 server for mySql database.
5.  Docker **adminer-reukema** is with installed Adminer UI for manage mySql database

## Runing the application

### Prerequirments

- To have docker installed on your machine

### Install
```
$ docker-compose up -d
```
```
$ docker exec -it app-reukema composer install
```
```
$ docker exec -it app-reukema  chmod 777 -R storage
```
```
$ docker exec -it app-reukema  php artisan migrate
```

### ENV Variables

```php
MONTH_INTERVAL = 5 // Month betwen reports
DEFAULT_QUERY_LIMIIT = 20
API_KEY_NAME  = ApiKey // Name for key that we will use to access API
API_KEY_VALUE = 123456 // Api token value
```

## Packages used

1. laravel/breeze for Auth routes and views 

2. Spatie for Laravel roles and permissions  https://spatie.be/docs/laravel-permission/v5/advanced-usage/seeding

3. jstable - a lightweight, dependency-free JavaScript plugin which makes a HTML table interactive https://jstable.github.io/

4. Notyf is a minimalistic JavaScript library for toast notifications.  - https://github.com/caroso1222/notyf

4. Laravel Swagger for API doc

## Author

Aleksandar Jolakoski (https://github.com/jolace)