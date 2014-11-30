<?php

namespace Naxhh\PlayCool\Application\Command;

use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;
use Naxhh\PlayCool\Application\Exception\InvalidPlaylistNameException;

/**
 * Updates the name of a playlist.
 * You should provide the current name of the playlist and the new one.
 */
class UpdatePlaylistNameCommand implements Command
{
    private $id;
    private $new_name;

    public function __construct($id, $new_name) {
        $this->id       = $id;
        $this->new_name = trim($new_name);

        if (!$this->new_name) {
            throw new InvalidPlaylistNameException();
        }
    }

    public function getRequest()
    {
        return new ArrayCollection(array(
            'id'       => $this->id,
            'new_name' => $this->new_name
        ));
    }
}
