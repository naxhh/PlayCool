<?php

namespace Naxhh\PlayCool\Presentation\Transformer;

use League\Fractal\TransformerAbstract;
use Naxhh\PlayCool\Domain\Entity\Album;

/**
 * Transforms a Album domain object to a public resource.
 */
class AlbumTransformer extends TransformerAbstract
{
    /**
     * Includes the tracks if present.
     *
     * @var array
     */
    protected $defaultIncludes = array('tracks');

    public function transform(Album $album) {

        return array(
            'id'   => $album->getId(),
            'name' => $album->getName(),
        );
    }

    public function includeTracks(Album $album) {
        return $this->collection($album->getTracks(), new TrackTransformer);
    }
}
