<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\TrackRepository;
use Naxhh\PlayCool\Application\Command\SearchTrackCommand;
use Naxhh\PlayCool\Application\UseCase\SearchTrackUseCase;
use Naxhh\PlayCool\Presentation\Transformer\TrackTransformer;
use League\Fractal;

class Search
{
    public function execute(Request $request, Application $app) {

        $term = $request->query->get('q');

        $tracks = $this->buildUseCase()->handle(new SearchTrackCommand($term));

        $resource = new Fractal\Resource\Collection($tracks, new TrackTransformer);

        return new JsonResponse(
            $app['fractal']->createData($resource)->toArray(),
            200
        );
    }

    private function buildUseCase() {
        $playlist_repository = new TrackRepository;
        return new SearchTrackUseCase($playlist_repository);
    }
}
