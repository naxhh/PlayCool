<?php

namespace Naxhh\PlayCool\Domain\Contract;

use Naxhh\PlayCool\Domain\Entity\Playlist;

interface PlaylistRepository
{
	public function add(Playlist $playlist);
}
