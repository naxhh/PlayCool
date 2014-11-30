<?php

namespace Naxhh\Playcool\Application\UseCase;

use Naxhh\Playcool\Application\Command\UpdatePlaylistCommand;
use Naxhh\PlayCool\Infrastructure\Repository\Spotify\TrackRepository;
use Test\Helper\PlaylistBuilder;

class UpdatePlaylistUseCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testPlaylistResponseIsReturned() {
        $old_playlist = PlaylistBuilder::get()->withId('id')->build();

        $playlist_repository = $this->getMock('Naxhh\PlayCool\Domain\Contract\PlaylistRepository');
        $playlist_repository->expects($this->any())
            ->method('get')
            ->will($this->returnValue($old_playlist));

        $command = new UpdatePlaylistCommand('id', 'My new playlist name');
        $use_case = new UpdatePlaylistUseCase($playlist_repository, new TrackRepository(new \stdClass));

        $playlist = $use_case->handle($command);

        $this->assertEquals(
            'My new playlist name',
            $playlist->getName()
        );
    }

    public function testPlaylistIsSavedInRepository() {
        $old_playlist = PlaylistBuilder::get()->withId('id')->build();

        $playlist_repository = $this->getMock('Naxhh\PlayCool\Domain\Contract\PlaylistRepository');
        $playlist_repository->expects($this->any())
            ->method('get')
            ->will($this->returnValue($old_playlist));
        $playlist_repository->expects($this->once())
            ->method('add');

        $command  = new UpdatePlaylistCommand('id', 'My new playlist name');
        $use_case = new UpdatePlaylistUseCase($playlist_repository, new TrackRepository(new \stdClass));

        $playlist = $use_case->handle($command);
    }
}
