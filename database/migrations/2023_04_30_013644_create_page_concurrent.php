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
        Schema::create('pages_concurrents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('page_concurrent_id')->unique();
            $table->string('page_name');
            $table->string('page_id');
            $table->text("page_image_url");
            $table->foreign('page_id')->references('page_id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_concurrent');
    }
};
