<?php

namespace Test\Helper;

use Naxhh\PlayCool\Domain\Entity\Playlist;

class PlaylistBuilder
{
    private $name = 'My playlist';
    private $id   = 'Unique id';

    public static function get() {
        return new self;
    }

    public function withId($id) {
        $this->id = $id;

        return $this;
    }

    public function withName($name) {
        $this->name = $name;

        return $this;
    }

    public function build() {
        return Playlist::create($this->id, $this->name);
    }
}