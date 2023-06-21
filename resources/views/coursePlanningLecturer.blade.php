@extends('layout')

@section('content')
    @php
        $userId = auth()->user()->id;
        $course_content = DB::table('course_planning')
            ->where('course_code', $course_code)
            ->where('user', $userId)
            ->orderBy('id', 'asc')
            ->get();
        $event = DB::table('events')
            ->where('key', $course_content[1]->key)
            ->first();
        //dd($event!=null && $event->event_time);
        // dd($course_content);
        //dd($course_content);
        $course = DB::table('courses')
            ->where('id', $id)
            ->first();
        //dd($course);
        $week = DB::table('admins')
            ->where('semester', $course->semester)
            ->where('session', $course->session)
            ->value('first_week');
        $length = DB::table('admins')
            ->where('semester', $course->semester)
            ->where('session', $course->session)
            ->value('maxWeek');
        preg_match('/Week (\d+)/', $week, $matches);
        $weekNumber = $matches[1];
        $year = intval(substr($week, -4));
        $date = strtotime($year . 'W' . $weekNumber . '1');
        //dd($weekNumber);
        $user = auth()->user();
        //dd($course_content);
    @endphp
    {{-- @dd($course_content) --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg max-w-6xl">
        <table class="w-full text-sm text-center text-gray-500">
            <form action="/coursePlaning/update" id="updateCoursePlanning">
                @csrf
                <input type="hidden" id="custId" name="course_code" value="{{ $course_code }}">
                <thead class="w-min text-xs text-center text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 max-w-min">
                            Week
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Content
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Event
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Event Time
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $length; $i++)
                        <tr class="bg-white border-b">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $i + 1 }}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900">
                                @php
                                    echo date('d M, Y', $date);
                                    echo ' - ';
                                    $date = strtotime('+6 day', $date);
                                    echo date('d M, Y', $date);
                                    $date = strtotime('+1 day', $date);
                                @endphp
                            </th>
                            <input type="hidden" id="user" name="user" value={{ $user }}>
                            <input type="hidden" name="key[]" value="{{ $course_code }}_week{{ $i + 1 }}">
                            <td class="px-6 py-4 ">
                                <textarea id="message" rows="4" name="content[]"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">@php
                                        if ($course_content->isNotEmpty()) {
                                            echo $course_content[$i]->content;
                                        }
                                    @endphp</textarea>

                            </td>
                            <td class="px-6 py-4">
                                <input id="eventCheckboxWeek{{ $i + 1 }}" type="checkbox" value="1"
                                    name="event[{{ $i }}]"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600"
                                    @if ($course_content->isNotEmpty() && $course_content[$i]->event !== null) checked @endif>
                            </td>

                            <td class="px-6 py-4">
                                <select id="time_dropdown_{{ $i }}" name="event_time_[{{ $i }}]"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                                    @php
                                        $event = DB::table('events')
                                            ->where('key', $course_content[$i]->key)
                                            ->first();
                                    @endphp
                                    <option value="0800"@if ($event != null && $event->event_time == '0800') selected @endif>0800
                                    </option>
                                    <option value="0900" @if ($event != null && $event->event_time == '0900') selected @endif>0900
                                    </option>
                                    <option value="1000" @if ($event != null && $event->event_time == '1000') selected @endif>1000
                                    </option>
                                    <option value="1100"@if ($event != null && $event->event_time == '1100') selected @endif>1100
                                    </option>
                                    <option value="1200"@if ($event != null && $event->event_time == '1200') selected @endif>1200
                                    </option>
                                    <option value="1300"@if ($event != null && $event->event_time == '1300') selected @endif>1300
                                    </option>
                                    <option value="1400"@if ($event != null && $event->event_time == '1400') selected @endif>1400
                                    </option>
                                    <option value="1500"@if ($event != null && $event->event_time == '1500') selected @endif>1500
                                    </option>
                                    <option value="1600"@if ($event != null && $event->event_time == '1600') selected @endif>1600
                                    </option>
                                    <option value="1700"@if ($event != null && $event->event_time == '1700') selected @endif>1700
                                    </option>
                                    <option value="1800"@if ($event != null && $event->event_time == '1800') selected @endif>1800
                                    </option>
                                    <option value="1900"@if ($event != null && $event->event_time == '1900') selected @endif>1900
                                    </option>
                                    <option value="2000"@if ($event != null && $event->event_time == '2000') selected @endif>2000
                                    </option>
                                    <option value="during_class_hour"@if ($event == null) selected @endif>
                                        During Class Hour
                                    </option>
                                </select>
                            </td>
                        </tr>
                    @endfor
                </tbody>
                <input type="hidden" name="user" value="{{ $user->id }}">
                <input type="hidden" name="course" value="{{ $course->id }}">
            </form>
        </table>

    </div>
    <div class="relative pt-5">
        <div class="absolute right-0">
            <button type="submit" form="updateCoursePlanning"
                class="text-white bg-blue-950 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update
                Course Planning</button>
        </div>
    </div>
@endsection
