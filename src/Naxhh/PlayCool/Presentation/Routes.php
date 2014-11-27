<?php

use Symfony\Component\HttpFoundation\Response;

$app->get('/', function() use ($app) {
    return new Response('Hi');
});
