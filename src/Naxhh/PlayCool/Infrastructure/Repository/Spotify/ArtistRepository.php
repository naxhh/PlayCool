<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Spotify;

use Naxhh\PlayCool\Domain\Contract\ArtistRepository as DomainArtistRepository;
use Naxhh\PlayCool\Domain\Entity\Artist;
use Naxhh\PlayCool\Domain\ValueObject\ArtistIdentity;
use Naxhh\PlayCool\Domain\Entity\Album;

use Naxhh\PlayCool\Infrastructure\Spotify\NotFoundException;
use Naxhh\PlayCool\Domain\Exception\ArtistNotFoundException;

class ArtistRepository implements DomainArtistRepository
{
    /**
     * The Spotify API adapter.
     */
    private $spotify_api;

    public function __construct($spotify_api) {
        $this->spotify_api = $spotify_api;
    }

    /**
     * Retrieves the artist with the given identity.
     *
     * @param  ArtistIdentity $identity The identity of the artist to retrieve.
     * @return Domain\Entity\Artist
     * @throws Domain\Exception\ArtistNotFoundException If no artist has the requested identity.
     */
    public function get(ArtistIdentity $identity) {
        try {
            $artist_raw = $this->spotify_api->getArtist($identity->getId());
            $artist_albums = $this->spotify_api->getArtistAlbums($identity->getId());

            $artist = Artist::create($artist_raw->id, $artist_raw->name);

            foreach ($artist_albums->items as $album) {
                $artist->addAlbum(Album::create($album->id, $album->name));
            }

            return $artist;
        } catch (NotFoundException $e) {
            throw new ArtistNotFoundException();
        }
    }

    /**
     * Retrieves a list of artists that match the given name.
     *
     * @param  string $name The name to search for.
     * @return Domain\Entity\Artist[]
     */
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