<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\PlaylistRepository;
use Naxhh\PlayCool\Application\Command\CreatePlaylistCommand;
use Naxhh\PlayCool\Application\UseCase\CreatePlaylistUseCase;

class CreatePlaylist
{
    public function execute(Request $request) {

        $name = $request->request->get('name');

        $playlist_repository = new PlaylistRepository;
        $command = new CreatePlaylistCommand($name);
        $use_case = new CreatePlaylistUseCase($playlist_repository);

        $playlist = $use_case->handle($command);

        return new JsonResponse(
            array(
                'name' => $playlist->getName(),
                'tracks' => $playlist->getTracks()
            ),
            201
        );
    }
}
