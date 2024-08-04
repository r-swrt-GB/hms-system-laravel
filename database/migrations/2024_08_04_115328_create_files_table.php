<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id(); // Primary key 'id'
            $table->unsignedBigInteger('submission_id'); // Foreign key for submissions
            $table->string('filename'); // Name of the file
            $table->string('mimetype', 20); // MIME type of the file
            $table->string('extension',10); // File extension
            $table->unsignedBigInteger('size'); // Size of the file in bytes
            $table->string('disk',20); // Disk storage (e.g., local, s3)
            $table->string('base_url'); // Base URL for the file
            $table->string('key',255); // Key for the file (if using a cloud storage)
            $table->string('thumbnail_key',255)->nullable(); // Key for the thumbnail (nullable)

            // Foreign key constraint
            $table->foreign('submission_id')->references('id')->on('submissions')->onDelete('cascade');

            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
