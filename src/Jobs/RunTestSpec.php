<?php

namespace Astrogoat\Cypress\Jobs;

use Astrogoat\Cypress\Events\FailedTestingSpecFile;
use Astrogoat\Cypress\Events\FinishedTestingSpecFile;
use Astrogoat\Cypress\Events\StartedTestingSpecFile;
use Astrogoat\Cypress\Models\TestRun;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Process;

class RunTestSpec implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $timeout = 3600;

    public function __construct(protected string $specFilePath)
    {
    }

    public function handle()
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        event(new StartedTestingSpecFile());

        /** @var TestRun $testsResult */
        $testsResult = TestRun::query()->firstWhere('batchId', $this->batchId);

        $process = Process::path(base_path())
            ->forever()
            ->start("npx cypress run --spec {$this->specFilePath} --reporter json-stream", function (string $type, string $output) use ($testsResult) {
                if (json_validate($output)) {
                    $data = json_decode($output);

                    if ($data[0] === 'pass') {
                        $testsResult->tests()->create([
                            'title' => $data[1]->title,
                            'status' => 'pass',
                            'spec_file' => $this->specFilePath,
                        ]);
                    } elseif ($data[0] === 'fail') {
                        $testsResult->tests()->create([
                            'title' => $data[1]->title,
                            'status' => $data[0],
                            'spec_file' => $this->specFilePath,
                            'error' => $data[1]->err ?? 'Unknown error',
                        ]);
                    }
                }
            });

        $process->wait();

        event(new FinishedTestingSpecFile());
    }

    public function failed(): void
    {
        event(new FailedTestingSpecFile());
    }
}
