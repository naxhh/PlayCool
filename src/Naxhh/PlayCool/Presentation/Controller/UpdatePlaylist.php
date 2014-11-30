<?php

namespace Naxhh\PlayCool\Presentation\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Naxhh\PlayCool\Application\Command\UpdatePlaylistCommand;
use Naxhh\PlayCool\Application\UseCase\UpdatePlaylistUseCase;
use Naxhh\PlayCool\Presentation\Transformer\PlaylistTransformer;
use Naxhh\PlayCool\Application\Exception\InvalidPlaylistNameException;
use Naxhh\PlayCool\Domain\Exception\PlaylistNotFoundException;
use Naxhh\PlayCool\Infrastructure\Repository\Spotify\TrackRepository;
use League\Fractal;

class UpdatePlaylist
{
    private $app;

    public function execute(Request $request, Application $app, $id) {
        try {
            $this->app = $app;

            $command = new UpdatePlaylistCommand(
                $id,
                $request->request->get('name'),
                $request->request->get('add-tracks'),
                $request->request->get('remove-tracks')
            );

            $playlist = $this->buildUseCase()->handle($command);
            $resource = new Fractal\Resource\Item($playlist, new PlaylistTransformer);

            return new JsonResponse(
                $this->app['fractal']->createData($resource)->toArray(),
                200
            );
        } catch (InvalidPlaylistNameException $e) {
            $this->app->abort(400, 'You should provide a valid name for the playlist');
        } catch (PlaylistNotFoundException $e) {
            $this->app->abort(404);
        }
    }

    private function buildUseCase() {
        return new UpdatePlaylistUseCase(
            $this->app['repo.playlist'],
            $this->app['repo.track']
        );
    }
}
