<?php

namespace Naxhh\PlayCool\Application\UseCase;

use Naxhh\PlayCool\Application\Contract\UseCase;
use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\PlayCool\Domain\Contract\ArtistRepository;

/**
 * Searchs for artists given a search term.
 */
class SearchArtistUseCase implements UseCase
{
    private $repository;

    public function __construct(ArtistRepository $repository) {
        $this->repository = $repository;
    }

    public function handle(Command $command) {
        $request = $command->getRequest();

        return $this->repository->getListByName($request->get('search_term'));
    }
}
