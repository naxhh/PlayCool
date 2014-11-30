<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Application\Command\GetPlaylistCommand;
use Naxhh\PlayCool\Application\UseCase\GetPlaylistUseCase;
use Naxhh\PlayCool\Presentation\Transformer\PlaylistTransformer;
use Naxhh\PlayCool\Domain\Exception\PlaylistNotFoundException;
use League\Fractal;

class GetPlaylist
{
    private $app;

    public function execute(Application $app, $id) {
        try {
            $this->app = $app;

            $playlist = $this->buildUseCase()->handle(new GetPlaylistCommand($id));
            $resource = new Fractal\Resource\Item($playlist, new PlaylistTransformer);

            return new JsonResponse(
                $app['fractal']->createData($resource)->toArray(),
                200
            );
        } catch (PlaylistNotFoundException $e) {
            $app->abort(404);
        }
    }

    private function buildUseCase() {
        return new GetPlaylistUseCase($this->app['repo.playlist']);
    }
}
