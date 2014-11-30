<?php

namespace Naxhh\PlayCool\Infrastructure\Contract;

interface TrackBuilder {
    /**
     * Creates a valid Track domain object given a PPO.
     *
     * @param  stdClass $track The php plain object to convert.
     * @return Track
     * @throws \InvalidArgumentException If the object does not contain id and name.
     */
    public function buildTrack(\stdClass $track);
}