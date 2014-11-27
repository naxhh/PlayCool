<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\PlaylistRepository;
use Naxhh\PlayCool\Application\Command\CreatePlaylistCommand;
use Naxhh\PlayCool\Application\UseCase\CreatePlaylistUseCase;
use Naxhh\PlayCool\Presentation\Transformer\PlaylistTransformer;
use League\Fractal;

class CreatePlaylist
{
    public function execute(Request $request) {

        $name = $request->request->get('name');

        $playlist_repository = new PlaylistRepository;
        $command = new CreatePlaylistCommand($name);
        $use_case = new CreatePlaylistUseCase($playlist_repository);

        $playlist = $use_case->handle($command);

        $fractal = new Fractal\Manager;
        $resource = new Fractal\Resource\Item($playlist, new PlaylistTransformer);

        return new JsonResponse(
            $fractal->createData($resource)->toArray(),
            201
        );
    }
}
