<?php

namespace Naxhh\Playcool\Application\UseCase;

use Naxhh\Playcool\Application\Command\SearchTrackCommand;
use Naxhh\Playcool\Domain\Entity\Track;
use Naxhh\Playcool\Domain\Adapter\ArrayCollection;

class SearchTrackUseCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testSearchTrackReturnsAListOfTracks()
    {
        $track_list = new ArrayCollection(array(
            Track::create('track 1 id', 'Track 1'),
            Track::create('amazing track id', 'Amazing track')
        ));

        $track_repository = $this->getMock('Naxhh\PlayCool\Domain\Contract\TrackRepository');
        $track_repository->expects($this->any())
            ->method('getListByName')
            ->will($this->returnValue($track_list));

        $command  = new SearchTrackCommand('Amazing track');
        $use_case = new SearchTrackUseCase($track_repository);

        $track_list = $use_case->handle($command);

        $this->assertCount(
            2,
            $track_list
        );

        $this->assertInstanceOf(
            'Naxhh\Playcool\Domain\Entity\Track',
            $track_list->get(1)
        );
    }
}
