<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\PlaylistRepository;
use Naxhh\PlayCool\Application\Command\UpdatePlaylistNameCommand;
use Naxhh\PlayCool\Application\UseCase\UpdatePlaylistNameUseCase;
use Naxhh\PlayCool\Presentation\Transformer\PlaylistTransformer;
use League\Fractal;

class UpdatePlaylist
{
    public function execute(Request $request, Application $app, $id) {

        $name     = $request->request->get('name');
        $playlist = $this->buildUseCase()->handle(new UpdatePlaylistNameCommand($id, $name));
        $resource = new Fractal\Resource\Item($playlist, new PlaylistTransformer);

        return new JsonResponse(
            $app['fractal']->createData($resource)->toArray(),
            200
        );
    }

    private function buildUseCase() {
        $playlist_repository = new PlaylistRepository;
        return new UpdatePlaylistNameUseCase($playlist_repository);
    }
}
