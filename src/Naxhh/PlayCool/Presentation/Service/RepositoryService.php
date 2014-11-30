<?php

namespace Naxhh\PlayCool\Presentation\Service;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\PlaylistRepository;

class RepositoryService implements ServiceProviderInterface
{
    public function register(Application $app) {

        $app['repo.playlist'] = $app->share(function() {
            return new PlaylistRepository;
        });
    }

    public function boot(Application $app) {}
}
