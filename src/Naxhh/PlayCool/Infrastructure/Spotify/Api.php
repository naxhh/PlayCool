<?php

namespace Naxhh\PlayCool\Infrastructure\Spotify;
use SpotifyWebAPI\SpotifyWebAPIException;

/**
 * Wrapper for external Spotify API client.
 */
class Api
{
    private $external_api;

    //TEMPORAL FOR TESTING.
    private static $searches = array();

    public function __construct($external_api) {
        $this->external_api = $external_api;
    }

    /**
     * Searchs for a specific term in albums, artists and tracks.
     *
     * @param string $term The term to search for.
     * @return \stdClass
     */
    public function search($term) {
        if (isset(self::$searches[$term])) {
            return self::$searches[$term];
        }

        self::$searches[$term] = $this->external_api->search($term, array(
            'album',
            'artist',
            'track'
        ));

        return self::$searches[$term];
    }

    public function getTrack($track_id) {
        try {
            return $this->external_api->getTrack($track_id);
        } catch (SpotifyWebAPIException $e) {
            throw new NotFoundException;
        }
    }

    public function getAlbum($album_id) {
        try {
            return $this->external_api->getAlbum($album_id);
        } catch (SpotifyWebAPIException $e) {
            throw new NotFoundException;

        }
    }
}