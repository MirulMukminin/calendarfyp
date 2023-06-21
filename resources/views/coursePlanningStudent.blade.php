@extends('layout')

@section('content')
    @php
        $lecturer = DB::table('courses')
            ->where('course_code', $course_code)
            ->where('id', $id)
            ->value('lecturer_id');
        $course_content = DB::table('course_planning')
            ->where('course_code', $course_code)
            ->where('user', $lecturer)
            ->orderBy('id', 'asc')
            ->get();
        //dd($course_content);
        $course = DB::table('courses')
            ->where('id', $id)
            ->first();
        $week = DB::table('admins')
            ->where('semester', $course->semester)
            ->where('session', $course->session)
            ->value('first_week');
        $length = DB::table('admins')
            ->where('semester', $course->semester)
            ->where('session', $course->session)
            ->value('maxWeek');
        //
        preg_match('/Week (\d+)/', $week, $matches);
        $weekNumber = $matches[1];
        $year = intval(substr($week, -4));
        $date = strtotime($year . 'W' . $weekNumber . '1');
        //dd($lecturer);
    @endphp
    <div class="relative overflow-x-auto shadow-md">
        <table class="w-full text-sm text-left text-gray-500 w-full">
            <thead class="grid-cols-3 text-xs text-center text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 col-span-1 ">
                        Week
                    </th>
                    <th scope="col" class="px-2 py-3 col-span-1">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 col-span-6 ">
                        Content
                    </th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < $length; $i++)
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap">
                            {{ $i + 1 }}
                        </th>
                        <th scope="row" class="px-10 py-4 font-medium text-gray-900 text-center">
                            @php
                                echo date('d M, Y', $date);
                                echo ' - ';
                                $date = strtotime('+6 day', $date);
                                echo date('d M, Y', $date);
                                $date = strtotime('+1 day', $date);
                            @endphp
                        </th>
                        <td class="px-6 py-4 text-left">
                            @php
                                if ($course_content->isNotEmpty()) {
                                    echo $course_content[$i]->content;
                                }
                            @endphp
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>

    </div>
@endsection
