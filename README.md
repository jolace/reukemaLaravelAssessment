# Reukema Laravel assessment 20230103

Application is set to work in few docker enviorments.
1.  Docker **app-reukema** contain application code and execute all client requests
2.  Docker **app-reukema-queue** care about executing laravel asynchronous jobs and cronjob commands
3.  Docker **mysql-reukema** is mysql 8 server for mySql database.
4.  Docker **adminer-reukema** is with installed Adminer UI for manage mySql database

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

## Packages used

laravel/breeze for Auth routes and views 