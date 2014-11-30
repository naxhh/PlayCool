<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Application\Command\RemovePlaylistCommand;
use Naxhh\PlayCool\Application\UseCase\RemovePlaylistUseCase;
use Naxhh\PlayCool\Domain\Exception\PlaylistNotFoundException;

class RemovePlaylist
{
    public function execute(Request $request, Application $app, $id) {
        try {
            $use_case = new RemovePlaylistUseCase($app['repo.playlist']);
            $use_case->handle(new RemovePlaylistCommand($id));
        } catch (PlaylistNotFoundException $e) {
            // We don't want to report errors when trying to delete non-existing playlists.
        } finally {
            return new JsonResponse(array(), 204);
        }
    }
}
