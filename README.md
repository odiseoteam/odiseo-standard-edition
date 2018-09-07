Odiseo Standard Edition
========================

Welcome to the Symfony Standard Edition - a fully-functional Symfony4
application that you can use as the skeleton for your new applications.

Installation
------------

Create your project running the following command:

```bash
$ composer create-project odiseoteam/odiseo-standard-edition [path_to_project]
```

Edit the .env file and run the commands:

```bash
$ cd [path_to_project]
$ yarn install
$ yarn run gulp
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
$ php bin/console doctrine:fixtures:load
$ php bin/console cache:clear
```

GET FUN!!!

Authors
-------

Project by [Odiseo Team](https://odiseo.com.ar).
