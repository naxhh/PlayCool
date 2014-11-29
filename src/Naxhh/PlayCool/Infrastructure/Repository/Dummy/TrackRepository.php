<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Dummy;

use Naxhh\PlayCool\Domain\Contract\TrackRepository as DomainTrackRepository;
use Naxhh\PlayCool\Domain\Entity\Track;

class TrackRepository implements DomainTrackRepository
{
    public function getListByName($name) {
        $tracks = array();

        $tracks[] = Track::create($name, $name);
        $tracks[] = Track::create($name . 's', $name . ' something');
        $tracks[] = Track::create('s' . $name . 's', 'Something ' . $name . ' something');

        return $tracks;
    }
}