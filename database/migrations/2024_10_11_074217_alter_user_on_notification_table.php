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
        Schema::table('user_on_notification', function (Blueprint $table) {
            $table->renameColumn('module_id', 'notification_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_on_notification', function (Blueprint $table) {
            $table->renameColumn('notification_id', 'module_id');
        });
    }
};
