<?php

namespace Astrogoat\Cypress\Actions;

use Illuminate\Bus\PendingBatch;
use Astrogoat\Cypress\Enums\RunSteps;
use Astrogoat\Cypress\Jobs\PrepareTests;
use Helix\Lego\Apps\Actions\BatchAction;
use Astrogoat\Cypress\Events\FinishedTesting;

class Run extends BatchAction
{
    public function batchTitle(): string
    {
        return 'Run tests';
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
        return [new PrepareTests()];
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
