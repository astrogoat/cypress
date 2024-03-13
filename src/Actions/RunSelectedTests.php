<?php

namespace Astrogoat\Cypress\Actions;

use SplFileInfo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Astrogoat\Cypress\Enums\RunSteps;
use Astrogoat\Cypress\Events\FinishedTesting;
use Astrogoat\Cypress\Jobs\PrepareTests;
use Helix\Lego\Apps\Actions\BatchAction;
use Illuminate\Bus\PendingBatch;

class RunSelectedTests extends BatchAction
{
    public array $selectedTestPaths = [];

    public function runSelectedJobs()
    {
        $this->dispatchBatchJobs();

        sleep(1);
    }

    public function batchTitle(): string
    {
        return 'Run selected tests';
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

    public function getTestSpecFiles(): array
    {
        if (! File::exists(base_path('tests/cypress/tests/' . tenant()->id))) {
            return [];
        }

        return collect(File::allFiles(base_path('tests/cypress/tests/' . tenant()->id)))
            ->map(function (SplFileInfo $fileInfo) {
                return [
                    'key' => $fileInfo->getPathname(),
                    'value' => Str::of($fileInfo->getPathname())->afterLast(tenant()->id . '/')->beforeLast('.cy')->toString(),
                    'selected' => false,
                ];
            })
            ->toArray();
    }

    public function selectTest(string $testPath): void
    {
        $this->selectedTestPaths[] = $testPath;
    }

    public function deselectTest(string $testPath): void
    {
        $this->selectedTestPaths = array_filter($this->selectedTestPaths, fn ($selectedTestPath) => $selectedTestPath !== $testPath);
    }

    public function batchJobs(): array
    {
        return [new PrepareTests($this->selectedTestPaths)];
    }

    public function batchJobSteps(): string
    {
        return RunSteps::class;
    }

    public function configureBatchJobs(PendingBatch $batch): PendingBatch
    {
        return $batch->finally(fn () => FinishedTesting::dispatch());
    }

    public function render()
    {
        return view('cypress::actions.run-selected-tests');
    }
}
