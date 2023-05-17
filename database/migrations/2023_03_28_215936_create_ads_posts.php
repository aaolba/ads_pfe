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
        Schema::create('ads_posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ad_id')->unique();
            $table->string('post_id');
            $table->string('created_time');
            $table->text('message');
            $table->text('image_url');
            $table->string('type');
            $table->string('status');
            $table->string('campaign_id');
            $table->foreign('campaign_id')->references('campaign_id')->on('campaigns');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads_posts');
    }
};
