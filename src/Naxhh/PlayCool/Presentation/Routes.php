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


$app->post('/api/v1/playlists', function(Request $request) {
    $name = $request->request->get('name');


    $playlist_repository = new Naxhh\PlayCool\Infrastructure\Repository\Dummy\PlaylistRepository;
    $command = new Naxhh\PlayCool\Application\Command\CreatePlaylistCommand($name);
    $use_case = new Naxhh\PlayCool\Application\UseCase\CreatePlaylistUseCase($playlist_repository);

    $playlist = $use_case->handle($command);

    return new JsonResponse(
        array(
            'name' => $playlist->getName(),
            'tracks' => $playlist->getTracks()
        ),
        201
    );
});
