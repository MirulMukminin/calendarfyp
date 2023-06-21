@extends('layout')

@php
    $Time = ['0800', '0900', '1000', '1100', '1200', '1300', '1400', '1500', '1600', '1700', '1800', '1900', '2000', '2100'];
    $Day = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $timetable = [
        '0800' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '0900' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '1000' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '1100' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '1200' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '1300' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '1400' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '1500' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '1600' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '1700' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '1800' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '1900' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '2000' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
        '2100' => [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0,
        ],
    ];
    $courseId = $id;
    $userID = auth()->user()->id;
    
    $userIds = DB::table('schedules')
        ->where('course_id', $courseId)
        ->where('user_role', 'Student')
        ->pluck('user_id')
        ->toArray();
    
    array_push($userIds, (string) $userID);
    $coursesTaken = DB::table('schedules')
        ->join('courses', 'schedules.course_id', '=', 'courses.id')
        ->whereIn('schedules.user_id', $userIds)
        ->get();
    
    $courseArray = $coursesTaken->pluck('id')->toArray();
    
    $courseCounts = DB::table('schedules')
        ->whereIn('course_id', $courseArray)
        ->select('course_id', DB::raw('count(*) as student_count'))
        ->groupBy('course_id')
        ->get();
    
    foreach ($courseCounts as $courseCount) {
        $courseId = $courseCount->course_id;
        $studentCount = $courseCount->student_count;
    
        $courseDetails = $coursesTaken->where('course_id', $courseId)->first();
    
        // Access the time_start, time_end, and day columns
        $timeStart = $courseDetails->time_start;
        $timeEnd = $courseDetails->time_end;
        $occ = $courseDetails->occ;
        $type = $courseDetails->type;
        $day = $courseDetails->day;
        $course_name = $courseDetails->course_name;
        $duration = (int) $timeEnd - (int) $timeStart;
    
        if ($duration > 100) {
            $timetable[$timeStart][$day] += $studentCount;
            for ($i = 100; $i <= $duration - 1; $i += 100) {
                $timetable[$timeStart + $i][$day] += $studentCount;
            }
        } else {
            $timetable[$timeStart][$day] += $studentCount;
            //echo $timetable[$timeNow][$dayNow];
        }
    }
    //dd($timetable);
@endphp

@section('content')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Time/Day
                    </th>
                    @for ($i = 0; $i < count($Day); $i++)
                        <th scope="col" class="px-6 py-3">
                            {{ $Day[$i] }}
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($Time); $i++)
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap">
                            {{ $Time[$i] }}
                        </th>
                        <td class="px-6 py-4 text-left">
                            @php
                                if ($timetable[$Time[$i]][$Day[0]] != 0) {
                                    echo $timetable[$Time[$i]][$Day[0]] . ' participant(s) have class(es).';
                                }
                            @endphp

                        </td>
                        <td class="px-6 py-4 text-left">
                            @php
                                if ($timetable[$Time[$i]][$Day[1]] != 0) {
                                    echo $timetable[$Time[$i]][$Day[1]] . ' participant(s) have class(es).';
                                }
                            @endphp

                        </td>
                        <td class="px-6 py-4 text-left">
                            @php
                                if ($timetable[$Time[$i]][$Day[2]] != 0) {
                                    echo $timetable[$Time[$i]][$Day[2]] . ' participant(s) have class(es).';
                                }
                            @endphp

                        </td>
                        <td class="px-6 py-4 text-left">
                            @php
                                if ($timetable[$Time[$i]][$Day[3]] != 0) {
                                    echo $timetable[$Time[$i]][$Day[3]] . ' participant(s) have class(es).';
                                }
                            @endphp

                        </td>
                        <td class="px-6 py-4 text-left">
                            @php
                                if ($timetable[$Time[$i]][$Day[4]] != 0) {
                                    echo $timetable[$Time[$i]][$Day[4]] . ' participant(s) have class(es).';
                                }
                            @endphp

                        </td>
                        <td class="px-6 py-4 text-left">
                            @php
                                if ($timetable[$Time[$i]][$Day[5]] != 0) {
                                    echo $timetable[$Time[$i]][$Day[5]] . ' participant(s) have class(es).';
                                }
                            @endphp

                        </td>
                        <td class="px-6 py-4 text-left">
                            @php
                                if ($timetable[$Time[$i]][$Day[6]] != 0) {
                                    echo $timetable[$Time[$i]][$Day[6]] . ' participant(s) have class(es).';
                                }
                            @endphp

                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
@endsection
