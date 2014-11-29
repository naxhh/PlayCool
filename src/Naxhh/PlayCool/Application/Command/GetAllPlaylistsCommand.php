<?php

namespace Naxhh\PlayCool\Application\Command;

use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;

/**
 * Retrieves all the playlists.
 */
class GetAllPlaylistsCommand implements Command
{
    public function getRequest() {
        return new ArrayCollection(array());
    }
}
