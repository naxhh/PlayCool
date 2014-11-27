<?php

namespace Naxhh\PlayCool\Application\Contract;

/**
 * A command is an encapsulated request.
 * It aims to keep a standard structure.
 */
interface Command {

    /**
     * Returns the request of the command.
     * The request will contain importat information.
     *
     * @return Naxhh\Playcool\Domain\Adapter\ArrayCollection
     */
    public function getRequest();
}
