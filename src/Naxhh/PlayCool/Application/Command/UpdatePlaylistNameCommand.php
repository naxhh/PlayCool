<?php

namespace Naxhh\PlayCool\Application\Command;

use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;

/**
 * Updates the name of a playlist.
 * You should provide the current name of the playlist and the new one.
 */
class UpdatePlaylistNameCommand implements Command
{
    private $name;
    private $new_name;

    public function __construct($name, $new_name) {
        $this->name = $name;
        $this->new_name = $new_name;
    }

    public function getRequest()
    {
        return new ArrayCollection(array(
            'name'     => $this->name,
            'new_name' => $this->new_name
        ));
    }
}
