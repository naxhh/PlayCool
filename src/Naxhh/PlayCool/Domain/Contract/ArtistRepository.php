<?php

namespace Naxhh\PlayCool\Domain\Contract;

interface ArtistRepository
{
    public function getListByName($name);
}
