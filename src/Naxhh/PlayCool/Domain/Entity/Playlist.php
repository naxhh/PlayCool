<?php

namespace Naxhh\Playcool\Domain\Entity;

use Naxhh\Playcool\Domain\ValueObject\PlaylistIdentity;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;
use Naxhh\Playcool\Domain\Exception\TrackAlreadyAddedException;

class Playlist
{
    /**
     * The unique id of the playlist.
     *
     * @var PlaylistIdentity
     */
    private $id;

    /**
     * The name of the playlist.
     *
     * @var string
     */
    private $name;

    /**
     * List of tracks of the current playlist.
     *
     * @var Track[]
     */
    private $tracks;

    /**
     * Public interface for creating a new playlist.
     *
     * @param  string $playlist_name The name of the playlist
     * @return Playlist
     */
    public static function create($playlist_name) {
        return new self(new PlaylistIdentity($playlist_name), $playlist_name);
    }

    private function __construct(PlaylistIdentity $id, $name) {
        $this->id     = $id;
        $this->name   = $name;
        $this->tracks = new ArrayCollection;
    }

    /**
     * Returns the id of the playlist.
     *
     * @return string
     */
    public function getId() {
        return $this->id->getId();
    }

    /**
     * Retrieves the current name of the playlist.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Updates the name of the playlist.
     *
     * @param string $name The new name for the playlist.
     * @return void
     */
    public function updateName($name) {
        $this->name = $name;
    }

    /**
     * Get the list of tracks for the playlist.
     *
     * @return Track[]
     */
    public function getTracks() {
        return $this->tracks;
    }

    /**
     * Adds a track into the playlist. It fails if the track is already in the playlist.
     *
     * @param  Track $track The track to add to the playlist.
     * @return void
     * @throws Exception\TrackAlreadyAddedException If the track is already in the playlist.
     */
    public function addTrack(Track $track) {

        $track_already_exists = function($key, $item) use ($track) {
            return $track->getId() == $item->getId();
        };

        if ($this->tracks->exists($track_already_exists)) {
            throw new TrackAlreadyAddedException(sprintf(
                'Track with name "%s" already exist in the playlist', $track->getName()
            ));
        }

        $this->tracks->set($track->getId(), $track);
    }

    /**
     * Removes a track from the playlist.
     *
     * @param  Track $track The track to remove from the playlist.
     * @return void
     */
    public function removeTrack(Track $track) {
        $this->tracks->remove($track->getId());
    }
}
