<?php

namespace Astrogoat\Cypress\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 */
class TestRun extends Model
{
    use Prunable;

    protected $guarded = [];

    protected $table = 'cypress_test_runs';

    public function tests(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    public function allHasPassed(): bool
    {
        return $this->tests()->failed()->count() === 0;
    }

    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subMonth());
    }
}
