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
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
$ php bin/console doctrine:fixtures:load
$ php bin/console cache:clear
$ npm install
$ npm run dev
```

HAVE FUN!!!

Tests
-------

This Symfony4 skeleton project comes with a ready to use testing tools like phpstan and behat.

#### Phpstan

```bash
$ vendor/bin/phpstan.phar analyse -c phpstan.neon -l max src/
```

#### Behat

Rename behat.yml.dist to behat.yml and change the content according to your project.
Next add your Scenarios on features folder and run:

```bash
$ vendor/bin/behat
```

Docker
-------

Having docker and docker compose installed you can run the project with the following
command:

```bash
$ docker-compose up
```

Authors
-------

This project is maintained by <a href="https://odiseo.com.ar">Odiseo</a>. Want us to help you with this or any Symfony project? Contact us on <a href="mailto:team@odiseo.com.ar">team@odiseo.com.ar</a>.
