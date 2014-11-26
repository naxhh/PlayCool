<?php

namespace Naxhh\PlayCool\Application\Contract;

interface UseCase
{
	public function handle(Command $command);
}
