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

    public function getList($key) {
        return array_map(function($item) {
            return unserialize($item);
        }, $this->client->hgetall($key));
    }

    public function saveList($key, $list) {
        $this->client->pipeline(function($pipe) use($key, $list) {
            foreach ($list as $item) {
                $pipe->hset($key, $item->getId(), serialize($item));
            }
        });
    }

    public function getItemFromList($key, $item_key) {
        $item = $this->client->hget($key, $item_key);

        if (!$item) {
            return false;
        }

        return unserialize($item);
    }

    public function saveItemInList($key, $item) {
        $this->client->hset($key, $item->getId(), serialize($item));
    }

    public function removeItemInList($key, $item) {
        $this->client->hdel($key, $item->getId());
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
        $this->saveMultipleItems($tracks, function($track) use($prefix) {
            return $prefix . $track->getId();
        });
    }

    private function saveMultipleItems($list, Callable $callback) {
        $this->client->pipeline(function($pipe) use($list, $callback) {
            foreach ($list as $item) {
                $key = $callback($item);

                $pipe->set($key, serialize($item));
            }
        });
    }
}
