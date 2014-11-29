<?php

namespace Naxhh\PlayCool\Application\UseCase;

use Naxhh\PlayCool\Application\Contract\UseCase;
use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\PlayCool\Domain\Contract\AlbumRepository;

/**
 * Searchs for albums given a search term.
 */
class SearchAlbumUseCase implements UseCase
{
    private $repository;

    public function __construct(AlbumRepository $repository) {
        $this->repository = $repository;
    }

    public function handle(Command $command) {
        $request = $command->getRequest();

        return $this->repository->getListByName($request->get('search_term'));
    }
}
