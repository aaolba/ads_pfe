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
        Schema::create('insights', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('clicks');
            $table->string('frequency');
            $table->string('reach');
            $table->string('impressions');
            $table->string('spend');
            $table->string('cpm');
            $table->string('cpp');
            $table->string('ctr');
            $table->string('ad_id');
            $table->foreign('ad_id')->references('ad_id')->on('ads_posts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insight');
    }
};
