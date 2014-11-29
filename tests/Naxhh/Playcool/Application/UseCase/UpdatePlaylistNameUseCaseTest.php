<?php

namespace Naxhh\Playcool\Application\UseCase;

use Naxhh\Playcool\Application\Command\UpdatePlaylistNameCommand;
use Naxhh\Playcool\Domain\Entity\Playlist;

class UpdatePlaylistNameUseCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testPlaylistResponseIsReturned()
    {
        $old_playlist = Playlist::create('id', 'My playlist');

        $playlist_repository = $this->getMock('Naxhh\PlayCool\Domain\Contract\PlaylistRepository');
        $playlist_repository->expects($this->any())
            ->method('get')
            ->will($this->returnValue($old_playlist));

        $command = new UpdatePlaylistNameCommand('id', 'My new playlist name');
        $use_case = new UpdatePlaylistNameUseCase($playlist_repository);

        $playlist = $use_case->handle($command);

        $this->assertEquals(
            'My new playlist name',
            $playlist->getName()
        );
    }

    public function testPlaylistIsSavedInRepository()
    {
        $old_playlist = Playlist::create('id', 'My playlist');

        $playlist_repository = $this->getMock('Naxhh\PlayCool\Domain\Contract\PlaylistRepository');
        $playlist_repository->expects($this->any())
            ->method('get')
            ->will($this->returnValue($old_playlist));
        $playlist_repository->expects($this->once())
            ->method('add');

        $command  = new UpdatePlaylistNameCommand('id', 'My new playlist name');
        $use_case = new UpdatePlaylistNameUseCase($playlist_repository);

        $playlist = $use_case->handle($command);
    }
}
