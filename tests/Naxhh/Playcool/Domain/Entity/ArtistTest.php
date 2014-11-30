<?php

namespace Naxhh\PlayCool\Domain\Entity;

class ArtistTest extends \PHPUnit_Framework_TestCase
{
    public function testNewArtistHasNoAlbums() {
        $artist = Artist::create('id', 'Artist name');

        $this->assertCount(
            0,
            $artist->getAlbums()
        );
    }

    public function testDddAlbumToArtist() {
        $artist = Artist::create('id', 'Artist name');

        $artist->addAlbum(Album::create('id', 'Album name'));

        $this->assertCount(
            1,
            $artist->getAlbums()
        );
    }

    public function testRemoveAlbumFromArtist() {
        $artist = Artist::create('id', 'Artist name');

        $artist->addAlbum(Album::create('id', 'Album name'));
        $artist->removeAlbum(Album::create('id', 'Album name'));

        $this->assertCount(
            0,
            $artist->getAlbums()
        );
    }
}