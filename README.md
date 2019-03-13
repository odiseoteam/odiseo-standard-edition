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

Tests
-------

This Symfony4 project comes with a ready to use testing tools like phpstan and behat.

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

Authors
-------

This project is maintained by <a href="https://odiseo.com.ar">Odiseo</a>. Do you want us to help you with this or any Symfony project? Contact us on <a href="mailto:team@odiseo.com.ar">team@odiseo.com.ar</a>.
