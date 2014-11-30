<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Application\Command\UpdatePlaylistNameCommand;
use Naxhh\PlayCool\Application\UseCase\UpdatePlaylistNameUseCase;
use Naxhh\PlayCool\Presentation\Transformer\PlaylistTransformer;
use Naxhh\PlayCool\Application\Exception\InvalidPlaylistNameException;
use League\Fractal;

class UpdatePlaylist
{
    private $app;

    public function execute(Request $request, Application $app, $id) {
        try {
            $this->app = $app;

            $name     = $request->request->get('name');
            $playlist = $this->buildUseCase()->handle(new UpdatePlaylistNameCommand($id, $name));
            $resource = new Fractal\Resource\Item($playlist, new PlaylistTransformer);

            return new JsonResponse(
                $this->app['fractal']->createData($resource)->toArray(),
                200
            );
        } catch (InvalidPlaylistNameException $e) {
            $this->app->abort(400, 'You should provide a valid name for the playlist');
        }
    }

    private function buildUseCase() {
        return new UpdatePlaylistNameUseCase($this->app['repo.playlist']);
    }
}
