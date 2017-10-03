<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

defined('SYMFONY_ENV') || define('SYMFONY_ENV', getenv('SYMFONY_ENV') ?: 'prod');
defined('SYMFONY_DEBUG') ||
define('SYMFONY_DEBUG', filter_var(getenv('SYMFONY_DEBUG') ?: SYMFONY_ENV === 'dev', FILTER_VALIDATE_BOOLEAN));

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';

if (SYMFONY_DEBUG) {
    Debug::enable();
}

$kernel = new AppKernel(SYMFONY_ENV, SYMFONY_DEBUG);
$kernel->loadClassCache();

$request = Request::createFromGlobals();

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
