<?php

namespace Naxhh\PlayCool\Domain\Entity;

class AlbumTest extends \PHPUnit_Framework_TestCase
{
    public function testNewAlbumHasNoTracks() {
        $album = Album::create('id', 'Album name');

        $this->assertCount(
            0,
            $album->getTracks()
        );
    }

    public function testAddTrackToAlbum() {
        $album = Album::create('id', 'Album name');

        $album->addTrack(Track::create('id', 'Track name'));

        $this->assertCount(
            1,
            $album->getTracks()
        );
    }

    public function testRemoveTrackFromAlbum() {
        $album = Album::create('id', 'Album name');

        $album->addTrack(Track::create('id', 'Track name'));
        $album->removeTrack(Track::create('id', 'Track name'));

        $this->assertCount(
            0,
            $album->getTracks()
        );
    }
}