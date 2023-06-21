@extends('layout')

@section('content')
    @php
        $time = ['0800', '0900', '1000', '1100', '1200', '1300', '1400', '1500', '1600', '1700', '1800', '1900', '2000'];
        $day = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $timetable = [
            '0800' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
            '0900' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
            '1000' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
            '1100' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
            '1200' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
            '1300' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
            '1400' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
            '1500' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
            '1600' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
            '1700' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
            '1800' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
            '1900' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
            '2000' => [
                'Monday' => '',
                'Tuesday' => '',
                'Wednesday' => '',
                'Thursday' => '',
                'Friday' => '',
                'Saturday' => '',
                'Sunday' => '',
            ],
        ];
        $courseArray = DB::table('schedules')
            ->where('user_id', $user_id)
            ->get();
        //dd($courseArray);
        for ($i = 0; $i < count($courseArray); $i++) {
            $course = DB::table('courses')
                ->where('id', $courseArray[$i]->course_id)
                ->get();
            //dd($course);
            if ($course->isNotEmpty()) {
                //dd($course);
                //echo $i;
                $dayNow = $course[0]->day;
                $timeNow = $course[0]->time_start;
                $course_name = $course[0]->course_name;
                $duration = $course[0]->time_end - $timeNow;
                $occ = $course[0]->occ;
                $type = $course[0]->type;
                //dd($duration);
                //dd($duration);
                //echo $timeNow;
                if ($duration > 100) {
                    $timetable[$timeNow][$dayNow] = $course_name . ' Occ: ' . $occ . ' Type: ' . $type;
                    for ($i = 100; $i <= $duration - 1; $i += 100) {
                        //echo $i;
                        $timetable[$timeNow + $i][$dayNow] = $course_name . ' Occ: ' . $occ . ' Type: ' . $type;
                    }
                } else {
                    $timetable[$timeNow][$dayNow] = $course_name . ' Occ: ' . $occ . ' Type: ' . $type;
                    //echo $timetable[$timeNow][$dayNow];
                }
            }
        }
    @endphp
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Time/Day
                    </th>
                    @for ($i = 0; $i < count($day); $i++)
                        <th scope="col" class="px-6 py-3">
                            {{ $day[$i] }}
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($time); $i++)
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap">
                            {{ $time[$i] }}
                        </th>
                        <td class="px-6 py-4 text-left">
                            {{-- @for ($i = 0; $i < 7; $i++)
                            @endfor --}}
                            {{ $timetable[$time[$i]][$day[0]] }}
                        </td>
                        <td class="px-6 py-4 text-left">
                            {{-- @for ($i = 0; $i < 7; $i++)
                            @endfor --}}
                            {{ $timetable[$time[$i]][$day[1]] }}
                        </td>
                        <td class="px-6 py-4 text-left">
                            {{-- @for ($i = 0; $i < 7; $i++)
                            @endfor --}}
                            {{ $timetable[$time[$i]][$day[2]] }}
                        </td>
                        <td class="px-6 py-4 text-left">
                            {{-- @for ($i = 0; $i < 7; $i++)
                            @endfor --}}
                            {{ $timetable[$time[$i]][$day[3]] }}
                        </td>
                        <td class="px-6 py-4 text-left">
                            {{-- @for ($i = 0; $i < 7; $i++)
                            @endfor --}}
                            {{ $timetable[$time[$i]][$day[4]] }}
                        </td>
                        <td class="px-6 py-4 text-left">
                            {{-- @for ($i = 0; $i < 7; $i++)
                            @endfor --}}
                            {{ $timetable[$time[$i]][$day[5]] }}
                        </td>
                        <td class="px-6 py-4 text-left">
                            {{-- @for ($i = 0; $i < 7; $i++)
                            @endfor --}}
                            {{ $timetable[$time[$i]][$day[6]] }}
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
@endsection
