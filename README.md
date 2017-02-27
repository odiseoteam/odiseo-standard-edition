Odiseo Standard Edition
========================

Welcome to the Symfony Standard Edition - a fully-functional Symfony
application that you can use as the skeleton for your new applications.

Installation
------------

```bash
sudo php composer.phar create-project odiseoteam/odiseo-standard-edition [path_to_project]
cd [path_to_project]
sudo php composer.phar update
sudo php bin/console doctrine:database:create
sudo php bin/console doctrine:schema:update --force
sudo php bin/console doctrine:fixtures:load
sudo rm -rf var/cache var/logs && sudo mkdir var/cache var/logs && sudo chmod -R 777 var/cache var/logs
sudo npm install
sudo gulp
sudo php bin/console server:start
```
Open: http://localhost:8000/

TODO List
---------------
