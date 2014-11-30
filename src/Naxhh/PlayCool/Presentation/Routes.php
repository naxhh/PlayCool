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

$app->get('/api/v1/playlists', 'Naxhh\PlayCool\Presentation\Controller\GetAllPlaylists::execute');
$app->post('/api/v1/playlists', 'Naxhh\PlayCool\Presentation\Controller\CreatePlaylist::execute');

$app->get('/api/v1/playlists/{id}', 'Naxhh\PlayCool\Presentation\Controller\GetPlaylist::execute');
$app->put('/api/v1/playlists/{id}', 'Naxhh\PlayCool\Presentation\Controller\UpdatePlaylist::execute');
$app->delete('/api/v1/playlists/{id}', 'Naxhh\PlayCool\Presentation\Controller\RemovePlaylist::execute');

$app->get('/api/v1/albums/{id}', 'Naxhh\PlayCool\Presentation\Controller\GetAlbum::execute');

$app->get('/api/v1/search', 'Naxhh\PlayCool\Presentation\Controller\Search::execute');

$app->error(function(\Exception $e, $code) {

    switch ($code) {
        case 400:
            $message = $e->getMessage() ?: 'Please check your entities to ensure that you are providing valid data';
            break;
        case 404:
            $message = 'Resource not found';
            break;
        case 405:
            $message = 'This resource does not allow this method';
            break;
        case 415:
            $message = 'Only application/json content-type is accepted';
            break;
        case 500:
            $message = 'There is some problem in the server. Please report this!';
        default:
            $message = 'You have found a super weird error, have you considered to become a QA?';
            break;
    }

    return new JsonResponse(array('error' => $message));
});
