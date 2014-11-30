<?php

define('DS', DIRECTORY_SEPARATOR);

require_once __DIR__ . DS . '..' . DS . 'vendor' . DS . 'autoload.php';


$app = new Silex\Application();

// Config.
$app['debug'] = false;
$app['files_path'] = __DIR__ . DS . '..' . DS . 'var' . DS;
$app['redis.host'] = 'tcp://127.0.0.1:6379';

// Services.
require __DIR__ . DS . '..' . DS . 'src' . DS . 'Naxhh' . DS . 'PlayCool' . DS . 'Presentation' . DS . 'Services.php';

// Routes.
require __DIR__ . DS . '..' . DS . 'src' . DS . 'Naxhh' . DS . 'PlayCool' . DS . 'Presentation' . DS . 'Routes.php';

$app->run();
