<?php

namespace Naxhh\PlayCool\Application\Command;

use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;

class CreatePlaylistCommand implements Command
{
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getRequest()
    {
        return new ArrayCollection(array(
            'name' => $this->name
        ));
    }
}
