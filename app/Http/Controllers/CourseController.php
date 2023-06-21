<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Events;
use App\Models\Schedules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Exists;

class CourseController extends Controller
{
    //

    public function show(Course $course)
    {
        return view(
            'show',
            [
                'course' => $course
            ]
        );
    }

    public function addL()
    {
        return view('addCourseLecturer');
    }

    public function addS()
    {
        return view(
            'addCourseStudent',
            ['course' => Course::all()]
        );
    }
    public function planL($id)
    {
        $course_code = DB::table('courses')->where('id', $id)->value('course_code');
        return view('coursePlanningLecturer', [
            'course_code' => $course_code,
            'id' => $id
        ]);
        //$course = DB::table('courses')->where('course_code', $course_code)->get();
        //dd($course);
    }

    public function planS($id)
    {
        $course_code = DB::table('courses')->where('id', $id)->value('course_code');
        return view('coursePlanningStudent', [
            'course_code' => $course_code,
            'id' => $id
        ]);
        //$course = DB::table('courses')->where('course_code', $course_code)->get();
        //dd($course);
    }

    public function schedule($id)
    {
        $course_code = DB::table('courses')->where('id', $id)->value('course_code');
        return view('gap', [
            'course_code' => $course_code,
            'id' => $id
        ]);
    }
    public function timetable($user_id)
    {
        return view(
            'timetable',
            ['user_id' => $user_id]
        );
    }
    public function add(Request $request)
    {
        //dd($request->all());
        $exists = DB::table('courses')->where('course_code', $request->course_code)->where('occ', $request->occ)->exists();
        $courses = DB::table('courses')->where('course_code', $request->course_code)->where('occ', $request->occ)->first();
        //$courses = DB::table('courses')->pluck('course_code');
        // dd($courses);
        if ($exists) {
            $course_id = $courses->id;
            $student_id = auth()->id();
            $exists2 = DB::table('schedules')->where('course_id', $course_id)->where('user_id', $student_id)->exists();
            if ($exists2) {
                Session::flash('error_code', 2);
                return back();
            } else {
                Schedules::create([
                    'course_id' => $course_id,
                    'user_id' => $student_id,
                    'user_role' => $request->role
                ]);
                return redirect('/')->with('successAdd', 'Course added successfully.');
            }
        } else {
            Session::flash('error_code', 1);
            return back();
        }
    }

    public function create(Request $request)
    {
        $courseExist = DB::table('courses')->where('course_code', $request->course_code)->where('occ', $request->occ)->where('type', $request->type)->exists();
        $session = $request->session;
        $semester = $request->semester;
        $exists = DB::table('admins')
            ->where('session', $session)
            ->where('semester', $semester)
            ->exists();
        //dd($request->all());
        $valid = ($request->time_end - $request->time_start);
        if ($exists && !$courseExist) {
            if ($valid < 0) {
                return back()->with('failedAdd', 'Starting time must be earlier than ending time');
            } else {
                //dd($valid);
                $course = $request->all();
                $course['user_id'] = auth()->id();
                $created = Course::create($course);
                //dd($created);
                //dd(auth());
                Schedules::create(
                    [
                        'course_id' => $created->id,
                        'user_id' => auth()->id(),
                        'user_role' => 'Lecturer'
                    ]
                );
                return redirect('/')->with('successAdd', 'Course added successfully.');
            }
        } elseif (!$exists) {
            return back()->with('failedAdd', 'Session/Semester does not valid.');
        } elseif ($courseExist) {
            return back()->with('failedAdd', 'Course already exists.');
        }
    }

    public function destroy(Course $course)
    {
        //dd($course->id);
        $role = DB::table('users')->where('id', auth()->id())->value('role');
        //dd($role);
        if ($role === 'Lecturer') {
            $course->delete();
        } else {
            DB::table('schedules')->where('course_id', $course->id)->where('user_id', auth()->id())->delete();
        }
        return redirect('/')->with('successDelete', 'Course deleted successfully.');
    }

    public function update(Request $request)
    {
        //dd($request->all());

        for ($x = 0; $x < count($request->key); $x++) {
            DB::table('course_planning')->upsert(
                [
                    ['course_code' => $request->course_code, 'key' => $request->key[$x], 'content' => $request->content[$x], 'user' => $request->user]
                ],
                ['key'],
                ['content']
            );
            $exists = DB::table('events')->where('key', $request->key[$x])->exists();

            //dd($request->all());
            if (isset($request->event[$x])) {
                $weeks = $x;
                $course = DB::table('courses')
                    ->where('id', $request->course)
                    ->first();
                $course_time = $course->time_start;
                $eventTime = null;
                if ($request->event_time_[$x] !== 'during_class_hour') {
                    $eventTime = $request->event_time_[$x]; // Set event time if it's not "During Class Hour"
                } else {
                    $eventTime = $course_time;
                }
                if (!$exists) {
                    //dd($request->all());
                    $day = DB::table('courses')
                        ->where('id', $request->course)
                        ->value('day');
                    $week = DB::table('admins')
                        ->where('semester', $course->semester)
                        ->where('session', $course->session)
                        ->value('first_week');

                    preg_match('/Week (\d+)/', $week, $matches);
                    $weekNumber = (int) $matches[1] + (int) $weeks;
                    $year = intval(substr($week, -4));
                    $week = "Week " . $weekNumber . ", " . $year;
                    $monday = strtotime($year . 'W' . $weekNumber);
                    //dd(date('d-m-Y', $monday));
                    $daysToAdd = array_search(ucfirst($day), array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'));
                    $date = date(strtotime('+' . $daysToAdd . ' days', $monday));
                    $date = date('Y-m-d', $date);
                    //dd($date);
                    // Save the event data into the "Events" table
                    //dd($x);
                    Events::create([
                        'course_code' => $request->course_code,
                        'week' => $week,
                        'course_id' => $request->course,
                        'date' => $date,
                        'key' => $request->key[$x],
                        'lecturer_id' => $request->user,
                        'event_time' => $eventTime
                    ]);
                    DB::table('course_planning')->where('key', $request->key[$x])->update([
                        'event' => "1"
                    ]);
                } else {
                    DB::table('events')->where('key', $request->key[$x])->update([
                        'event_time' => $eventTime
                    ]);
                }
            } else {
                $exists = DB::table('events')->where('key', $request->key[$x])->exists();
                if ($exists) {
                    DB::table('events')->where('key', $request->key[$x])->delete();
                    DB::table('course_planning')->where('key', $request->key[$x])->update([
                        'event' => null
                    ]);
                }
            }
        }
        return redirect('/')->with('successAdd', 'Course planning added successfully.');
    }
}
