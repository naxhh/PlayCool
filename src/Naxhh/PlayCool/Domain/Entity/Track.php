<?php

namespace Naxhh\Playcool\Domain\Entity;

use Naxhh\Playcool\Domain\ValueObject\TrackIdentity;

class Track
{
    /**
     * The unique id of the track.
     *
     * @var string
     */
    private $id;

    /**
     * The name of the track.
     *
     * @var string
     */
    private $name;

    /**
     * Public interface for creating a new track.
     *
     * @param  string $id The unique id of the track.
     * @param  string $track_name The name of the track.
     * @return Track
     */
    public static function create($id, $track_name) {
        return new self(new TrackIdentity($id), $track_name);
    }

    private function __construct(TrackIdentity $id, $name) {
        $this->id   = $id;
        $this->name = $name;
    }

    /**
     * Returns the Id of the Track.
     *
     * @return string
     */
    public function getId() {
        return $this->id->getId();
    }

    /**
     * Returns the name of the track.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }
}
