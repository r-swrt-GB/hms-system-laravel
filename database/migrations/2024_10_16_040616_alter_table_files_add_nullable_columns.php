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
        Schema::table('files', function (Blueprint $table) {
            $table->unsignedBigInteger('submission_id')->nullable()->change();
            $table->string('filename')->nullable()->change();
            $table->string('mimetype', 20)->nullable()->change();
            $table->string('disk', 20)->nullable()->change();

            $table->renameColumn('base_url', 'url');

            $table->dropColumn(['key', 'extension', 'size', 'thumbnail_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->unsignedBigInteger('submission_id')->nullable(false)->change();
            $table->string('filename')->nullable(false)->change();
            $table->string('mimetype', 20)->nullable(false)->change();
            $table->string('disk', 20)->nullable(false)->change();

            $table->renameColumn('url', 'base_url');

            $table->string('key', 255);
            $table->string('extension', 10);
            $table->unsignedBigInteger('size');
            $table->string('thumbnail_key', 255)->nullable();
        });
    }
};
