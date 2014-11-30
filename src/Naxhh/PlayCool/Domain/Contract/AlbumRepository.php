<?php

namespace Naxhh\PlayCool\Domain\Contract;

use Naxhh\PlayCool\Domain\ValueObject\AlbumIdentity;

interface AlbumRepository
{
    /**
     * Retrieves the album with the given identity.
     *
     * @param  AlbumIdentity $identity The identity of the album to retrieve.
     * @return Domain\Entity\Album
     * @throws Domain\Exception\AlbumNotFoundException If no album has the requested identity.
     */
    public function get(AlbumIdentity $identity);

    /**
     * Retrieves a list of albums that match the given name.
     *
     * @param  string $name The name to search for.
     * @return Domain\Entity\Album[]
     */
    public function getListByName($name);
}
