<?php

namespace Naxhh\Playcool\Application\UseCase;

use Naxhh\Playcool\Application\Command\RemovePlaylistCommand;
use Test\Helper\PlaylistBuilder;

class RemovePlaylistUseCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testPlaylistIsRemovedFromRepository() {
        $playlist = PlaylistBuilder::get()->withName('Playlist id')->build();

        $playlist_repository = $this->getMock('Naxhh\PlayCool\Domain\Contract\PlaylistRepository');
        $playlist_repository->expects($this->any())
            ->method('get')
            ->will($this->returnValue($playlist));
        $playlist_repository->expects($this->once())
            ->method('remove');

        $command  = new RemovePlaylistCommand('Playlist id');
        $use_case = new RemovePlaylistUseCase($playlist_repository);

        $use_case->handle($command);
    }
}
