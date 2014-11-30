<?php

namespace Naxhh\PlayCool\Infrastructure\Cache;

/**
 * The Adapter of the Redis cache system.
 */
class Redis
{
    /**
     * Third party client for Redis.
     */
    private $client;

    public function __construct($client) {
        $this->client = $client;
    }

    /**
     * Retrieves a serialized object stored in the given key.
     *
     * @param  string $key The key to retrieve.
     * @return string The serialized representtion of the stored object.
     */
    public function get($key) {
        $result = $this->client->get($key);

        if ($result) {
            $result = unserialize($result);
        }

        return $result;
    }

    /**
     * Stores a serialized object in the given jey.
     *
     * @param string $key  The key to store.
     * @param Domain\Entity\* $item Any entity from the domain.
     * @return void
     */
    public function set($key, $item) {
        $this->client->set($key, serialize($item));
    }

    /**
     * Retrieves a list of objects stored in a hash list.
     *
     * @param  string $key The key of the hash list.
     * @return Domain\Entity\*[] Any list of entities from the domain.
     */
    public function getList($key) {
        return array_map(function($item) {
            return unserialize($item);
        }, $this->client->hgetall($key));
    }

    /**
     * Stores a list of objects in a hash list.
     *
     * @param  string $key  The key of the hash list.
     * @param  Domain\Entity\*[] $list The list of domain objects.
     * @return void
     */
    public function saveList($key, $list) {
        $this->client->pipeline(function($pipe) use($key, $list) {
            foreach ($list as $item) {
                $pipe->hset($key, $item->getId(), serialize($item));
            }
        });
    }

    /**
     * Retrieves one item (field) from the hash list.
     *
     * @param  string $key      The key of the hash list.
     * @param  string $item_key The key of the item (field in redis).
     * @return Domain\Entity\* An object from the domain.
     */
    public function getItemFromList($key, $item_key) {
        $item = $this->client->hget($key, $item_key);

        if (!$item) {
            return false;
        }

        return unserialize($item);
    }

    /**
     * Stores an item in the hash list.
     *
     * @param  string $key  The key of the has list.
     * @param  string $item The key of the item (the field).
     * @return void
     */
    public function saveItemInList($key, $item) {
        $this->client->hset($key, $item->getId(), serialize($item));
    }

    /**
     * Removes an item from the hash list.
     *
     * @param  string $key  The key of the hash list.
     * @param  Domain\Entity\*[] $item An item from the domain.
     * @return void
     */
    public function removeItemInList($key, $item) {
        $this->client->hdel($key, $item->getId());
    }

    /**
     * Retrieves a search result.
     *
     * @param  string $term The term of the search.
     * @return Domain\Entity\*[] A list of domain objects.
     */
    public function getSearch($term) {
        return array_map(function($item) {
            return unserialize($item);
        }, $this->client->smembers($term));
    }

    /**
     * Stores a search result.
     *
     * @param string $term   The term of the search.
     * @param Domain\Entity\*[] $result A list of domain objects.
     * @return void
     */
    public function saveSearch($term, $result) {
        $this->client->pipeline(function($pipe) use($term, $result) {
            foreach ($result as $item) {
                $pipe->sadd($term, serialize($item));
            }
        });
    }

    /**
     * Save a list of tracks in a string structure.
     *
     * @param  string $prefix The prefix for each track.
     * @param  Domain\Entity\Track[] $tracks A list of tracks to save.
     * @return void
     */
    public function saveTracks($prefix, $tracks) {
        $this->saveMultipleItems($tracks, function($track) use($prefix) {
            return $prefix . $track->getId();
        });
    }

    /**
     * A helper function to save multiple items in a string structure.
     *
     * @param  Domain\Entity\*[]   $list     A list of domain objects.
     * @param  Callable $callback The callback to generate the item key.
     * @return void
     */
    private function saveMultipleItems($list, Callable $callback) {
        $this->client->pipeline(function($pipe) use($list, $callback) {
            foreach ($list as $item) {
                $key = $callback($item);

                $pipe->set($key, serialize($item));
            }
        });
    }
}
