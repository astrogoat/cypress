<?php

namespace Astrogoat\Cypress\Peripherals;

use Astrogoat\Cypress\Models\TestRun;
use Illuminate\Database\Eloquent\Collection;
use Helix\Lego\Settings\Peripherals\Peripheral;

class Runs extends Peripheral
{
    public Collection $runs;

    public function getListeners()
    {
        return [
            'echo:astrogoat.cypress,.tests.finished' => 'refresh',
        ];
    }

    public function mount()
    {
        $this->runs = TestRun::with('tests')->orderByDesc('created_at')->limit(5)->get();
    }

    public function refresh()
    {
        $this->runs = TestRun::with('tests')->orderByDesc('created_at')->limit(5)->get();
    }

    public function render()
    {
        return view('cypress::peripherals.runs');
    }
}
