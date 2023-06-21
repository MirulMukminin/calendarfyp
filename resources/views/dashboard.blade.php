@extends('layout')

@section('content')
    {{-- welcome {{ auth()->user()->name }} --}}
    @php
        use App\Models\User;
        $user = auth()->user();
        // $courses = DB::table('courses')->where('')
        $courses = $user->courses->sortBy('occ')->sortBy('course_code');
        //$courses = $user->courses->unique('course_code')->sortBy('course_code');
    @endphp
    @if (session('successAdd'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-red-400 relative"
            role="alert">
            <span class="font-medium">{{ session('successAdd') }}</span>
            <button class="absolute center right-6 text-gray-500 hover:text-gray-800"
                onclick="this.parentNode.style.display = 'none'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M2.293 2.293a1 1 0 011.414 0L10 8.586l6.293-6.293a1 1 0 111.414 1.414L11.414 10l6.293 6.293a1 1 0 01-1.414 1.414L10 11.414l-6.293 6.293a1 1 0 01-1.414-1.414L8.586 10 2.293 3.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    @elseif(session('successDelete'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-red-400 relative"
            role="alert">
            <span class="font-medium">{{ session('successDelete') }}</span>
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
    @unless (count($courses) == 0)
        @foreach ($courses as $course)
            <div class="p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow h-fit">
                <a href="/course/{{ $course->id }}">
                    <h5 class="mb-2 text-2xl pb-3 font-semibold tracking-tight text-gray-900 dark:text-white">
                        {{ $course->course_code . ' ' . $course->course_name }}
                    </h5>
                </a>
                <a class="inline-flex items-center text-black">
                    Type: {{ $course->type }}
                </a><br>
                <a class="inline-flex items-center text-black">
                    Occ: {{ $course->occ }}
                </a><br>
                @if ($user->role == 'Lecturer')
                    <a href="/schedule/{{ $course->id }}" class="inline-flex items-center text-blue-600 hover:underline">
                        Schedule Test
                    </a><br>
                @endif

                <a href="/course/{{ $user->role }}/coursePlanning/{{ $course->id }}"
                    class="pt-2 inline-flex items-center text-blue-600 hover:underline">
                    Course Planning
                </a>
            </div>
        @endforeach
    @endunless





@endsection
