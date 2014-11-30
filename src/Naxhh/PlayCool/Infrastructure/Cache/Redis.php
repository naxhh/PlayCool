<?php

namespace Naxhh\PlayCool\Infrastructure\Cache;

class Redis
{
    private $client;

    public function __construct($client) {
        $this->client = $client;
    }

    public function get($key) {
        $result = $this->client->get($key);

        if ($result) {
            $result = unserialize($result);
        }

        return $result;
    }

    public function set($key, $item) {
        $this->client->set($key, serialize($item));
    }

    public function getSearch($term) {
        return array_map(function($item) {
            return unserialize($item);
        }, $this->client->smembers($term));
    }

    public function saveSearch($term, $result) {
        $this->client->pipeline(function($pipe) use($term, $result) {
            foreach ($result as $item) {
                $pipe->sadd($term, serialize($item));
            }
        });
    }

    public function saveTracks($prefix, $tracks) {
        $this->client->pipeline(function($pipe) use($prefix, $tracks) {
            foreach ($tracks as $track) {
                $pipe->set($prefix . $track->getId(), serialize($track));
            }
        });
    }

    public function saveAlbums($prefix, $albums) {
        $this->client->pipeline(function($pipe) use($prefix, $albums) {
            foreach ($albums as $album) {
                $pipe->set($prefix . $album->getId(), serialize($album));
            }
        });
    }

    public function saveArtists($prefix, $artists) {
        $this->client->pipeline(function($pipe) use($prefix, $artists) {
            foreach ($artists as $artist) {
                $pipe->set($prefix . $artist->getId(), serialize($artist));
            }
        });
    }
}
