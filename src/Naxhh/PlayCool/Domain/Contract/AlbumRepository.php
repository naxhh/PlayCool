<?php

namespace Naxhh\PlayCool\Domain\Contract;

interface AlbumRepository
{
    public function getListByName($name);
}
