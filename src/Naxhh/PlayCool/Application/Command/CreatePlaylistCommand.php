<?php

namespace Naxhh\PlayCool\Application\Command;

use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;
use Naxhh\PlayCool\Application\Exception\InvalidPlaylistNameException;

/**
 * Creates a new empty playlist.
 */
class CreatePlaylistCommand implements Command
{
    private $name;

    public function __construct($name) {
        $this->name = trim($name);

        if (!$this->name) {
            throw new InvalidPlaylistNameException();
        }
    }

    public function getRequest()
    {
        return new ArrayCollection(array(
            'name' => $this->name
        ));
    }
}
