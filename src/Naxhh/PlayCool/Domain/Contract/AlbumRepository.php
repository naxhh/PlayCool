<?php

namespace Naxhh\PlayCool\Domain\Contract;

use Naxhh\PlayCool\Domain\ValueObject\AlbumIdentity;

interface AlbumRepository
{
    // @throws AlbumNotFoundException
    public function get(AlbumIdentity $identity);

    public function getListByName($name);
}
