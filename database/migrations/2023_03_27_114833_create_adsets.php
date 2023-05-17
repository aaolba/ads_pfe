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
        Schema::create('adsets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('adset_id')->unique();
            $table->string('name');
            $table->string('status');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('campaign_id');
            $table->foreign('campaign_id')->references('campaign_id')->on('campaigns');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adsets');
    }
};
