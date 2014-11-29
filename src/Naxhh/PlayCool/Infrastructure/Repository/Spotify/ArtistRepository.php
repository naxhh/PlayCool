<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Spotify;

use Naxhh\PlayCool\Domain\Contract\ArtistRepository as DomainArtistRepository;
use Naxhh\PlayCool\Domain\Entity\Artist;

class ArtistRepository implements DomainArtistRepository
{
    private $spotify_api;

    public function __construct($spotify_api) {
        $this->spotify_api = $spotify_api;
    }

    public function getListByName($name) {
        $result = $this->spotify_api->search($name);

        if (!isset($result->artists->items)) {
            return array();
        }

        $result = $result->artists->items;
        $artists = array();

        foreach ($result as $artist) {
            $artists[] = Artist::create($artist->id, $artist->name);
        }
        unset($result);

        return $artists;
    }
}