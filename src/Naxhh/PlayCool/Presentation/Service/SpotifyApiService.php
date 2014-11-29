<?php

namespace Naxhh\PlayCool\Presentation\Service;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Naxhh\PlayCool\Infrastructure\Spotify\Api as SpotifyApi;
use Naxhh\PlayCool\Infrastructure\Spotify\Credentials;
use SpotifyWebAPI\SpotifyWebAPI as ThirdPartApi;

/**
 * Creates the spotify API object.
 * Also creates the access token for the api.
 */
class SpotifyApiService implements ServiceProviderInterface
{
    public function register(Application $app) {
        $this->api = $api = new ThirdPartApi;

        $app['spotify.api'] = $app->share(function() use($api) {
            return new SpotifyApi($api);
        });
    }

    public function boot(Application $app) {
        // TODO: Implement some sort of caching for the token.
        $session = new \SpotifyWebAPI\Session(Credentials::CLIENT_ID, Credentials::CLIENT_SECRET, '');
        $session->requestCredentialsToken(array());

        $this->api->setAccessToken($session->getAccessToken());
    }
}
