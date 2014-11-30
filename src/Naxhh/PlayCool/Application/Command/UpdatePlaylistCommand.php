<?php

namespace Naxhh\PlayCool\Application\Command;

use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;
use Naxhh\PlayCool\Application\Exception\InvalidPlaylistNameException;

/**
 * Updates a playlist, updating name or adding/removing tracks.
 */
class UpdatePlaylistCommand implements Command
{
    private $id;
    private $new_name;
    private $add_tracks;
    private $remove_tracks;

    public function __construct($id, $new_name = null, $add_tracks = array(), $remove_tracks = array()) {
        $this->id         = $id;
        $this->new_name   = trim($new_name);
        $this->add_tracks = $add_tracks ?: array();
        $this->remove_tracks = $remove_tracks ?: array();

        if (!$this->new_name && !is_null($new_name)) {
            throw new InvalidPlaylistNameException();
        }
    }

    public function getRequest()
    {
        return new ArrayCollection(array(
            'id'         => $this->id,
            'new_name'   => $this->new_name,
            'add_tracks' => $this->add_tracks,
            'remove_tracks' => $this->remove_tracks,
        ));
    }
}
