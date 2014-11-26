<?php

namespace Naxhh\Playcool\Application\UseCase;

use Naxhh\Playcool\Application\Command\CreatePlaylistCommand;

class CreatePlaylistUseCaseTest extends \PHPUnit_Framework_TestCase
{
	public function testPlaylistResponseIsReturned()
	{
		$command = new CreatePlaylistCommand('My playlist');
		$use_case = new CreatePlaylistUseCase;

		$playlist = $use_case->handle($command);

		$this->assertEquals(
			'My playlist',
			$playlist->getName()
		);
	}
}
