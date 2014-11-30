<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Application\Command\CreatePlaylistCommand;
use Naxhh\PlayCool\Application\UseCase\CreatePlaylistUseCase;
use Naxhh\PlayCool\Presentation\Transformer\PlaylistTransformer;
use Naxhh\PlayCool\Application\Exception\InvalidPlaylistNameException;
use League\Fractal;

class CreatePlaylist
{
    private $app;

    public function execute(Request $request, Application $app) {
        try {
            $this->app = $app;

            $name     = $request->request->get('name');
            $playlist = $this->buildUseCase()->handle(new CreatePlaylistCommand($name));

            $resource = new Fractal\Resource\Item($playlist, new PlaylistTransformer);

            return new JsonResponse(
                $app['fractal']->createData($resource)->toArray(),
                201
            );
        } catch (InvalidPlaylistNameException $e) {
            $this->app->abort(400, 'You should provide a valid playlist name');
        }
    }

    private function buildUseCase() {
        return new CreatePlaylistUseCase($this->app['repo.playlist']);
    }
}
