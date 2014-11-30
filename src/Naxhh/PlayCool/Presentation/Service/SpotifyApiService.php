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
        $app['spotify.api'] = $app->share(function() use($app) {
            $api = new ThirdPartApi;


            if (!$auth_token = $app['predis']->get('spotify:auth')) {
                $session = new \SpotifyWebAPI\Session(Credentials::CLIENT_ID, Credentials::CLIENT_SECRET, '');
                $session->requestCredentialsToken(array());

                $auth_token = $session->getAccessToken();

                $app['predis']->set('spotify:auth', $auth_token);
                $app['predis']->expire('spotify:auth', ($session->getExpires() - 60));
            }

            $api->setAccessToken($auth_token);

            return new RuntimeCacheDecorator(new SpotifyApi($api));
        });
    }

    public function boot(Application $app) {}
}
