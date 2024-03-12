<?php

namespace Astrogoat\Cypress\Enums;

use Helix\Lego\Http\Livewire\BatchJobs\Contracts\HasBatchableSteps;

enum RunSteps: string implements HasBatchableSteps
{
    case TESTING = 'Testing';
    case FINISHED = 'Finished';

    public static function order(): array
    {
        return [
            RunSteps::TESTING,
            RunSteps::FINISHED,
        ];
    }

    public function description(): string
    {
        return match ($this) {
            self::TESTING => 'Running tests...',
            self::FINISHED => 'All done!',
        };
    }
}
