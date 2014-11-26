<?php

namespace Naxhh\Playcool\Application\UseCase;

use Naxhh\Playcool\Application\Command\CreatePlaylistCommand;

class CreatePlaylistUseCaseTest extends \PHPUnit_Framework_TestCase
{
	public function testPlaylistResponseIsReturned()
	{
		$playlist_repository = $this->getMock('Naxhh\PlayCool\Domain\Contract\PlaylistRepository');

		$command = new CreatePlaylistCommand('My playlist');
		$use_case = new CreatePlaylistUseCase($playlist_repository);

		$playlist = $use_case->handle($command);

		$this->assertEquals(
			'My playlist',
			$playlist->getName()
		);
	}

	public function testPlaylistIsSavedInRepository()
	{
		$playlist_repository = $this->getMock('Naxhh\PlayCool\Domain\Contract\PlaylistRepository');
		$playlist_repository->expects($this->once())
			->method('add');

		$command = new CreatePlaylistCommand('My playlist');
		$use_case = new CreatePlaylistUseCase($playlist_repository);

		$playlist = $use_case->handle($command);
	}
}
