<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Schedules;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(5)->create();
        User::factory()->create([
            'name' => 'Prof Test',
            'email' => 'lecturer@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role' => 'Lecturer'
        ]);

        User::factory()->create([
            'name' => 'mirul',
            'email' => 'student@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role' => 'Student'
        ]);
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role' => 'Admin'
        ]);

        User::factory()->create([
            'name' => 'Prof Test 2',
            'email' => 'lecturer2@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role' => 'Lecturer'
        ]);
        User::factory(49)->create([
            'role' => 'Student'
        ]);



        User::factory(8)->create([
            'role' => 'Lecturer'
        ]);

        Course::create([
            'course_code' => "WIX1001",
            'course_name' => "Computing Maths",
            'occ' => "1",
            'lecturer' => "Prof Test",
            'lecturer_id' => "1",
            'type' => 'Lecture',
            'time_start' => "0900",
            'time_end' => "1000",
            'day' => "Monday",
            'semester' => '1',
            'session' => '2022/2023'
        ]);

        Course::create([
            'course_code' => "WIX1001",
            'course_name' => "Computing Maths",
            'occ' => "2",
            'lecturer' => "Prof Test 2",
            'lecturer_id' => "2",
            'type' => 'Tutorial',
            'time_start' => "0900",
            'time_end' => "1000",
            'day' => "Tuesday",
            'semester' => '1',
            'session' => '2022/2023'
        ]);

        Course::create([
            'course_code' => "WIX1002",
            'course_name' => "Computer System Organization",
            'occ' => "3",
            'lecturer' => "Prof Test",
            'lecturer_id' => "1",
            'type' => 'Lab',
            'time_start' => "1100",
            'time_end' => "1200",
            'day' => "Wednesday",
            'semester' => '1',
            'session' => '2022/2023'
        ]);

        Schedules::create([

            'course_id' => "1",
            'user_id' => "1",
            'user_role' => "Lecturer"

        ]);

        Schedules::create([

            'course_id' => "1",
            'user_id' => "2",
            'user_role' => "Student"

        ]);
        Schedules::create([

            'course_id' => "3",
            'user_id' => "1",
            'user_role' => "Lecturer"

        ]);
        Schedules::create([
            'course_id' => "2",
            'user_id' => "4",
            'user_role' => "Lecturer"

        ]);

        Admin::create([
            'session' => '2022/2023',
            'semester' => '1',
            'first_week' => 'Week 25, 2023',
            'final_week' => 'Week 40,2023',
            'maxWeek' => '16'
        ]);

        $studentIds = User::where('role', 'Student')->pluck('id');
        $Time = ['0800', '0900', '1000', '1100', '1200', '1300', '1400', '1500', '1600', '1700', '1800', '1900', '2000', '2100'];
        $Day = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $Type = ['Lecture', 'Tutorial', 'Lab'];
        $lecturerIds = User::where('role', 'Lecturer')->pluck('id');
        for ($i = 1; $i <= 12; $i++) {
            $excludedIds = ["1", "4"];
            $courseCode = 'TEST' . str_pad($i, 4, '0', STR_PAD_LEFT);
            $courseName = 'Test Course ' . $i;
            $lecturerId = $lecturerIds->except($excludedIds)->random();
            $lecturerName = User::find($lecturerId)->name;
            $courseType = $Type[$i % count($Type)]; // Cycle through the types
            $timeStart = $Time[($i - 1) % count($Time)]; // Cycle through the times
            $timeEnd = $Time[$i % count($Time)]; // Cycle through the times
            $day = $Day[$i % count($Day)]; // Cycle through the days

            // Create the course record in the database
            Course::create([
                'course_code' => $courseCode,
                'course_name' => $courseName,
                'lecturer_id' => $lecturerId,
                'lecturer' => $lecturerName,
                'type' => $courseType,
                'time_start' => $timeStart,
                'time_end' => $timeEnd,
                'day' => $day,
                'occ' => rand(1, 5),
                'semester' => 1,
                'session' => '2022/2023',
            ]);
        }




        $courseIds = Course::pluck('id');
        $count = 0;
        while ($count < 10) {
            $excludedIds = ["1", "4"];
            $userId = $lecturerIds->except($excludedIds)->random();
            $courseId = $courseIds->random();

            // Check if the pair already exists in the schedules table
            $existingSchedule = Schedules::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->exists();

            // If the pair doesn't exist, create a new schedule
            if (!$existingSchedule) {
                Schedules::create([
                    'user_id' => $userId,
                    'course_id' => $courseId,
                    'user_role' => 'Lecturer'
                ]);

                $count++;
            }
        }
        $count = 0;
        while ($count < 96) {
            $excludedIds = ["2"];
            $userId = $studentIds->except($excludedIds)->random();
            $courseId = $courseIds->random();

            // Check if the pair already exists in the schedules table
            $existingSchedule = Schedules::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->exists();

            // If the pair doesn't exist, create a new schedule
            if (!$existingSchedule) {
                Schedules::create([
                    'user_id' => $userId,
                    'course_id' => $courseId,
                    'user_role' => 'Student'
                ]);

                $count++;
            }
        }
    }
}
