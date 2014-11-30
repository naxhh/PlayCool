<?php

namespace Naxhh\PlayCool\Presentation\Service;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Naxhh\PlayCool\Infrastructure\Repository\Spotify\TrackRepository;
use Naxhh\PlayCool\Infrastructure\Repository\File\PlaylistRepository;
use Naxhh\PlayCool\Infrastructure\Repository\Spotify\AlbumRepository;
use Naxhh\PlayCool\Infrastructure\Repository\Spotify\ArtistRepository;

use Naxhh\PlayCool\Infrastructure\Cache\Redis;
use Naxhh\PlayCool\Infrastructure\Repository\Redis\TrackRepository as RedisTrackRepository;

class RepositoryService implements ServiceProviderInterface
{
    public function register(Application $app) {
        $app['repo.track'] = $app->share(function() use($app) {
            return new RedisTrackRepository(
                new TrackRepository($app['spotify.api']),
                new Redis($app['predis'])
            );
        });

        $app['repo.playlist'] = $app->share(function() use($app) {
            return new PlaylistRepository($app['files_path'], $app['repo.track']);
        });

        $app['repo.album'] = $app->share(function() use ($app) {
            return new AlbumRepository($app['spotify.api'], $app['repo.track']);
        });

        $app['repo.artist'] = $app->share(function() use ($app) {
            return new ArtistRepository($app['spotify.api']);
        });
    }

    public function boot(Application $app) {}
}
