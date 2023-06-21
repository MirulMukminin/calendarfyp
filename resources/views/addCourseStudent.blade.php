@extends('layout')

@section('content')
    @php
        use App\Models\User;
        $user = auth()->user();
        $courses = $user->courses;
        //dd($course);
        $course_code = DB::table('courses')
            ->distinct()
            ->pluck('course_code')
            ->sortBy('course_code');
        $course_occ = DB::table('courses')
            ->distinct()
            ->pluck('occ')
            ->sort();
        //dd($course_occ);
        //dd($course_code);
        // $course_code = $course->unique('course_code');
    @endphp
    @if (session()->get('error_code') == 1)
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 relative"
            role="alert">
            <span class="font-medium">Course was not found.</span> Please try again.
            <button class="absolute center right-6 text-gray-500 hover:text-gray-800"
                onclick="this.parentNode.style.display = 'none'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M2.293 2.293a1 1 0 011.414 0L10 8.586l6.293-6.293a1 1 0 111.414 1.414L11.414 10l6.293 6.293a1 1 0 01-1.414 1.414L10 11.414l-6.293 6.293a1 1 0 01-1.414-1.414L8.586 10 2.293 3.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    @elseif(session()->get('error_code') == 2)
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 relative"
            role="alert">
            <span class="font-medium">Course already added.</span> Please try again.
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
    {{-- @if (session()->has('error_code') == 2)
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">Course Already Added.</span> Please try again.
        </div>
    @endif --}}

    <form method="POST" action="/course/add">
        @csrf
        <input type="hidden" name="role" value="{{ $user->role }}">
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="course Code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course
                    Code</label>
                <select id="course_code" name="course_code"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    {{-- <option selected="{{ $course[0]->id }}">{{ $course[0]->course_code }}</option>
                    @php
                        $courseCopy = $course->slice(1);
                    @endphp --}}
                    @foreach ($course_code as $Course)
                        <option value="{{ $Course }}">{{ $Course }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="occ" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Occ/Class</label>
                <select id="occ" name="occ"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach ($course_occ as $occ)
                        <option value="{{ $occ }}">{{ $occ }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit"
            class="text-white bg-blue-950 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
            Course</button>
    </form>
@endsection
