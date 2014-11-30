<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Redis;

use Naxhh\PlayCool\Domain\Contract\AlbumRepository as DomainAlbumRepository;
use Naxhh\PlayCool\Domain\ValueObject\AlbumIdentity;
use Naxhh\PlayCool\Infrastructure\Cache\Redis;

class AlbumRepository implements DomainAlbumRepository
{
    const PRE_KEY = 'album.';
    const SEARCH_PRE_KEY = 'search.album.';

    private $repository;
    private $redis;

    public function __construct(DomainAlbumRepository $repository, Redis $redis_cli) {
        $this->repository = $repository;
        $this->redis      = $redis_cli;
    }

    public function get(AlbumIdentity $identity) {
        $album = $this->redis->get(self::PRE_KEY . $identity->getId());

        if (!$album) {
            $album = $this->repository->get($identity);
            $this->redis->set(self::PRE_KEY . $identity->getId(), $album);
        }

        return $album;
    }

    public function getListByName($name) {
        $key = self::SEARCH_PRE_KEY . $name;

        $list = $this->redis->getSearch($key);

        if (!$list) {
            $list = $this->repository->getListByName($name);

            $this->redis->saveSearch($key, $list);
            $this->redis->saveAlbums(self::PRE_KEY, $list);
        }

        return $list;
    }
}