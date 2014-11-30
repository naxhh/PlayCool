<?php

namespace Naxhh\PlayCool\Application\UseCase;

use Naxhh\PlayCool\Application\Contract\UseCase;
use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\PlayCool\Domain\Contract\PlaylistRepository;
use Naxhh\PlayCool\Domain\Contract\TrackRepository;
use Naxhh\PlayCool\Domain\ValueObject\PlaylistIdentity;
use Naxhh\PlayCool\Domain\ValueObject\TrackIdentity;
use Naxhh\PlayCool\Domain\Exception\TrackNotFoundException;

// TMP.
use Naxhh\PlayCool\Domain\Entity\Track;

/**
 * Updates a playlist.
 */
class UpdatePlaylistUseCase implements UseCase
{
    private $playlist_repository;
    private $track_repository;

    public function __construct(PlaylistRepository $playlist_repository, TrackRepository $track_repository) {
        $this->playlist_repository = $playlist_repository;
        $this->track_repository    = $track_repository;
    }

    public function handle(Command $command) {
        $request = $command->getRequest();

        $playlist = $this->playlist_repository->get(
            new PlaylistIdentity($request->get('id'))
        );

        if (!is_null($request->get('new_name'))) {
            $playlist->updateName($request->get('new_name'));
        }

        $this->addTracks($playlist, $request->get('add_tracks'));
        $this->removeTracks($playlist, $request->get('remove_tracks'));

        $this->playlist_repository->add($playlist);

        return $playlist;
    }

    private function addTracks($playlist, $tracks) {
        $this->handleTracks($tracks, function($track) use ($playlist) {
            $playlist->addTrack($track);
        });
    }

    private function removeTracks($playlist, $tracks) {
        $this->handleTracks($tracks, function($track) use ($playlist) {
            $playlist->removeTrack($track);
        });
    }

    private function handleTracks($tracks, Callable $callback) {
         foreach ($tracks as $raw_track) {
            try {
                $track = $this->track_repository->get(new TrackIdentity($raw_track['id']));

                $callback($track);
            } catch (TrackNotFoundException $e) {}
        }
    }
}
