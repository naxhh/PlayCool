<?php

namespace Naxhh\PlayCool\Domain\Contract;

use Naxhh\PlayCool\Domain\ValueObject\TrackIdentity;

interface TrackRepository
{
    // @throws TrackNotFoundException
    public function get(TrackIdentity $identity);

    public function getListByName($name);

}
