<?php

namespace Naxhh\PlayCool\Application\UseCase;

use Naxhh\PlayCool\Application\Contract\UseCase;
use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\PlayCool\Domain\Contract\TrackRepository;

class SearchTrackUseCase implements UseCase
{
    private $track_repository;

    public function __construct(TrackRepository $track_repository) {
        $this->track_repository = $track_repository;
    }

    public function handle(Command $command) {
        $request = $command->getRequest();

        return $this->track_repository->getListByName($request->get('search_term'));
    }
}
