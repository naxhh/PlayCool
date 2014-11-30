<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Redis;

use Naxhh\PlayCool\Domain\Contract\PlaylistRepository as DomainPlaylistRepository;
use Naxhh\PlayCool\Domain\Entity\Playlist;
use Naxhh\PlayCool\Domain\ValueObject\PlaylistIdentity;
use Naxhh\PlayCool\Infrastructure\Cache\Redis;

class PlaylistRepository implements DomainPlaylistRepository
{
    const KEY = 'playlists';

    private $repository;
    private $redis;

    public function __construct(DomainPlaylistRepository $repository, Redis $redis_cli) {
        $this->repository = $repository;
        $this->redis      = $redis_cli;
    }

    public function add(Playlist $playlist) {
        $this->repository->add($playlist);
        $this->redis->saveItemInList(self::KEY, $playlist);
    }

    public function remove(Playlist $playlist) {
        $this->repository->remove($playlist);
        $this->redis->removeItemInList(self::KEY, $playlist);
    }

    public function get(PlaylistIdentity $identity) {
        $playlist = $this->redis->getItemFromList(self::KEY, $identity->getId());

        if (!$playlist) {
            $playlist = $this->repository->get($identity);

            $this->redis->saveItemInList(self::KEY, $playlist);
        }

        return $playlist;
    }

    public function getAll() {
        $list = $this->redis->getList(self::KEY);

        if (!$list) {
            $list = $this->repository->getAll($playlist);

            $this->redis->saveList(self::KEY, $list);
        }

        return $list;
    }
}