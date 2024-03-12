<?php

namespace Astrogoat\Cypress\Actions;

use Astrogoat\Cypress\Enums\RunSteps;
use Astrogoat\Cypress\Events\FinishedTesting;
use Astrogoat\Cypress\Jobs\PrepareTests;
use Helix\Lego\Apps\Actions\BatchAction;
use Illuminate\Bus\PendingBatch;

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
