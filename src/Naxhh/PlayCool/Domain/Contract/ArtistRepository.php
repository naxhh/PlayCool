<?php

namespace Naxhh\PlayCool\Domain\Contract;

use Naxhh\PlayCool\Domain\ValueObject\ArtistIdentity;

interface ArtistRepository
{
    // @throws ArtistNotFoundException
    public function get(ArtistIdentity $identity);

    public function getListByName($name);
}
