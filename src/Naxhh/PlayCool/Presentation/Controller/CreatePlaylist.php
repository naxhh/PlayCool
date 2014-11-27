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

        $name = $request->request->get('name');

        $playlist_repository = new PlaylistRepository;
        $command = new CreatePlaylistCommand($name);
        $use_case = new CreatePlaylistUseCase($playlist_repository);

        $playlist = $use_case->handle($command);

        $resource = new Fractal\Resource\Item($playlist, new PlaylistTransformer);

        return new JsonResponse(
            $app['fractal']->createData($resource)->toArray(),
            201
        );
    }
}
