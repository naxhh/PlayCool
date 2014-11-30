<?php

namespace Naxhh\PlayCool\Presentation\Service;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Naxhh\PlayCool\Infrastructure\Spotify\Api as SpotifyApi;
use Naxhh\PlayCool\Infrastructure\Spotify\Credentials;
use Naxhh\PlayCool\Infrastructure\Spotify\RuntimeCacheDecorator;
use SpotifyWebAPI\SpotifyWebAPI as ThirdPartApi;

/**
 * Creates the spotify API object.
 * Also creates the access token for the api.
 */
class SpotifyApiService implements ServiceProviderInterface
{
    public function register(Application $app) {
        $app['spotify.api'] = $app->share(function() {
            $api = new ThirdPartApi;

            // TODO: Implement some sort of caching for the token.
            $session = new \SpotifyWebAPI\Session(Credentials::CLIENT_ID, Credentials::CLIENT_SECRET, '');
            $session->requestCredentialsToken(array());

            $api->setAccessToken($session->getAccessToken());

            return new RuntimeCacheDecorator(new SpotifyApi($api));
        });
    }

    public function boot(Application $app) {}
}
