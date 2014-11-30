<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Spotify;

use Naxhh\PlayCool\Domain\Contract\AlbumRepository as DomainAlbumRepository;
use Naxhh\PlayCool\Domain\Entity\Album;
use Naxhh\PlayCool\Domain\ValueObject\AlbumIdentity;
use Naxhh\PlayCool\Domain\Entity\Track;

use Naxhh\PlayCool\Infrastructure\Spotify\NotFoundException;
use Naxhh\PlayCool\Domain\Exception\AlbumNotFoundException;

class AlbumRepository implements DomainAlbumRepository
{
    private $spotify_api;

    public function __construct($spotify_api) {
        $this->spotify_api = $spotify_api;
    }

    public function get(AlbumIdentity $identity) {
        try {
            $album_raw = $this->spotify_api->getAlbum($identity->getId());

            $album = Album::create($album_raw->id, $album_raw->name);

            foreach ($album_raw->tracks->items as $raw_track) {
                $album->addTrack(Track::create($raw_track->id, $raw_track->name));
            }

            return $album;
        } catch (NotFoundException $e) {
            throw new AlbumNotFoundException;
        }
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