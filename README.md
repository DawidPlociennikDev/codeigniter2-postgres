## Codeigniter 2 with PostgreSQL (PHP 7.4)

Clone project

```bash
  https://github.com/DawidPlociennikDev/codeigniter2-postgres.git
```

Build docker

```bash
  docker-compose build
```

Run docker containers

```bash
  docker-compose up
```

Install composer dependencies

```bash
  docker-compose exec web composer install
```

Run migrations
[http://localhost:8080/migrate](http://localhost:8080/migrate)

Seed database
[http://localhost:8080/migrate/seed](http://localhost:8080/migrate/seed)

Project
[http://localhost:8080](http://localhost:8080)

Admin
[http://localhost:8080/logowanie](http://localhost:8080/logowanie)

Adminer
[http://localhost:8081](http://localhost:8081/?)

SOLR
[http://localhost:8983/solr](http://localhost:8983/solr)



Run PHPStan

```bash
  vendor/bin/phpstan analyse -c phpstan.neon
```

Run PHPCS

```bash
  phpcs application
```

Init GrumPHP before commit

```bash
  ./vendor/bin/grumphp git:init
```

## REST API

GET ALL COMMENTS
[http://localhost:8080/migrate](http://localhost:8080/api/get)

GET ONE COMMENT BY ID
[http://localhost:8080/migrate](http://localhost:8080/api/get/{$id})

PUT COMMENT
[http://localhost:8080/migrate](http://localhost:8080/api/put/{$id})

PATCH COMMENT
[http://localhost:8080/migrate](http://localhost:8080/api/patch/{$id})

POST COMMENT
[http://localhost:8080/migrate](http://localhost:8080/api/post)

DELETE COMMENT
[http://localhost:8080/api/delete/{$id}](http://localhost:8080/api/delete/{$id})

## Apache SOLR

Install on Ubuntu 22.04
[https://solr.apache.org/guide/solr/latest/deployment-guide/installing-solr.html](https://solr.apache.org/guide/solr/latest/deployment-guide/installing-solr.html)

Create Index

```bash
  bin/solr create_core -c films
```

Delete Index

```bash
  bin/solr delete -c films
```
