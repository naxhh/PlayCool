<?php

namespace Naxhh\PlayCool\Presentation\Transformer;

use League\Fractal\TransformerAbstract;
use Naxhh\PlayCool\Domain\Entity\Playlist;

/**
 * Transforms a Playlist domain object to a public resource.
 */
class PlaylistTransformer extends TransformerAbstract
{
    /**
     * Includes the tracks of the playlist to the resource output.
     *
     * @var array
     */
    protected $defaultIncludes = array('tracks');

    public function transform(Playlist $playlist) {

        return array(
            'id' => $playlist->getId(),
            'name' => $playlist->getName(),
        );
    }

    public function includeTracks(Playlist $playlist) {
        return $this->collection($playlist->getTracks(), new TrackTransformer);
    }
}
