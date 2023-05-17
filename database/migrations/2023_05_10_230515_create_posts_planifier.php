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
        Schema::create('posts_planifier', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('planification_time');
            $table->text('message');
            $table->text("image_path");
            $table->string('page_id');
            $table->foreign('page_id')->references('page_id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_planifier');
    }
};
