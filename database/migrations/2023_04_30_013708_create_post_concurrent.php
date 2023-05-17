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
        Schema::create('posts_concurrents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ad_id')->unique();
            $table->string('created_time');
            $table->text('message');
            $table->text('image_url');
            $table->string('type');
            $table->string('status');
            $table->string('page_concurrent_id');
            $table->foreign('page_concurrent_id')->references('page_concurrent_id')->on('pages_concurrents');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_concurrent');
    }
};
