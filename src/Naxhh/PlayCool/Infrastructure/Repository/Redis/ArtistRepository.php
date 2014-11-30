<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Redis;

use Naxhh\PlayCool\Domain\Contract\ArtistRepository as DomainArtistRepository;
use Naxhh\PlayCool\Domain\ValueObject\ArtistIdentity;
use Naxhh\PlayCool\Infrastructure\Cache\Redis;

class ArtistRepository implements DomainArtistRepository
{
    const PRE_KEY = 'artist.';
    const SEARCH_PRE_KEY = 'search.artist.';

    private $repository;
    private $redis;

    public function __construct(DomainArtistRepository $repository, Redis $redis_cli) {
        $this->repository = $repository;
        $this->redis      = $redis_cli;
    }

    public function get(ArtistIdentity $identity) {
        $key = PRE_KEY . $identity->getId();

        $artist = $this->redis->get($key);

        if (!$artist) {
            $artist = $this->repository->get($identity);

            $this->redis->set($key, $artist);
        }

        return $artist;
    }

    public function getListByName($name) {
        $key = self::SEARCH_PRE_KEY . $name;

        $list = $this->redis->getSearch($key);

        if (!$list) {
            $list = $this->repository->getListByName($name);

            $this->redis->saveSearch($key, $list);
        }

        return $list;
    }
}