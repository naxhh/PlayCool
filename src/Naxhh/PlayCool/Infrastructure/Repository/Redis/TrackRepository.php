<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Redis;

use Naxhh\PlayCool\Domain\Contract\TrackRepository as DomainTrackRepository;
use Naxhh\PlayCool\Infrastructure\Contract\TrackBuilder;
use Naxhh\PlayCool\Domain\Entity\Track;
use Naxhh\PlayCool\Domain\ValueObject\TrackIdentity;
use Naxhh\PlayCool\Infrastructure\Cache\Redis;

class TrackRepository implements DomainTrackRepository, TrackBuilder
{
    const PRE_KEY = 'track.';
    const SEARCH_PRE_KEY = 'search.track.';

    private $repository;
    private $redis;

    public function __construct(DomainTrackRepository $repository, Redis $redis_cli) {
        $this->repository = $repository;
        $this->redis      = $redis_cli;
    }

    public function get(TrackIdentity $identity) {
        $key = PRE_KEY . $identity->getId();

        $track = $this->redis->get($key);

        if (!$track) {
            $track = $this->repository->get($identity);
            $this->redis->set($key, $track);
        }

        return $track;
    }

    public function getListByName($name) {
        $key = SEARCH_PRE_KEY . $name;
        $list = $this->redis->getSearch($key);

        if (!$list) {
            $list = $this->repository->getListByName($name);

            $this->redis->saveSearch($key, $list);
            $this->redis->saveTracks(PRE_KEY, $list);
        }

        return $list;
    }

    public function buildTrack(\stdClass $track) {
        return $this->repository->buildTrack($track);
    }
}