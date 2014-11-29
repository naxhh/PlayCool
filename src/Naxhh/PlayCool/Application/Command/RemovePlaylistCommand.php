<?php

namespace Naxhh\PlayCool\Application\Command;

use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;

/**
 * Removes a playlist.
 */
class RemovePlaylistCommand implements Command
{
    private $id;

    public function __construct($id) {
        $this->id = $id;
    }

    public function getRequest()
    {
        return new ArrayCollection(array(
            'id' => $this->id
        ));
    }
}
