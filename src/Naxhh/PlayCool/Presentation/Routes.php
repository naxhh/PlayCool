<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Validates correct content-type header and converts JSON string to valid PHP array.
 */
$app->before(function(Request $request) use($app) {
    if ($request->headers->get('Content-Type') !== 'application/json') {
        $app->abort(415);
    }

    $json = json_decode($request->getContent(), true);
    $request->request->replace(is_array($json) ? $json : array());

});

$app->post('/api/v1/playlists', 'Naxhh\PlayCool\Presentation\Controller\CreatePlaylist::execute');

$app->put('/api/v1/playlists/{id}', 'Naxhh\PlayCool\Presentation\Controller\UpdatePlaylist::execute');
$app->delete('/api/v1/playlists/{id}', 'Naxhh\PlayCool\Presentation\Controller\RemovePlaylist::execute');

$app->error(function(\Exception $e, $code) {
    switch ($code) {
        case 404:
            $message = 'Resource not found';
            break;
        case 405:
            $message = 'This resource does not allow this method';
            break;
        case 415:
            $message = 'Only application/json content-type is accepted';
            break;
        default:
            $message = 'You have found a super weird error, have you considered to become a QA?';
            break;
    }

    return new JsonResponse(array('error' => $message));
});
