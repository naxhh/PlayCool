<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\PlaylistRepository;
use Naxhh\PlayCool\Application\Command\RemovePlaylistCommand;
use Naxhh\PlayCool\Application\UseCase\RemovePlaylistUseCase;

class RemovePlaylist
{
    public function execute(Request $request, Application $app, $id) {

        $use_case = new RemovePlaylistUseCase($app['repo.playlist']);
        $use_case->handle(new RemovePlaylistCommand($id));

        return new JsonResponse(array(), 204);
    }
}
