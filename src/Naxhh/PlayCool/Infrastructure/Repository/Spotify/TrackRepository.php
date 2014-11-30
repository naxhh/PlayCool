<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Spotify;

use Naxhh\PlayCool\Domain\Contract\TrackRepository as DomainTrackRepository;
use Naxhh\PlayCool\Domain\Entity\Track;
use Naxhh\PlayCool\Domain\ValueObject\TrackIdentity;

class TrackRepository implements DomainTrackRepository
{
    private $spotify_api;

    public function __construct($spotify_api) {
        $this->spotify_api = $spotify_api;
    }

    public function get(TrackIdentity $identity) {
        $raw_track = $this->spotify_api->getTrack($identity->getId());

        return Track::create($raw_track->id, $raw_track->name);
    }

    public function getListByName($name) {
        $result = $this->spotify_api->search($name);

        if (!isset($result->tracks->items)) {
            return array();
        }

        $result = $result->tracks->items;
        $tracks = array();

        foreach ($result as $track) {
            $tracks[] = Track::create($track->id, $track->name);
        }
        unset($result);

        return $tracks;
    }
}