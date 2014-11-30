<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Infrastructure\Repository\Spotify\AlbumRepository;
use Naxhh\PlayCool\Application\Command\GetAlbumTracksCommand;
use Naxhh\PlayCool\Application\UseCase\GetAlbumTracksUseCase;
use Naxhh\PlayCool\Presentation\Transformer\AlbumTransformer;
use Naxhh\PlayCool\Domain\Exception\AlbumNotFoundException;
use League\Fractal;

class GetAlbum
{
    private $app;

    public function execute(Application $app, $id) {
        try {
            $this->app = $app;

            $album = $this->buildUseCase()->handle(new GetAlbumTracksCommand($id));
            $resource = new Fractal\Resource\Item($album, new AlbumTransformer);

            return new JsonResponse(
                $app['fractal']->createData($resource)->toArray(),
                200
            );
        } catch (AlbumNotFoundException $e) {
          $app->abort(404);
        }
    }

    private function buildUseCase() {
        return new GetAlbumTracksUseCase(
            new AlbumRepository($this->app['spotify.api'])
        );
    }
}
