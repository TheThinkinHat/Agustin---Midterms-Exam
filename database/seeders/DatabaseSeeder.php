<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('courses')->insertOrIgnore([
            ['course_id' => 1, 'course_name' => 'BS Information  Technology'],
            ['course_id' => 2, 'course_name' => 'BS Computer Science'],
            ['course_id' => 3, 'course_name' => 'BS Information System'],
        ]);

        DB::table('students')->insertOrIgnore([
            ['student_id' => 21, 'first_name' => 'Justine Karl', 'last_name' => 'Agustin', 'email' => 'justinekarlagustin@gmail.com', 'year_level' => 2, 'course_id' => 1, 'created_at' => '2026-05-21 06:15:30'],
            ['student_id' => 23, 'first_name' => 'Angela', 'last_name' => 'Morales', 'email' => 'morales@gmail.com', 'year_level' => 1, 'course_id' => 2, 'created_at' => '2026-05-21 06:15:30'],
            ['student_id' => 24, 'first_name' => 'Juan', 'last_name' => 'Dela Cruz', 'email' => 'juan@gmail.com', 'year_level' => 4, 'course_id' => 3, 'created_at' => '2026-05-21 06:25:26'],
        ]);

        DB::table('users')->insertOrIgnore([
            ['user_id' => 2, 'username' => 'Justine', 'password' => '$2y$10$7XtYlUcly4rJzXClN8BHB.vG5delj3DhBaAAIWrakBquzyndtdFsu'],
            ['user_id' => 3, 'username' => 'JohnDoe123', 'password' => '$2y$10$qlE.6ALXnttlTRDaVjPRDO3EFp0YqSZ7o5n36r75ycWrLUTqiHpCW'],
            ['user_id' => 4, 'username' => 'JohnDoe123`', 'password' => '$2y$10$hzrEz69MkX5KLoFe9TUMqOWJfVgAbI.5hcvc5r93GRCqinFWLzY8.'],
        ]);
    }
}
