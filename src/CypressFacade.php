<?php

namespace Astrogoat\Cypress;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Astrogoat\Cypress\Cypress
 */
class CypressFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cypress';
    }
}
