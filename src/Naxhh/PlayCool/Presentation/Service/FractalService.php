<?php

namespace Naxhh\PlayCool\Presentation\Service;

use Silex\Application;
use Silex\ServiceProviderInterface;
use League\Fractal;

/**
 * Creates the Fractal manager to transform data.
 */
class FractalService implements ServiceProviderInterface
{
    public function register(Application $app) {
        $app['fractal'] = $app->share(function() {
            return new Fractal\Manager;
        });
    }

    public function boot(Application $app) {}
}
