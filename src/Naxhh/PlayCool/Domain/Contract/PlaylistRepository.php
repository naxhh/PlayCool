<?php

namespace Naxhh\PlayCool\Domain\Contract;

use Naxhh\PlayCool\Domain\Entity\Playlist;

/**
 * Repository interface for the Playlist.
 * A playlist is an aggregate of tracks.
 */
interface PlaylistRepository
{
    /**
     * Adds or updates an existing playlist.
     *
     * @param Playlist $playlist
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
     * Retrieves a playlist by the given name.
     *
     * @param string $playlist_name The name of the playlist.
     * @return Playlist
     */
    public function get($playlist_name);
}
