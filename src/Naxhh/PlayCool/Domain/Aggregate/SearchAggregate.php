<?php

namespace Naxhh\PlayCool\Domain\Aggregate;

class SearchAggregate
{
    private $tracks  = array();
    private $albums  = array();
    private $artists = array();

    public function setTracks($tracks) {
        $this->tracks = $tracks;
    }

    public function getTracks() {
        return $this->tracks;
    }

    public function setAlbums($albums) {
        $this->albums = $albums;
    }

    public function getAlbums() {
        return $this->albums;
    }

    public function setArtists($artists) {
        $this->artists = $artists;
    }

    public function getArtists() {
        return $this->artists;
    }
}