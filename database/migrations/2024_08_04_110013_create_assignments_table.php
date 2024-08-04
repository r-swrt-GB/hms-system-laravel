<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->integer('min_videos')->default(0);
            $table->integer('max_videos')->default(0);
            $table->integer('max_video_length')->default(0);
            $table->integer('max_grade')->default(0);
            $table->dateTime('open_date')->nullable();
            $table->dateTime('due_date')->nullable();

            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
