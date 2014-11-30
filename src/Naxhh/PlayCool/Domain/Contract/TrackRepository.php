<?php

namespace Naxhh\PlayCool\Domain\Contract;

use Naxhh\PlayCool\Domain\ValueObject\TrackIdentity;

interface TrackRepository
{
    /**
     * Retrieves the track with the given identity.
     *
     * @param  TrackIdentity $identity The identity of the track to retrieve.
     * @return Domain\Entity\Track
     * @throws Domain\Exception\TrackNotFoundException If no track has the requested identity.
     */
    public function get(TrackIdentity $identity);

    /**
     * Retrieves a list of tracks that match the given name.
     *
     * @param  string $name The name to search for.
     * @return Domain\Entity\Track[]
     */
    public function getListByName($name);

}
