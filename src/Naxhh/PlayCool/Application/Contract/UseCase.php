<?php

namespace Naxhh\PlayCool\Application\Contract;

/**
 * A use case of the Domain logic.
 * Use cases are our public classes for interacting with the domain.
 */
interface UseCase
{
    /**
     * Handles an interaction between a request (command) and the domain.
     *
     * @param  Command $command The command we want to handle.
     * @return mixed Every command will return its own data-type
     */
    public function handle(Command $command);
}
