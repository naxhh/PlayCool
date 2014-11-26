<?php

namespace Naxhh\PlayCool\Application\UseCase;

use Naxhh\PlayCool\Application\Contract\UseCase;
use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\PlayCool\Domain\Entity\Playlist;

class CreatePlaylistUseCase implements UseCase
{
	public function __construct() {
	}

	public function handle(Command $command) {
		$request = $command->getRequest();

		$playlist = Playlist::create($request->get('name'));

		return $playlist;
	}
}
