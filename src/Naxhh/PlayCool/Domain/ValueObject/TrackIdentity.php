<?php

namespace Naxhh\PlayCool\Domain\ValueObject;

class TrackIdentity
{
    private $id;

    public function __construct($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
}
