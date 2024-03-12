<?php

namespace Astrogoat\Cypress\Settings;

use Astrogoat\Cypress\Actions\Open;
use Astrogoat\Cypress\Actions\Run;
use Astrogoat\Cypress\Peripherals\Runs;
use Helix\Lego\Settings\AppSettings;

class CypressSettings extends AppSettings
{
    protected array $peripherals = [
        Runs::class,
    ];

    protected static array $actions = [
        Open::class,
        Run::class,
    ];

    public function description(): string
    {
        return 'Interact with Cypress.';
    }

    public static function group(): string
    {
        return 'cypress';
    }
}
