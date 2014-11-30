<?php

namespace Naxhh\PlayCool\Application\Command;

use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;

/**
 * Search for albums.
 */
class SearchAlbumCommand implements Command
{
    private $search_term;

    public function __construct($search_term) {
        $this->search_term = $search_term;
    }

    public function getRequest()
    {
        return new ArrayCollection(array(
            'search_term' => $this->search_term
        ));
    }
}
