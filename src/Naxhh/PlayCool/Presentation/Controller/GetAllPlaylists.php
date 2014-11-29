<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\PlaylistRepository;
use Naxhh\PlayCool\Application\Command\GetAllPlaylistsCommand;
use Naxhh\PlayCool\Application\UseCase\GetAllPlaylistsUseCase;
use Naxhh\PlayCool\Presentation\Transformer\PlaylistTransformer;
use League\Fractal;

class GetAllPlaylists
{
    public function execute(Application $app) {

        $playlists = $this->buildUseCase()->handle(new GetAllPlaylistsCommand($id));
        $resource = new Fractal\Resource\Collection($playlists, new PlaylistTransformer);

        return new JsonResponse(
            $app['fractal']->createData($resource)->toArray(),
            200
        );
    }

    private function buildUseCase() {
        $playlist_repository = new PlaylistRepository;
        return new GetAllPlaylistsUseCase($playlist_repository);
    }
}
