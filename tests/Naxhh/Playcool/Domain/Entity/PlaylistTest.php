<?php

namespace Naxhh\PlayCool\Domain\Entity;

use Test\Helper\PlaylistBuilder;

class PlaylistTest extends \PHPUnit_Framework_TestCase
{
    public function testNewPlaylistHasNoTracks() {
        $playlist = PlaylistBuilder::get()->withName('My playlist')->build();

        $this->assertCount(
            0,
            $playlist->getTracks()
        );
    }

    public function testAddTrackToPlaylist() {
        $playlist = PlaylistBuilder::get()->withName('My playlist')->build();
        $playlist->addTrack(Track::create('id', 'My track'));

        $this->assertCount(
            1,
            $playlist->getTracks()
        );
    }

    public function testRemoveATrackFromThePlaylist() {
        $playlist = PlaylistBuilder::get()->withName('My playlist')->build();
        $playlist->addTrack(Track::create('id', 'My track'));

        $playlist->removeTrack(Track::create('id', 'My track'));

        $this->assertCount(
            0,
            $playlist->getTracks()
        );
    }
}
