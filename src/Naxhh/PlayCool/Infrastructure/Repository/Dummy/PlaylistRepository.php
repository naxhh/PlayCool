<?php

namespace Naxhh\PlayCool\Infrastructure\Repository\Dummy;

use Naxhh\PlayCool\Domain\Contract\PlaylistRepository as DomainPlaylistRepository;
use Naxhh\PlayCool\Domain\Entity\Playlist;
use Naxhh\PlayCool\Domain\ValueObject\PlaylistIdentity;

class PlaylistRepository implements DomainPlaylistRepository
{
    /**
     * Adds or updates an existing playlist.
     *
     * @param Playlist $playlist
     */
    public function add(Playlist $playlist) {}

    /**
     * Removes a playlist.
     *
     * @param  Playlist $playlist
     * @return void
     */
    public function remove(Playlist $playlist) {}

    /**
     * Retrieves a playlist by id.
     *
     * @param PlaylistIdentity $identity The identity of the playlist.
     * @return Playlist
     */
    public function get(PlaylistIdentity $identity) {
        return Playlist::create($identity->getId(), 'Name of the playlist');
    }

    /**
     * Retrieves all the playlists.
     *
     * @return Playlist[]
     */
    public function getAll() {
        return array(
            Playlist::create('Asdf13rg', 'One playlist'),
            Playlist::create('FdsSdD21', 'Another playlist'),
        );
    }
}
