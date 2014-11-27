<?php

define('DS', DIRECTORY_SEPARATOR);

require_once __DIR__ . DS . '..' . DS . 'vendor' . DS . 'autoload.php';


$app = new Silex\Application();

$app['debug'] = true;

require __DIR__ . DS . '..' . DS . 'src' . DS . 'Naxhh' . DS . 'PlayCool' . DS . 'Presentation' . DS . 'Routes.php';

$app->run();
