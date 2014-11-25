<?php

namespace Naxhh\Playcool\Domain\Entity;

class PlaylistTest extends \PHPUnit_Framework_TestCase
{
    public function testNewPlaylistHasNoTracks() {
        $playlist = Playlist::create('My playlist');

        $this->assertCount(
            0,
            $playlist->getTracks()
        );
    }

    public function testAddTrackToPlaylist() {
        $playlist = Playlist::create('My playlist');
        $playlist->addTrack('My track');

        $this->assertCount(
            1,
            $playlist->getTracks()
        );
    }

    public function testThatTheSameSongCantBeAddedToThePlaylist() {
        $this->setExpectedException('Naxhh\Playcool\Domain\Exception\TrackAlreadyAddedException');

        $playlist = Playlist::create('My playlist');
        $playlist->addTrack('My track');
        $playlist->addTrack('My track');
    }

    public function testRemoveATrackFromThePlaylist() {
        $playlist = Playlist::create('My playlist');
        $playlist->addTrack('My track');

        $playlist->removeTrack('My track');

        $this->assertCount(
            0,
            $playlist->getTracks()
        );
    }
}