<?php

namespace Naxhh\PlayCool\Infrastructure\Spotify;
use SpotifyWebAPI\SpotifyWebAPIException;

/**
 * Adapter for external Spotify API client.
 */
class Api
{
    //TEMPORAL FOR TESTING.
    private static $searches = array();

    /**
     * Third party SDK for spotify API.
     */
    private $external_api;

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

    /**
     * Retrieves a track from the API.
     * @param  string $track_id The id of the track.
     * @return \stdClass
     * @throws NotFoundException If the track was not found.
     */
    public function getTrack($track_id) {
        try {
            return $this->external_api->getTrack($track_id);
        } catch (SpotifyWebAPIException $e) {
            throw new NotFoundException;
        }
    }

    /**
     * Retrieves a album from the API.
     * @param  string $album_id The id of the album.
     * @return \stdClass
     * @throws NotFoundException If the album was not found.
     */
    public function getAlbum($album_id) {
        try {
            return $this->external_api->getAlbum($album_id);
        } catch (SpotifyWebAPIException $e) {
            throw new NotFoundException;

        }
    }

    /**
     * Retrieves an artist from the API.
     * @param  string $artist_id The id of the artist.
     * @return \stdClass
     * @throws NotFoundException If the artist was not found.
     */
    public function getArtist($artist_id) {
        try {
            return $this->external_api->getArtist($artist_id);
        } catch (SpotifyWebAPIException $e) {
            throw new NotFoundException;
        }
    }

    /**
     * Retrieves albums of an artist.
     * @param  string $artist_id The id of the artist.
     * @return \stdClass
     * @throws NotFoundException If the artist was not found.
     */
    public function getArtistAlbums($artist_id) {
        try {
            return $this->external_api->getArtistAlbums($artist_id);
        } catch (SpotifyWebAPIException $e) {
            throw new NotFoundException;
        }
    }
}