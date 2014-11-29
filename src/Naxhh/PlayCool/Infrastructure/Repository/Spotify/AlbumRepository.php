<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Spotify;

use Naxhh\PlayCool\Domain\Contract\AlbumRepository as DomainAlbumRepository;
use Naxhh\PlayCool\Domain\Entity\Album;

class AlbumRepository implements DomainAlbumRepository
{
    private $spotify_api;

    public function __construct($spotify_api) {
        $this->spotify_api = $spotify_api;
    }

    public function getListByName($name) {
        $result = $this->spotify_api->search($name);

        if (!isset($result->albums->items)) {
            return array();
        }

        $result = $result->albums->items;
        $albums = array();

        foreach ($result as $artist) {
            $albums[] = Album::create($artist->id, $artist->name);
        }
        unset($result);

        return $albums;
    }
}