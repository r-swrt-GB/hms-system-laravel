<?php

namespace Database\Seeders;

use DB;
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
        $this->seedAssignments();
    }
    public function seedUsers(){
        DB::table('users')->insert([
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
        DB::table('modules')->insert([
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

    public function seedAssignments()
    {
        DB::table('assignments')->insert([
            [
                'module_id' => 1,
                'user_id' => 1,
                'title' => 'Introduction to Psychology: Essay',
                'description' => 'Write an essay on the impact of cognitive psychology on modern therapy.',
                'min_videos' => 0,
                'max_videos' => 2,
                'max_video_length' => 10,
                'max_grade' => 100,
                'open_date' => Carbon::now()->subDays(10),
                'due_date' => Carbon::now()->addDays(20),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id' => 2,
                'user_id' => 2,
                'title' => 'Human Anatomy: Project',
                'description' => 'Create a detailed project on the human circulatory system.',
                'min_videos' => 1,
                'max_videos' => 5,
                'max_video_length' => 20,
                'max_grade' => 100,
                'open_date' => Carbon::now()->subDays(8),
                'due_date' => Carbon::now()->addDays(22),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id' => 3,
                'user_id' => 3,
                'title' => 'Sociology Basics: Report',
                'description' => 'Submit a report on social stratification and its effects on education.',
                'min_videos' => 0,
                'max_videos' => 3,
                'max_video_length' => 15,
                'max_grade' => 100,
                'open_date' => Carbon::now()->subDays(5),
                'due_date' => Carbon::now()->addDays(25),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id' => 4,
                'user_id' => 4,
                'title' => 'Cognitive Science: Presentation',
                'description' => 'Prepare a presentation on the role of perception in cognitive processes.',
                'min_videos' => 2,
                'max_videos' => 4,
                'max_video_length' => 30,
                'max_grade' => 100,
                'open_date' => Carbon::now()->subDays(7),
                'due_date' => Carbon::now()->addDays(23),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id' => 5,
                'user_id' => 1,
                'title' => 'Developmental Psychology: Case Study',
                'description' => 'Analyze a case study on child development stages.',
                'min_videos' => 1,
                'max_videos' => 3,
                'max_video_length' => 25,
                'max_grade' => 100,
                'open_date' => Carbon::now()->subDays(9),
                'due_date' => Carbon::now()->addDays(21),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id' => 6,
                'user_id' => 2,
                'title' => 'Biological Anthropology: Research Paper',
                'description' => 'Submit a research paper on the evolutionary adaptations of humans.',
                'min_videos' => 0,
                'max_videos' => 2,
                'max_video_length' => 15,
                'max_grade' => 100,
                'open_date' => Carbon::now()->subDays(6),
                'due_date' => Carbon::now()->addDays(24),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id' => 7,
                'user_id' => 3,
                'title' => 'Social Psychology: Experiment',
                'description' => 'Conduct an experiment on group behavior and report your findings.',
                'min_videos' => 1,
                'max_videos' => 4,
                'max_video_length' => 20,
                'max_grade' => 100,
                'open_date' => Carbon::now()->subDays(10),
                'due_date' => Carbon::now()->addDays(20),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id' => 8,
                'user_id' => 4,
                'title' => 'Ethics in Human Science: Essay',
                'description' => 'Discuss the ethical considerations in human genetic research.',
                'min_videos' => 0,
                'max_videos' => 3,
                'max_video_length' => 10,
                'max_grade' => 100,
                'open_date' => Carbon::now()->subDays(8),
                'due_date' => Carbon::now()->addDays(22),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id' => 9,
                'user_id' => 1,
                'title' => 'Cultural Anthropology: Fieldwork',
                'description' => 'Complete a fieldwork project on a cultural practice and submit a report.',
                'min_videos' => 2,
                'max_videos' => 4,
                'max_video_length' => 30,
                'max_grade' => 100,
                'open_date' => Carbon::now()->subDays(5),
                'due_date' => Carbon::now()->addDays(25),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id' => 10,
                'user_id' => 2,
                'title' => 'Research Methods in Psychology: Project',
                'description' => 'Design and conduct a research project, and present your findings.',
                'min_videos' => 1,
                'max_videos' => 5,
                'max_video_length' => 25,
                'max_grade' => 100,
                'open_date' => Carbon::now()->subDays(7),
                'due_date' => Carbon::now()->addDays(23),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                ]
        ]);
    }
}
