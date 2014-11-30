<?php

namespace Naxhh\PlayCool\Application\UseCase;

use Naxhh\PlayCool\Application\Contract\UseCase;
use Naxhh\PlayCool\Application\Contract\Command;
use Naxhh\PlayCool\Domain\Contract\PlaylistRepository;
use Naxhh\PlayCool\Domain\ValueObject\PlaylistIdentity;

// TMP.
use Naxhh\PlayCool\Domain\Entity\Track;

/**
 * Updates the name of a playlist.
 */
class UpdatePlaylistNameUseCase implements UseCase
{
    private $playlist_repository;

    public function __construct(PlaylistRepository $playlist_repository) {
        $this->playlist_repository = $playlist_repository;
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
        foreach ($tracks as $track) {
            $playlist->addTrack(Track::create($track['id'], $track['name']));
        }
    }

    private function removeTracks($playlist, $tracks) {
        foreach ($tracks as $track) {
            $playlist->removeTrack(Track::create($track['id'], $track['name']));
        }
    }
}
