<?php

namespace Naxhh\PlayCool\Application\UseCase;

use Naxhh\PlayCool\Application\Contract\UseCase;
use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\PlayCool\Domain\Contract\ArtistRepository;
use Naxhh\PlayCool\Domain\ValueObject\ArtistIdentity;

/**
 * Retrieves artist albums.
 */
class GetArtistAlbumsUseCase implements UseCase
{
    private $artist_repository;

    public function __construct(ArtistRepository $artist_repository) {
        $this->artist_repository = $artist_repository;
    }

    public function handle(Command $command) {
        $request = $command->getRequest();

        return $this->artist_repository->get(
            new ArtistIdentity($request->get('id'))
        );
    }
}
