<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedUsers();
        $this->seedModules();
    }
    public function seedUsers(){
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

    public function seedModules()
    {
        \DB::table('modules')->insert([
            [
                'module_name' => 'Introduction to Psychology',
                'code' => 'PSY101',
                'description' => 'This module provides an overview of psychological principles and theories.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Human Anatomy',
                'code' => 'BIO201',
                'description' => 'Detailed study of human anatomy with a focus on bodily systems.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Sociology Basics',
                'code' => 'SOC101',
                'description' => 'Introduction to the study of society, social relationships, and social institutions.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Cognitive Science',
                'code' => 'COG301',
                'description' => 'Exploration of the mind and its processes, including perception, thinking, and learning.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Developmental Psychology',
                'code' => 'PSY202',
                'description' => 'Study of human development from infancy through adulthood.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Biological Anthropology',
                'code' => 'ANTH301',
                'description' => 'Examination of the biological and evolutionary aspects of humans.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Social Psychology',
                'code' => 'PSY303',
                'description' => 'Study of how individuals affect and are affected by others in a social context.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Ethics in Human Science',
                'code' => 'ETH101',
                'description' => 'Introduction to ethical issues and dilemmas in the field of human science.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Cultural Anthropology',
                'code' => 'ANTH102',
                'description' => 'Study of cultural variation among humans, with a focus on cultural norms, values, and practices.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Research Methods in Psychology',
                'code' => 'PSY304',
                'description' => 'Overview of research methodologies and techniques used in psychological research.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }
}
