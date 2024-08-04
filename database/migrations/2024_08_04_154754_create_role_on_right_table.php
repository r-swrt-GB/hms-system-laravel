<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {HEAD:
    }database/migrations/2024_08_04_120203_create_user_role_table.php
        Schema::create('user_role', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); // Foreign key for users
            $table->unsignedBigInteger('role_id'); // Foreign key for roles

            // Composite primary key
            $table->primary(['user_id', 'role_id']);

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
========
        Schema::create('role_on_right', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('right_id');

>>>>>>>> c68d0f7471c6400992be2636de416407f0671ed2:database/migrations/2024_08_04_154754_create_role_on_right_table.php
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('right_id')->references('id')->on('rights')->onDelete('cascade');

<<<<<<<< HEAD:database/migrations/2024_08_04_120203_create_user_role_table.php
            $table->timestamps(); // Created at and updated at timestamps
========
            $table->unique(['role_id', 'right_id']);
>>>>>>>> c68d0f7471c6400992be2636de416407f0671ed2:database/migrations/2024_08_04_154754_create_role_on_right_table.php
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_on_right');
    }
}
