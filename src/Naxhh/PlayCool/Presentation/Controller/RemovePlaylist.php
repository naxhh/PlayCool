<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\PlaylistRepository;
use Naxhh\PlayCool\Application\Command\RemovePlaylistCommand;
use Naxhh\PlayCool\Application\UseCase\RemovePlaylistUseCase;
use Naxhh\PlayCool\Presentation\Transformer\PlaylistTransformer;
use League\Fractal;

class RemovePlaylist
{
    public function execute(Request $request, Application $app, $id) {
        $this->buildUseCase()->handle(new RemovePlaylistCommand($id));

        return new JsonResponse(array(), 204);
    }

    private function buildUseCase() {
        $playlist_repository = new PlaylistRepository;
        return new RemovePlaylistUseCase($playlist_repository);
    }
}
