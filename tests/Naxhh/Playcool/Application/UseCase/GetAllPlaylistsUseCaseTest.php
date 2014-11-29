<?php

namespace Naxhh\Playcool\Application\UseCase;

use Naxhh\Playcool\Application\Command\GetAllPlaylistsCommand;
use Test\Helper\PlaylistBuilder;

class GetAllPlaylistsUseCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testPlaylistIsRemovedFromRepository() {
        $playlist = PlaylistBuilder::get()
            ->withId('Playlist id')
            ->withName('Playlist name')
            ->build()
        ;

        $playlist_repository = $this->getMock('Naxhh\PlayCool\Domain\Contract\PlaylistRepository');
        $playlist_repository->expects($this->any())
            ->method('get')
            ->will($this->returnValue($playlist));

        $command  = new GetAllPlaylistsCommand('Playlist id');
        $use_case = new GetAllPlaylistsUseCase($playlist_repository);

        $playlist = $use_case->handle($command);

        $this->assertSame(
            'Playlist name',
            $playlist->getName()
        );
    }
}
