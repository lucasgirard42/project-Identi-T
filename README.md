# IDENDITY-T
![diagram](Diagramme%20entity-T.svg)


## liens vers la doc de symfony
    https://symfony.com/doc/current/controller/upload_file.html#creating-an-uploader-service

## Install Symfony
```shell
composer create-project symfony/website-skeleton my_project_name
composer require symfony/apache-pack
```
## wizard creation entity
```shell
php bin/console make:entity
```
## afficher les routes definies
```shell
php bin/console debug:route
```
## pour construit un crud
```shell
    php bin/console make:crud
```
## create a new security voter class
```shell
php bin/console make:voter
```
## faire une migration
```shell
     php bin/console make:migration
     php bin/console doctrine:migrations:migrate
```
## liens vers la doc de symfony
    https://symfony.com/doc/current/controller/upload_file.html#creating-an-uploader-service
