<?php

namespace Naxhh\Playcool\Application\UseCase;

use Naxhh\Playcool\Application\Command\SearchAlbumCommand;
use Naxhh\Playcool\Domain\Entity\Album;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;

class SearchAlbumUseCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testSearchAlbumReturnsAListOfAlbums() {
        $track_list = new ArrayCollection(array(
            Album::create('id', 'Album 1'),
            Album::create('id2', 'Album 2')
        ));

        $repository = $this->getMock('Naxhh\PlayCool\Domain\Contract\AlbumRepository');
        $repository->expects($this->any())
            ->method('getListByName')
            ->will($this->returnValue($track_list));

        $command  = new SearchAlbumCommand('Search term');
        $use_case = new SearchAlbumUseCase($repository);

        $album_list = $use_case->handle($command);

        $this->assertCount(
            2,
            $album_list
        );

        $this->assertInstanceOf(
            'Naxhh\Playcool\Domain\Entity\Album',
            $album_list->get(1)
        );
    }
}
