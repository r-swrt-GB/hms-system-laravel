<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     * @table file
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('filename');
            $table->string('mimetype', 20);
            $table->string('extension', 10);
            $table->unsignedInteger('size');
            $table->string('disk', 20);
            $table->string('base_url', 255);
            $table->string('key', 255);
            $table->string('thumbnail_key', 255)->nullable();
            $table->string('meta_table', 100)->nullable();
            $table->string('meta_column', 100)->nullable();
            $table->string('meta_id', 40)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
}
