<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Dummy;

use Naxhh\PlayCool\Domain\Contract\AlbumRepository as DomainAlbumRepository;
use Naxhh\PlayCool\Domain\Entity\Album;

class AlbumRepository implements DomainAlbumRepository
{
    public function getListByName($name) {
        $tracks = array();

        $tracks[] = Album::create($name, $name);
        $tracks[] = Album::create($name . 's', $name . ' something');
        $tracks[] = Album::create('s' . $name . 's', 'Something ' . $name . ' something');

        return $tracks;
    }
}