<?php

namespace Astrogoat\Cypress\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $guarded = [];

    protected $table = 'cypress_test_results';

    public function scopePassed(Builder $query): void
    {
        $query->where('status', 'pass');
    }

    public function scopeFailed(Builder $query): void
    {
        $query->where('status', 'fail');
    }

    public function passed(): bool
    {
        return $this->status === 'pass';
    }

    public function failed(): bool
    {
        return $this->status === 'fail';
    }
}
