<?php

namespace Astrogoat\Cypress\Modals;

use Helix\Lego\Http\Livewire\Modal;
use Astrogoat\Cypress\Models\TestRun as TestRunModel;

class Run extends Modal
{
    public $run;

    public function mount(TestRunModel $run)
    {
        $this->run = $run;
    }

    public function getGroupedTests()
    {
        return $this->run->tests->groupBy('spec_file')->all();
    }

    public function render()
    {
        return view('cypress::modals.run');
    }
}
