<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Dummy;

use Naxhh\PlayCool\Domain\Contract\ArtistRepository as DomainArtistRepository;
use Naxhh\PlayCool\Domain\Entity\Artist;

class ArtistRepository implements DomainArtistRepository
{
    public function getListByName($name) {
        $tracks = array();

        $tracks[] = Artist::create($name, $name);
        $tracks[] = Artist::create($name . 's', $name . ' something');
        $tracks[] = Artist::create('s' . $name . 's', 'Something ' . $name . ' something');

        return $tracks;
    }
}