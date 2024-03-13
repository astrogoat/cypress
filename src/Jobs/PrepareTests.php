<?php

namespace Astrogoat\Cypress\Jobs;

use Astrogoat\Cypress\Models\TestRun;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PrepareTests implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected array $testSpecFilePaths)
    {
    }

    public function handle()
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        TestRun::create(['batchId' => $this->batchId]);

        $specFileJobs = collect($this->testSpecFilePaths)->mapInto(RunTestSpec::class);

        $this->batch()->add($specFileJobs);
    }
}
