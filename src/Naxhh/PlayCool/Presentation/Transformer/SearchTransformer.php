<?php

namespace Naxhh\PlayCool\Presentation\Transformer;

use League\Fractal\TransformerAbstract;
use Naxhh\PlayCool\Domain\Aggregate\SearchAggregate;

/**
 * Transform the SearchAggregate results into valid resources.
 */
class SearchTransformer extends TransformerAbstract
{
    /**
     * Includes the tracks, albums and artists in the search results.
     *
     * @var array
     */
    protected $defaultIncludes = array('tracks', 'albums', 'artists');

    public function transform(SearchAggregate $search) {
        return array();
    }

    public function includeTracks(SearchAggregate $search) {
        return $this->collection($search->getTracks(), new TrackTransformer);
    }

    public function includeAlbums(SearchAggregate $search) {
        return $this->collection($search->getAlbums(), new AlbumTransformer);
    }

    public function includeArtists(SearchAggregate $search) {
        return $this->collection($search->getArtists(), new ArtistTransformer);
    }
}
