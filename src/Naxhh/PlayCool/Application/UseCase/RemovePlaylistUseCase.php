<?php

namespace Naxhh\PlayCool\Application\UseCase;

use Naxhh\PlayCool\Application\Contract\UseCase;
use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\PlayCool\Domain\Contract\PlaylistRepository;
use Naxhh\PlayCool\Domain\ValueObject\PlaylistIdentity;

/**
 * Removes a playlist.
 */
class RemovePlaylistUseCase implements UseCase
{
    private $playlist_repository;

    public function __construct(PlaylistRepository $playlist_repository) {
        $this->playlist_repository = $playlist_repository;
    }

    public function handle(Command $command) {
        $request = $command->getRequest();

        $playlist = $this->playlist_repository->get(
            new PlaylistIdentity($request->get('id'))
        );

        $this->playlist_repository->remove($playlist);
    }
}
