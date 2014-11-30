<?php

namespace Naxhh\PlayCool\Domain\Contract;

use Naxhh\PlayCool\Domain\Entity\Playlist;
use Naxhh\PlayCool\Domain\ValueObject\PlaylistIdentity;

interface PlaylistRepository
{
    /**
     * Adds or updates an existing playlist.
     *
     * @param Playlist $playlist
     * @return void
     */
    public function add(Playlist $playlist);

    /**
     * Removes a playlist.
     *
     * @param  Playlist $playlist
     * @return void
     */
    public function remove(Playlist $playlist);

    /**
     * Retrieves a playlist by id.
     *
     * @param PlaylistIdentity $identity The identity of the playlist.
     * @return Playlist
     * @throws PlaylistNotFoundException If the playlist does not exist.
     */
    public function get(PlaylistIdentity $identity);

    /**
     * Retrieves all the playlists.
     *
     * @return Playlist[]
     */
    public function getAll();
}
