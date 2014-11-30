<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Infrastructure\Repository\Spotify\ArtistRepository;
use Naxhh\PlayCool\Application\Command\GetArtistAlbumsCommand;
use Naxhh\PlayCool\Application\UseCase\GetArtistAlbumsUseCase;
use Naxhh\PlayCool\Presentation\Transformer\ArtistTransformer;
use Naxhh\PlayCool\Domain\Exception\ArtistNotFoundException;
use League\Fractal;

class GetArtist
{
    private $app;

    public function execute(Application $app, $id) {
        try {
            $this->app = $app;

            $artist = $this->buildUseCase()->handle(new GetArtistAlbumsCommand($id));
            $resource = new Fractal\Resource\Item($artist, new ArtistTransformer);

            return new JsonResponse(
                $app['fractal']->createData($resource)->toArray(),
                200
            );
        } catch (ArtistNotFoundException $e) {
          $app->abort(404);
        }
    }

    private function buildUseCase() {
        return new GetArtistAlbumsUseCase($this->app['repo.artist']);
    }
}
