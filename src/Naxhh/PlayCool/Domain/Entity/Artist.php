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
     * The list of albums in the artist.
     *
     * @var Album[]
     */
    private $albums;

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
        $this->albums = new ArrayCollection;
    }

    /**
     * Adds a album to the artist.
     *
     * @param Album $album The album to add.
     * @return void
     */
    public function addAlbum(Album $album) {
        $this->albums->set($album->getId(), $album);
    }

    /**
     * Removes a album from the artist.
     *
     * @param  album $album The album to remove.
     * @return void
     */
    public function removeAlbum(Album $album) {
        $this->albums->remove($album->getId());
    }

    /**
     * Retrieves the list of albums.
     *
     * @return Album[]
     */
    public function getAlbums() {
        return $this->albums;
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
