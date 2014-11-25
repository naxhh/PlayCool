<?php

namespace Naxhh\Playcool\Domain\Entity;

class Track
{
    /**
     * The name of the track.
     *
     * @var string
     */
    private $name;

    /**
     * Public interface for creating a new track.
     *
     * @param  string $track_name The name of the track.
     * @return Track
     */
    public static function create($track_name) {
        return new self($track_name);
    }

    private function __construct($name) {
        $this->name = $name;
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