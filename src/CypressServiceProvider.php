<?php

namespace Astrogoat\Cypress;

use Livewire\Livewire;
use Helix\Lego\Apps\App;
use Helix\Lego\LegoManager;
use Astrogoat\Cypress\Actions\Run as RunAction;
use Illuminate\Support\Facades\Config;
use Spatie\LaravelPackageTools\Package;
use Astrogoat\Cypress\Peripherals\Runs as RunsPeripheral;
use Astrogoat\Cypress\Modals\Run as RunModal;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Astrogoat\Cypress\Settings\CypressSettings;

class CypressServiceProvider extends PackageServiceProvider
{
    public function registerApp(App $app)
    {
        return $app
            ->name('cypress')
            ->settings(CypressSettings::class)
            ->migrations([
                __DIR__ . '/../database/migrations',
                __DIR__ . '/../database/migrations/settings',
            ])
            ->backendRoutes(__DIR__.'/../routes/backend.php')
            ->frontendRoutes(__DIR__.'/../routes/frontend.php');
    }

    public function registeringPackage()
    {
        $this->callAfterResolving('lego', function (LegoManager $lego) {
            $lego->registerApp(fn (App $app) => $this->registerApp($app));
        });

        Config::set('queue.connections', array_merge(
            $this->app['config']->get('queue.connections'),
            [
                'cypress' => [
                    'driver' => 'redis',
                    'connection' => 'default',
                    'queue' => env('REDIS_QUEUE', 'default'),
                    'retry_after' => 10800,
                    'block_for' => null,
                    'after_commit' => false,
                ]
            ]
        ));
    }

    public function bootingPackage()
    {
        Livewire::component('astrogoat.cypress.actions.run', RunAction::class);
        Livewire::component('astrogoat.cypress.peripherals.runs', RunsPeripheral::class);
        Livewire::component('astrogoat.cypress.modals.run', RunModal::class);
    }

    public function configurePackage(Package $package): void
    {
        $package->name('cypress')->hasConfigFile()->hasViews();
    }
}
