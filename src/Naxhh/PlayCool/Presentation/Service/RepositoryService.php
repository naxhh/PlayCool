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
use Naxhh\PlayCool\Infrastructure\Repository\Redis\AlbumRepository as RedisAlbumRepository;
use Naxhh\PlayCool\Infrastructure\Repository\Redis\ArtistRepository as RedisArtistRepository;
use Naxhh\PlayCool\Infrastructure\Repository\Redis\PlaylistRepository as RedisPlaylistRepository;

class RepositoryService implements ServiceProviderInterface
{
    public function register(Application $app) {
        $app['redis'] = $app->share(function() use($app) {
            return new Redis($app['predis']);
        });

        $app['repo.track'] = $app->share(function() use($app) {
            return new RedisTrackRepository(
                new TrackRepository($app['spotify.api']),
                $app['redis']
            );
        });

        $app['repo.playlist'] = $app->share(function() use($app) {
            return new RedisPlaylistRepository(
                new PlaylistRepository($app['files_path'], $app['repo.track']),
                $app['redis']
            );
        });

        $app['repo.album'] = $app->share(function() use ($app) {
            return new RedisAlbumRepository(
                new AlbumRepository($app['spotify.api'], $app['repo.track']),
                $app['redis']
            );
        });

        $app['repo.artist'] = $app->share(function() use ($app) {
            return new RedisArtistRepository(
                new ArtistRepository($app['spotify.api']),
                $app['redis']
            );
        });
    }

    public function boot(Application $app) {}
}
