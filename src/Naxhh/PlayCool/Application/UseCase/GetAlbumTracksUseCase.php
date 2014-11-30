<?php

namespace Naxhh\PlayCool\Application\UseCase;

use Naxhh\PlayCool\Application\Contract\UseCase;
use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\PlayCool\Domain\Contract\AlbumRepository;
use Naxhh\PlayCool\Domain\ValueObject\AlbumIdentity;

class GetAlbumTracksUseCase implements UseCase
{
    private $playlist_repository;

    public function __construct(AlbumRepository $album_repository) {
        $this->album_repository = $album_repository;
    }

    public function handle(Command $command) {
        $request = $command->getRequest();

        return $this->album_repository->get(
            new AlbumIdentity($request->get('id'))
        );
    }
}
