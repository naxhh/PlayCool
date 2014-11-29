<?php

namespace Naxhh\PlayCool\Domain\Entity;

class ArtistTest extends \PHPUnit_Framework_TestCase
{
    public function testNewArtistHasNoTracks() {
        $artist = Artist::create('id', 'Artist name');

        $this->assertCount(
            0,
            $artist->getTracks()
        );
    }

    public function testAddTrackToArtist() {
        $artist = Artist::create('id', 'Artist name');

        $artist->addTrack(Track::create('id', 'Track name'));

        $this->assertCount(
            1,
            $artist->getTracks()
        );
    }

    public function testRemoveTrackFromArtist() {
        $artist = Artist::create('id', 'Artist name');

        $artist->addTrack(Track::create('id', 'Track name'));
        $artist->removeTrack(Track::create('id', 'Track name'));

        $this->assertCount(
            0,
            $artist->getTracks()
        );
    }
}