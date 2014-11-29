<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\TrackRepository;
use Naxhh\PlayCool\Application\Command\SearchTrackCommand;
use Naxhh\PlayCool\Application\UseCase\SearchTrackUseCase;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\AlbumRepository;
use Naxhh\PlayCool\Application\Command\SearchAlbumCommand;
use Naxhh\PlayCool\Application\UseCase\SearchAlbumUseCase;

use Naxhh\PlayCool\Infrastructure\Repository\Dummy\ArtistRepository;
use Naxhh\PlayCool\Application\Command\SearchArtistCommand;
use Naxhh\PlayCool\Application\UseCase\SearchArtistUseCase;

use Naxhh\PlayCool\Presentation\Transformer\SearchTransformer;
use League\Fractal;

class Search
{
    public function execute(Request $request, Application $app) {

        $term = $request->query->get('q');

        $search = new \Naxhh\PlayCool\Domain\Aggregate\SearchAggregate();
        $search->setTracks($this->getTracks($term));
        $search->setAlbums($this->getAlbums($term));
        $search->setArtists($this->getArtists($term));

        $resource = new Fractal\Resource\Item($search, new SearchTransformer);

        return new JsonResponse(
            $app['fractal']->createData($resource)->toArray(),
            200
        );
    }

    private function getTracks($term) {
        $use_case = new SearchTrackUseCase(new TrackRepository);

        return $use_case->handle(new SearchTrackCommand($term));
    }

    private function getAlbums($term) {
        $use_case = new SearchAlbumUseCase(new AlbumRepository);

        return $use_case->handle(new SearchAlbumCommand($term));
    }

    private function getArtists($term) {
        $use_case = new SearchArtistUseCase(new ArtistRepository);

        return $use_case->handle(new SearchArtistCommand($term));
    }
}
