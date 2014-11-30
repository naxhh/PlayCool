<?php

namespace Naxhh\PlayCool\Infrastructure\Spotify;

/**
 * A decorator for caching serches in runtime.
 * This way if we call the search method 3 times in the same run we only perform 1 lookup to the api.
 */
class RuntimeCacheDecorator
{
    /**
     * A map with the performed searches in the current run.
     *
     * @var array
     */
    private static $previous_searchs = array();

    /**
     * The original API class.
     *
     * @var Api
     */
    private $api;

    public function __construct(Api $api) {
        $this->api = $api;
    }

    public function search($term) {
        if (!isset(self::$previous_searchs[$term])) {
            self::$previous_searchs[$term] = $this->api->search($term);
        }

        return self::$previous_searchs[$term];
    }

    public function getTrack($track_id) {
        return $this->api->getTrack($track_id);
    }

    public function getAlbum($album_id) {
            return $this->api->getAlbum($album_id);
    }

    public function getArtist($artist_id) {
        return $this->api->getArtist($artist_id);
    }

    public function getArtistAlbums($artist_id) {
        return $this->api->getArtistAlbums($artist_id);
    }


}