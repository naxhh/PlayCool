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
        $this->saveList($tracks, function($track) use($prefix) {
            return $prefix . $track->getId();
        });
    }

    private function saveList($list, Callable $callback) {
        $this->client->pipeline(function($pipe) use($list, $callback) {
            foreach ($list as $item) {
                $key = $callback($item);

                $pipe->set($key, serialize($item));
            }
        });
    }
}
