<?php

namespace Astrogoat\Cypress\Settings;

use Astrogoat\Cypress\Actions\Open;
use Astrogoat\Cypress\Actions\RunFullTestSuite;
use Astrogoat\Cypress\Peripherals\Runs;
use Helix\Lego\Settings\AppSettings;
use Astrogoat\Cypress\Actions\RunSelectedTests;

class CypressSettings extends AppSettings
{
    protected array $peripherals = [
        Runs::class,
    ];

    protected static array $actions = [
        Open::class,
        RunFullTestSuite::class,
        RunSelectedTests::class,
    ];

    public function description(): string
    {
        return 'Run automated tests with Cypress.';
    }

    public static function group(): string
    {
        return 'cypress';
    }
}
