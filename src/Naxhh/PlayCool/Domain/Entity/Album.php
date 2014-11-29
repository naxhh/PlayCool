<?php

namespace Naxhh\Playcool\Domain\Entity;

use Naxhh\Playcool\Domain\ValueObject\AlbumIdentity;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;

class Album
{
    /**
     * The unique identifier of the album.
     *
     * @var string
     */
    private $id;

    /**
     * The name of the album.
     *
     * @var string
     */
    private $name;

    /**
     * The list of tracks in the album.
     *
     * @var Track[]
     */
    private $tracks;

    /**
     * Public interface for creating a new Album.
     *
     * @param  string $id   The unique identifier of the album.
     * @param  string $name The name of the album.
     * @return Album
     */
    public static function create($id, $name) {
        return new self(new AlbumIdentity($id), $name);
    }

    private function __construct(AlbumIdentity $id, $name) {
        $this->id     = $id;
        $this->name   = $name;
        $this->tracks = new ArrayCollection;
    }

    /**
     * Adds a track to the album.
     *
     * @param Track $track The track to add.
     * @return void
     */
    public function addTrack(Track $track) {
        $this->tracks->set($track->getId(), $track);
    }

    /**
     * Removes a track from the album.
     *
     * @param  Track  $track The track to remove.
     * @return void
     */
    public function removeTrack(Track $track) {
        $this->tracks->remove($track->getId());
    }

    /**
     * Retrieves the list of tracks.
     *
     * @return Track[]
     */
    public function getTracks() {
        return $this->tracks;
    }
}