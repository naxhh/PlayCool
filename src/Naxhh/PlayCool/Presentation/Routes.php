<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Validates correct content-type header and converts JSON string to valid PHP array.
 */
$app->before(function(Request $request) {
    if ($request->headers->get('Content-Type') !== 'application/json') {
        return new JsonResponse(array('error' => 'Only application/json is accepted'), 415);
    }

    $json = json_decode($request->getContent(), true);
    $request->request->replace(is_array($json) ? $json : array());

});


$app->post('/api/v1/playlists', 'Naxhh\PlayCool\Presentation\Controller\CreatePlaylist::execute');
