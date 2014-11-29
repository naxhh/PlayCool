<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\PlaylistRepository;
use Naxhh\PlayCool\Application\Command\GetPlaylistCommand;
use Naxhh\PlayCool\Application\UseCase\GetPlaylistUseCase;
use Naxhh\PlayCool\Presentation\Transformer\PlaylistTransformer;
use League\Fractal;

class GetPlaylist
{
    public function execute(Application $app, $id) {

        $playlist = $this->buildUseCase()->handle(new GetPlaylistCommand($id));
        $resource = new Fractal\Resource\Item($playlist, new PlaylistTransformer);

        return new JsonResponse(
            $app['fractal']->createData($resource)->toArray(),
            200
        );
    }

    private function buildUseCase() {
        $playlist_repository = new PlaylistRepository;
        return new GetPlaylistUseCase($playlist_repository);
    }
}
