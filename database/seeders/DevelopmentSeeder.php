<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            [
                'first_name' => 'Theunis',
                'last_name' => 'Kok',
                'email' => 'theunisjkok12@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Admin123'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Rikus',
                'last_name' => 'Swart',
                'email' => 'rikusswart101@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Admin123'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Ruan',
                'last_name' => 'van Heerden',
                'email' => 'ruanv621@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Admin123'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Henk',
                'last_name' => 'Mooiman',
                'email' => 'hendrikwillemmooiman@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Admin123'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
