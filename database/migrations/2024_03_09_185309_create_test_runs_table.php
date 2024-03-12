<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('cypress_test_runs', function (Blueprint $table) {
            $table->id();
            $table->uuid('batchId');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cypress_test_runs');
    }
};
