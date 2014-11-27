<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\PlaylistRepository;
use Naxhh\PlayCool\Application\Command\CreatePlaylistCommand;
use Naxhh\PlayCool\Application\UseCase\CreatePlaylistUseCase;
use Naxhh\PlayCool\Presentation\Transformer\PlaylistTransformer;
use League\Fractal;

class CreatePlaylist
{
    public function execute(Request $request, Application $app) {

        $name     = $request->request->get('name');
        $playlist = $this->buildUseCase()->handle(new CreatePlaylistCommand($name));

        $resource = new Fractal\Resource\Item($playlist, new PlaylistTransformer);

        return new JsonResponse(
            $app['fractal']->createData($resource)->toArray(),
            201
        );
    }

    private function buildUseCase() {
        $playlist_repository = new PlaylistRepository;
        return new CreatePlaylistUseCase($playlist_repository);
    }
}
