<?php

namespace Naxhh\PlayCool\Domain\Contract;;

interface TrackRepository
{
    public function getListByName($name);
}
