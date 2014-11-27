<?php

namespace Naxhh\PlayCool\Presentation\Transformer;

use League\Fractal\TransformerAbstract;
use Naxhh\PlayCool\Domain\Entity\Track;

/**
 * Transforms a Track domain object to a public resource.
 */
class TrackTransformer extends TransformerAbstract
{
    public function transform(Track $track) {
        return array(
            'id'   => $track->getId(),
            'name' => $track->getName(),
        );
    }
}
