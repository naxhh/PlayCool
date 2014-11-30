<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Application\Command\GetAllPlaylistsCommand;
use Naxhh\PlayCool\Application\UseCase\GetAllPlaylistsUseCase;
use Naxhh\PlayCool\Presentation\Transformer\PlaylistTransformer;
use League\Fractal;

class GetAllPlaylists
{
    private $app;

    public function execute(Application $app) {
        $this->app = $app;

        $playlists = $this->buildUseCase()->handle(new GetAllPlaylistsCommand($id));
        $resource = new Fractal\Resource\Collection($playlists, new PlaylistTransformer);

        return new JsonResponse(
            $app['fractal']->createData($resource)->toArray(),
            200
        );
    }

    private function buildUseCase() {
        return new GetAllPlaylistsUseCase($this->app['repo.playlist']);
    }
}
