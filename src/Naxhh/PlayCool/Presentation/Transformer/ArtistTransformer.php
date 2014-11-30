<?php

namespace Naxhh\PlayCool\Presentation\Transformer;

use League\Fractal\TransformerAbstract;
use Naxhh\PlayCool\Domain\Entity\Artist;

/**
 * Transforms a Artist domain object to a public resource.
 */
class ArtistTransformer extends TransformerAbstract
{
    /**
     * Includes the albums if present.
     *
     * @var array
     */
    protected $defaultIncludes = array('albums');

    public function transform(Artist $artist) {

        return array(
            'id'   => $artist->getId(),
            'name' => $artist->getName(),
        );
    }

    public function includeAlbums(Artist $artist) {
        return $this->collection($artist->getAlbums(), new AlbumTransformer);
    }
}
