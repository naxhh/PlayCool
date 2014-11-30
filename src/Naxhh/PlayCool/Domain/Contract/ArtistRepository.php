<?php

namespace Naxhh\PlayCool\Domain\Contract;

use Naxhh\PlayCool\Domain\ValueObject\ArtistIdentity;

interface ArtistRepository
{
    /**
     * Retrieves the artist with the given identity.
     *
     * @param  ArtistIdentity $identity The identity of the artist to retrieve.
     * @return Domain\Entity\Artist
     * @throws Domain\Exception\ArtistNotFoundException If no artist has the requested identity.
     */
    public function get(ArtistIdentity $identity);

    /**
     * Retrieves a list of artists that match the given name.
     *
     * @param  string $name The name to search for.
     * @return Domain\Entity\Artist[]
     */
    public function getListByName($name);
}
