<?php

namespace Naxhh\PlayCool\Domain\Contract;

use Naxhh\PlayCool\Domain\Entity\Playlist;
use Naxhh\PlayCool\Domain\ValueObject\PlaylistIdentity;

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
     * Retrieves a playlist by id.
     *
     * @param PlaylistIdentity $identity The identity of the playlist.
     * @return Playlist
     */
    public function get(PlaylistIdentity $identity);
}
