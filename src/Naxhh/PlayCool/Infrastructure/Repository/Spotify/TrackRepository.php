<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Spotify;

use Naxhh\PlayCool\Domain\Contract\TrackRepository as DomainTrackRepository;
use Naxhh\PlayCool\Infrastructure\Contract\TrackBuilder;
use Naxhh\PlayCool\Domain\Entity\Track;
use Naxhh\PlayCool\Domain\ValueObject\TrackIdentity;

use Naxhh\PlayCool\Infrastructure\Spotify\NotFoundException;
use Naxhh\PlayCool\Domain\Exception\TrackNotFoundException;

class TrackRepository implements DomainTrackRepository, TrackBuilder
{
    private $spotify_api;

    public function __construct($spotify_api) {
        $this->spotify_api = $spotify_api;
    }

    public function get(TrackIdentity $identity) {
        try {
            $raw_track = $this->spotify_api->getTrack($identity->getId());

            return $this->buildTrack($raw_track);
        } catch (NotFoundException $e) {
            throw new TrackNotFoundException;
        }
    }

    public function getListByName($name) {
        $result = $this->spotify_api->search($name);

        if (!isset($result->tracks->items)) {
            return array();
        }

        $result = $result->tracks->items;

        return array_map(array($this, 'buildTrack'), $result);
    }

    public function buildTrack(\stdClass $track) {
        if (!isset($track->id) || !isset($track->name)) {
            throw new InvalidArgumentException('Id and name are mandatory for building the track object');
        }

        return Track::create($track->id, $track->name);
    }
}