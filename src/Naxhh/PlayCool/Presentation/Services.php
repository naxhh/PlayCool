<?php

$app->register(new Naxhh\PlayCool\Presentation\Service\FractalService);
$app->register(new Predis\Silex\ClientServiceProvider(), array(
    'predis.parameters' => $app['redis.host'],
    'predis.options' => array(
        'prefix'  => 'playcool:',
        'profile' => '3.0'
    )
));
$app->register(new Naxhh\PlayCool\Presentation\Service\SpotifyApiService);
$app->register(new Naxhh\PlayCool\Presentation\Service\RepositoryService);