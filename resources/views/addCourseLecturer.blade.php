@extends('layout')

@section('content')
    @php
        use App\Models\User;
        $user = auth()->user();
        $courses = $user->courses;
        $session = DB::table('admins')
            ->distinct('session')
            ->pluck('session');
        //dd($user->name);
    @endphp
    @if (session('failedAdd'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 relative"
            role="alert">
            <span class="font-medium">{{ session('failedAdd') }}</span>
            <button class="absolute center right-6 text-gray-500 hover:text-gray-800"
                onclick="this.parentNode.style.display = 'none'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M2.293 2.293a1 1 0 011.414 0L10 8.586l6.293-6.293a1 1 0 111.414 1.414L11.414 10l6.293 6.293a1 1 0 01-1.414 1.414L10 11.414l-6.293 6.293a1 1 0 01-1.414-1.414L8.586 10 2.293 3.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    @endif
    <form method="POST" action="/course/create">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="course_code" class="block mb-2 text-sm font-medium text-gray-900">Course Code</label>
                <input type="text" id="course_code" name="course_code"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Course Code" required>
            </div>
            <div>
                <label for="course_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course
                    Name</label>
                <input type="text" id="course_name" name="course_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Course Name" required>
            </div>
            <div>
                <label for="occ" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Occ/Class</label>
                <input type="text" id="occ" name="occ"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Occ/Class" required>
            </div>
            <div>
                <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Type</label>
                <select id="type" name="type"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected="Lecture">Lecture</option>
                    <option value="Tutorial">Tutorial</option>
                    <option value="Lab">Lab</option>
                </select>
            </div>

            <div>
                <label for="time_start" class="block mb-2 text-sm font-medium text-gray-900">Time Start</label>
                <select id="time_start" name="time_start"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>0800</option>
                    <option value="0900">0900</option>
                    <option value="1000">1000</option>
                    <option value="1100">1100</option>
                    <option value="1200">1200</option>
                    <option value="1300">1300</option>
                    <option value="1400">1400</option>
                    <option value="1500">1500</option>
                    <option value="1600">1600</option>
                    <option value="1700">1700</option>
                    <option value="1800">1800</option>
                    <option value="1900">1900</option>
                    <option value="2000">2000</option>
                </select>

            </div>
            <div>
                <label for="time_end" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Time
                    End</label>
                <select id="time_start" name="time_end"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected="0900">0900</option>
                    <option value="1000">1000</option>
                    <option value="1100">1100</option>
                    <option value="1200">1200</option>
                    <option value="1300">1300</option>
                    <option value="1400">1400</option>
                    <option value="1500">1500</option>
                    <option value="1600">1600</option>
                    <option value="1700">1700</option>
                    <option value="1800">1800</option>
                    <option value="1900">1900</option>
                    <option value="2000">2000</option>
                    <option value="2100">2100</option>
                </select>
            </div>

            <div>
                <label for="day" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Day</label>
                <select id="day" name="day"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
            </div>
            <div>
                <label for="session" class="block mb-2 text-sm font-medium text-gray-900">Semester</label>
                <select id="session" name="session" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach ($session as $sesh)
                        <option value={{ $sesh }}>{{ $sesh }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="semester" class="block mb-2 text-sm font-medium text-gray-900">Semester</label>
                <select id="semester" name="semester"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected="Lecture">1</option>
                    <option value="Tutorial">2</option>
                    <option value="Lab">Semester Khas</option>
                </select>
            </div>
            <div>
                <input type="hidden" id="lecturer" aria-label="disabled input" name="lecturer"
                    value="{{ $user->name }}">
                <input type="hidden" id="lecturer_id" aria-label="disabled input" name="lecturer_id"
                    value="{{ $user->id }}">
            </div>
        </div>
        <button type="submit"
            class="text-white bg-blue-950 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
            Course</button>
    </form>
@endsection
