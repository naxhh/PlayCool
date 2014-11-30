<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Spotify;

use Naxhh\PlayCool\Domain\Contract\AlbumRepository as DomainAlbumRepository;
use Naxhh\PlayCool\Infrastructure\Contract\TrackBuilder;
use Naxhh\PlayCool\Domain\Entity\Album;
use Naxhh\PlayCool\Domain\ValueObject\AlbumIdentity;

use Naxhh\PlayCool\Infrastructure\Spotify\NotFoundException;
use Naxhh\PlayCool\Domain\Exception\AlbumNotFoundException;

class AlbumRepository implements DomainAlbumRepository
{
    private $spotify_api;
    private $track_builder;

    public function __construct($spotify_api, TrackBuilder $track_builder) {
        $this->spotify_api   = $spotify_api;
        $this->track_builder = $track_builder;
    }

    public function get(AlbumIdentity $identity) {
        try {
            $album_raw = $this->spotify_api->getAlbum($identity->getId());

            $album = Album::create($album_raw->id, $album_raw->name);

            foreach ($album_raw->tracks->items as $track) {
                $album->addTrack($this->track_builder->buildTrack($track));
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