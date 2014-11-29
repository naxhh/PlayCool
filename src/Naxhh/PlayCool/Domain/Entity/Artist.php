<?php

namespace Naxhh\Playcool\Domain\Entity;

use Naxhh\Playcool\Domain\ValueObject\ArtistIdentity;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;

class Artist
{
    /**
     * The unique identifier of the artist.
     *
     * @var string
     */
    private $id;

    /**
     * The name of the artist.
     *
     * @var string
     */
    private $name;

    /**
     * The list of tracks in the artist.
     *
     * @var Track[]
     */
    private $tracks;

    /**
     * Public interface for creating a new artist.
     *
     * @param  string $id   The unique identifier of the artist.
     * @param  string $name The name of the artist.
     * @return Artist
     */
    public static function create($id, $name) {
        return new self(new ArtistIdentity($id), $name);
    }

    private function __construct(ArtistIdentity $id, $name) {
        $this->id     = $id;
        $this->name   = $name;
        $this->tracks = new ArrayCollection;
    }

    /**
     * Adds a track to the artist.
     *
     * @param Track $track The track to add.
     * @return void
     */
    public function addTrack(Track $track) {
        $this->tracks->set($track->getId(), $track);
    }

    /**
     * Removes a track from the artist.
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

    /**
     * Returns the unique id of the artist.
     *
     * @return string
     */
    public function getId() {
        return $this->id->getId();
    }

    /**
     * Returns the name of the artist.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }
}