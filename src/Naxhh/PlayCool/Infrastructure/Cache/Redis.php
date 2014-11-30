<?php

namespace Naxhh\PlayCool\Infrastructure\Cache;

class Redis
{
    private $client;

    public function __construct($client) {
        $this->client = $client;
    }

    public function getSearch($term) {
        $result = $this->client->smembers($term);

        return array_map(function($item) {
            return unserialize($item);
        }, $result);
    }

    public function saveSearch($term, $result) {
        $this->client->pipeline(function($pipe) {
            foreach ($result as $item) {
                $pipe->sadd($term, serialize($item));
            }
        });
    }
}
