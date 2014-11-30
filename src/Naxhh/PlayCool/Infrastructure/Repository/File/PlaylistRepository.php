<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\File;

use Naxhh\PlayCool\Domain\Contract\PlaylistRepository as DomainPlaylistRepository;
use Naxhh\PlayCool\Domain\Entity\Playlist;
use Naxhh\PlayCool\Domain\ValueObject\PlaylistIdentity;
use Naxhh\PlayCool\Domain\Exception\PlaylistNotFoundException;
use Naxhh\PlayCool\Infrastructure\Contract\TrackBuilder;

class PlaylistRepository implements DomainPlaylistRepository
{
    private $path;
    private $content;
    private $track_builder;

    public function __construct($file_path, TrackBuilder $track_builder) {
        $this->path    = $file_path . 'playlists.json';
        $this->content = json_decode(file_get_contents($this->path), true);
        $this->track_builder = $track_builder;
    }

    public function __destruct() {
        file_put_contents($this->path, json_encode($this->content));
    }

    /**
     * Adds or updates an existing playlist.
     *
     * @param Playlist $playlist
     */
    public function add(Playlist $playlist) {
        $tracks = $playlist->getTracks();
        $tracks_list = array();

        foreach ($tracks as $track) {
            $tracks_list[$track->getId()] = array(
                'id'   => $track->getId(),
                'name' => $track->getName()
            );
        }

        $this->content[$playlist->getId()] = array(
            'id'     => $playlist->getId(),
            'name'   => $playlist->getName(),
            'tracks' => $tracks_list,
        );
    }

    /**
     * Removes a playlist.
     *
     * @param  Playlist $playlist
     * @return void
     */
    public function remove(Playlist $playlist) {
        unset($this->content[$playlist->getId()]);
    }

    /**
     * Retrieves a playlist by id.
     *
     * @param PlaylistIdentity $identity The identity of the playlist.
     * @return Playlist
     */
    public function get(PlaylistIdentity $identity) {
        if (!isset($this->content[$identity->getId()])) {
            throw new PlaylistNotFoundException();
        }

        $raw_playlist = $this->content[$identity->getId()];

        return $this->buildPlaylist($raw_playlist);
    }

    /**
     * Retrieves all the playlists.
     *
     * @return Playlist[]
     */
    public function getAll() {
        $playlists = array();

        foreach ($this->content as $playlist) {
            $playlists[] = $this->buildPlaylist($playlist);
        }

        return $playlists;
    }

    private function buildPlaylist($raw_playlist) {
        $playlist = Playlist::create($raw_playlist['id'], $raw_playlist['name']);

        if (isset($raw_playlist['tracks'])) {
            foreach ($raw_playlist['tracks'] as $raw_track) {
                $track = new \stdClass;
                $track->id = $raw_track['id'];
                $track->name = $raw_track['name'];

                $playlist->addTrack($this->track_builder->buildTrack($track));
            }
        }

        return $playlist;
    }
}
