<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Dummy;

use Naxhh\PlayCool\Domain\Contract\TrackRepository as DomainTrackRepository;
use Naxhh\PlayCool\Domain\Entity\Track;

class TrackRepository implements DomainTrackRepository
{
    public function getListByName($name) {
        $tracks = array();

        $tracks[] = Track::create($name);
        $tracks[] = Track::create($name . ' something');
        $tracks[] = Track::create('Something ' . $name . ' something');

        return $tracks;
    }
}