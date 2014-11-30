<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\File;

use Naxhh\PlayCool\Domain\Contract\PlaylistRepository as DomainPlaylistRepository;
use Naxhh\PlayCool\Domain\Entity\Playlist;
use Naxhh\PlayCool\Domain\ValueObject\PlaylistIdentity;
use Naxhh\PlayCool\Domain\Exception\PlaylistNotFoundException;

class PlaylistRepository implements DomainPlaylistRepository
{
    private $path;
    private $content;

    public function __construct($file_path) {
        $this->path    = $file_path . 'playlists.json';
        $this->content = json_decode(file_get_contents($this->path), true);
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
        $this->content[$playlist->getId()] = array(
            'id'   => $playlist->getId(),
            'name' => $playlist->getName(),
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

        $playlist = $this->content[$identity->getId()];

        return Playlist::create($playlist['id'], $playlist['name']);
    }

    /**
     * Retrieves all the playlists.
     *
     * @return Playlist[]
     */
    public function getAll() {
        $playlists = array();

        foreach ($this->content as $playlist) {
            $playlists[] = Playlist::create($playlist['id'], $playlist['name']);
        }

        return $playlists;
    }
}
