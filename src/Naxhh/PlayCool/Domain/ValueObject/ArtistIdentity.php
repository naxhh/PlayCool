<?php

namespace Naxhh\PlayCool\Domain\ValueObject;

class ArtistIdentity
{
    private $id;

    public function __construct($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
}
