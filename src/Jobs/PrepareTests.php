<?php

namespace Astrogoat\Cypress\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Astrogoat\Cypress\Models\TestRun;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PrepareTests implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle()
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        TestRun::create(['batchId' => $this->batchId]);

        $testSpecs = File::allFiles("tests/cypress/tests/" . tenant()->id);

        $specFileJobs = collect($testSpecs)->map(function (SplFileInfo $specFile) {
            return new RunTestSpec($specFile->getPathname());
        })->toArray();

        $this->batch()->add($specFileJobs);

//        $this->batch()->add(new RunTestSpec('tests/cypress/tests/helix-sleep/smoke/cart.cy.js'));
//        $this->batch()->add(new RunTestSpec('tests/cypress/tests/helix-sleep/smoke/cart.cy.js'));
//        $this->batch()->add(new RunTestSpec('tests/cypress/tests/helix-sleep/smoke/cart.cy.js'));
    }
}
