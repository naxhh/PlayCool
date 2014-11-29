<?php

namespace Naxhh\Playcool\Application\UseCase;

use Naxhh\Playcool\Application\Command\SearchArtistCommand;
use Naxhh\Playcool\Domain\Entity\Artist;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;

class SearchArtistUseCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testSearchArtistReturnsAListOfAlbums() {
        $track_list = new ArrayCollection(array(
            Artist::create('id', 'Artist 1'),
            Artist::create('id2', 'Artist 2')
        ));

        $repository = $this->getMock('Naxhh\PlayCool\Domain\Contract\ArtistRepository');
        $repository->expects($this->any())
            ->method('getListByName')
            ->will($this->returnValue($track_list));

        $command  = new SearchArtistCommand('Search term');
        $use_case = new SearchArtistUseCase($repository);

        $artist_list = $use_case->handle($command);

        $this->assertCount(
            2,
            $artist_list
        );

        $this->assertInstanceOf(
            'Naxhh\Playcool\Domain\Entity\Artist',
            $artist_list->get(1)
        );
    }
}
