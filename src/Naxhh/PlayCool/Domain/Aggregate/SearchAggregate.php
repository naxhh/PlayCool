<?php

namespace Naxhh\PlayCool\Domain\Aggregate;

/**
 * Aggregates the serch results.
 */
class SearchAggregate
{
    /**
     * List of tracks in the result.
     *
     * @var array
     */
    private $tracks  = array();

    /**
     * List of albums in the result.
     *
     * @var array
     */
    private $albums  = array();

    /**
     * List of artists in the result.
     *
     * @var array
     */
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