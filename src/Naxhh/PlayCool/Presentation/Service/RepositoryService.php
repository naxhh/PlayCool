<?php

namespace Naxhh\PlayCool\Presentation\Service;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Naxhh\PlayCool\Infrastructure\Repository\File\PlaylistRepository;

class RepositoryService implements ServiceProviderInterface
{
    public function register(Application $app) {

        $app['repo.playlist'] = $app->share(function() use($app) {
            return new PlaylistRepository($app['files_path']);
        });
    }

    public function boot(Application $app) {}
}
