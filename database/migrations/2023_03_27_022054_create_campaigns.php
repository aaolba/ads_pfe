<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('campaign_id')->unique();
            $table->string('name');
            $table->string('start_time');
            $table->string('stop_time');
            $table->string('status');
            $table->string('objective');
            $table->string('page_id');
            $table->foreign('page_id')->references('page_id')->on('pages');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camaigns');
    }
};
