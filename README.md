Odiseo Standard Edition
========================

Welcome to the Symfony Standard Edition - a fully-functional Symfony
application that you can use as the skeleton for your new applications.

Installation
------------

```bash
sudo php composer.phar create-project odiseoteam/odiseo-standard-edition [path_to_project]
cd [path_to_project]
sudo npm install
sudo npm run gulp
sudo php bin/console server:start
open http://localhost:8000/
```

TODO List
---------------

- Remove OdiseoProjectBundle and move dependencies to this project.
- Create a util Bundle to place some utilities for all projects.
- Rename OdiseoBackendBundle to OdiseoAdminBundle.
- Change the name of OdiseoAppBundle to some like ClientAppBundle and ClientAdminBundle.