<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Schedules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;

class AdminController extends Controller
{
    public function index($section = 'dashboard')
    {
        $students = DB::table('users')->select('*')->where('role', 'Student')->get();
        //dd($students);
        $admins = DB::table('admins')->select('*')->get();
        $lecturers = DB::table('users')->select('*')->where('role', 'Lecturer')->get();
        $courses = DB::table('courses')->select('*')->get();
        $events = DB::table('events')->select('*')->get();
        $courseStudents = DB::table('courses')
            ->leftJoin('schedules', function ($join) {
                $join->on('courses.id', '=', 'schedules.course_id')
                    ->where('schedules.user_role', 'Student');
            })
            ->select('courses.id', 'courses.course_code', 'courses.occ', DB::raw('COUNT(schedules.user_id) AS student_count'))
            ->groupBy('courses.id', 'courses.course_code', 'courses.occ')
            ->get();
        if ($section === 'Vstudents') {
            return view('admin', ['section' => 'Vstudents', 'students' => $students]);
        } elseif ($section === 'Mstudents') {
            return view('admin', ['section' => 'Mstudents', 'students' => $students]);
        } elseif ($section === 'Vlecturers') {
            return view('admin', ['section' => 'Vlecturers', 'lecturers' => $lecturers]);
        } elseif ($section === 'Mlecturers') {
            return view('admin', ['section' => 'Mlecturers', 'lecturers' => $lecturers]);
        } elseif ($section === 'Vcourses') {
            return view('admin', ['section' => 'Vcourses', 'courses' => $courses]);
        } elseif ($section === 'Mcourses') {
            return view('admin', ['section' => 'Mcourses', 'courses' => $courses]);
        } elseif ($section === 'Vevents') {
            return view('admin', ['section' => 'Vevents', 'events' => $events]);
        } elseif ($section === 'Mevents') {
            return view('admin', ['section' => 'Mevents', 'events' => $events]);
        }
        // Default section or error handling
        return view('admin', ['section' => 'dashboard', 'admins' => $admins]);
    }

    public function updateUser(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $userExists = DB::table('users')->where('id', $id)->exists();
        $currentDateTime = Carbon::now();
        if ($userExists) {
            DB::table('users')->where('id', $id)->update(['name' => $name, 'email' => $email]);
            DB::table('users')->where('id', $id)->update(['updated_at' => $currentDateTime]);
            return redirect()->back()->with('successUpdate', 'User updated successfully');
        } else {
            return redirect()->back()->with('failedUpdate', 'User failed to update');
        }
    }

    public function deleteUser($id)
    {
        $userExists = DB::table('users')->where('id', $id)->exists();

        if ($userExists) {
            DB::table('users')->where('id', $id)->delete();
            return redirect()->back()->with('successDelete', 'User deleted successfully');
        } else {
            return redirect()->back()->with('failedDelete', 'User does not exists');
        }
    }

    public function updateCourse(Request $request)
    {
        //dd($request->all());
        $id = $request->id;
        $course_code = $request->course_code;
        $course_name = $request->course_name;
        $occ = $request->occ;
        $lecturer = $request->lecturer;
        $type = $request->type;
        $time_start = $request->time_start;
        $time_end = $request->time_end;
        $day = $request->day;
        $currentDateTime = Carbon::now();
        $courseExist = DB::table('courses')->where('id', $id)->exists();
        if ($courseExist) {
            DB::table('courses')
                ->where('id', $id)
                ->update([
                    'course_code' => $course_code,
                    'course_name' => $course_name,
                    'occ' => $occ,
                    'lecturer' => $lecturer,
                    'type' => $type,
                    'time_start' => $time_start,
                    'time_end' => $time_end,
                    'day' => $day,
                    'semester' => $request->semester,
                    'session' => $request->session
                ]);
            DB::table('courses')->where('id', $id)->update(['updated_at' => $currentDateTime]);
            return redirect()->back()->with('successUpdate', 'Course updated successfully.');
        } else {
            return redirect()->back()->with('failedUpdate', 'Course failed to update');
        }
    }

    public function searchUser(Request $request)
    {
        $query = $request->input('query');

        // Perform the search logic using the $query parameter

        $users = User::where('name', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->where('role', 'student')
            ->get();
        return view('admin', ['section' => 'searchUser', 'users' => $users, 'query' => $query]);
    }

    public function searchCourse(Request $request)
    {
        $query = $request->input('query');

        // Perform the search logic using the $query parameter

        $courses = Course::where('course_code', 'like', '%' . $query . '%')
            ->orWhere('course_name', 'like', '%' . $query . '%')
            ->orWhere('lecturer', 'like', '%' . $query . '%')
            ->get();
        dd($courses);
        return view('admin', ['section' => 'searchCourses', 'courses' => $courses, 'query' => $query]);
        // Return the search results or perform any other desired actions
    }

    public function create(Request $request)
    {
        $admins = DB::table('admins')->select('*')->get();
        $request->validate([
            'week' => 'required',
        ]);

        if ($request->filled('week')) {
            $firstWeek = $request->week;
            $maxWeek = (int) $request->maxWeeks;
            $pattern = '/Week (\d+)/';
            $matches = [];
            preg_match($pattern, $firstWeek, $matches);
            $weekNumber = $matches[1];

            $finalWeekNumber = $weekNumber + $maxWeek - 1;
            $finalWeek = "Week " . $finalWeekNumber . ", 2023";

            DB::table('admins')->insert([
                'semester' => $request->semester,
                'session' => $request->session,
                'first_week' => $firstWeek,
                'final_week' => $finalWeek,
                'maxWeek' => $maxWeek
            ]);
            return redirect('/admin')->with('successUpdate', 'Semester added successfully.');
        } else {
            return redirect()->back()->with(['failedUpdate' => 'Semester failed to be added']);
        }
    }


    public function destroy($id)
    {
        $userExists = DB::table('admins')->where('id', $id)->exists();

        if ($userExists) {
            DB::table('admins')->where('id', $id)->delete();
            return redirect()->back()->with('successDelete', 'Semester deleted successfully');
        } else {
            return redirect()->back()->with('failedDelete', 'Semester does not exists');
        }
    }
}
