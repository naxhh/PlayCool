<?php

namespace Naxhh\Playcool\Application\UseCase;

use Naxhh\Playcool\Application\Command\GetAllPlaylistsCommand;
use Test\Helper\PlaylistBuilder;

class GetAllPlaylistsUseCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testPlaylistIsRemovedFromRepository() {
        $playlists = array(
            PlaylistBuilder::get()->build(),
            PlaylistBuilder::get()->build()
        );

        $playlist_repository = $this->getMock('Naxhh\PlayCool\Domain\Contract\PlaylistRepository');
        $playlist_repository->expects($this->any())
            ->method('getAll')
            ->will($this->returnValue($playlists));

        $command  = new GetAllPlaylistsCommand();
        $use_case = new GetAllPlaylistsUseCase($playlist_repository);

        $this->assertCount(
            2,
            $use_case->handle($command)
        );
    }
}
