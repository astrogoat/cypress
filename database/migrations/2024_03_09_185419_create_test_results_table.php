<?php

use Illuminate\Support\Facades\Schema;
use Astrogoat\Cypress\Models\TestRun;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('cypress_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TestRun::class)->constrained('cypress_test_runs')->cascadeOnDelete();
            $table->string('title');
            $table->string('status');
            $table->string('spec_file');
            $table->longText('error')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cypress_test_results');
    }
};
