<?php

namespace Astrogoat\Cypress\Actions;

use Astrogoat\Cypress\Enums\RunSteps;
use Astrogoat\Cypress\Events\FinishedTesting;
use Astrogoat\Cypress\Jobs\PrepareTests;
use Helix\Lego\Apps\Actions\BatchAction;
use Illuminate\Bus\PendingBatch;
use Illuminate\Support\Facades\File;
use SplFileInfo;

class RunFullTestSuite extends BatchAction
{
    public function batchTitle(): string
    {
        return 'Run full test suite';
    }

    public function batchJobBroadcastChannel(): string
    {
        return 'astrogoat.cypress';
    }

    public function batchJobListeners(): array
    {
        return [
            '.tests.spec-started',
            '.test.passed',
            '.test.failed',
            '.tests.spec-finished',
            '.tests.spec-failed',
            '.tests.finished',
            '.job.cancelled',
            '.job.failed',
        ];
    }

    public function batchJobs(): array
    {
        $testSpecs = File::allFiles(base_path("tests/cypress/tests/" . tenant()->id));

        $specFilePaths = collect($testSpecs)->map(fn (SplFileInfo $specFile) => $specFile->getPathname())->toArray();

        return [new PrepareTests($specFilePaths)];
    }

    public function batchJobSteps(): string
    {
        return RunSteps::class;
    }

    public function configureBatchJobs(PendingBatch $batch): PendingBatch
    {
        return $batch->finally(fn () => FinishedTesting::dispatch());
    }
}
