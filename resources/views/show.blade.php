@extends('layout')
@php
    //dd($course);
@endphp
@section('content')
    <div class="p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow h-fit relative">
        <a>
            <h5 class="mb-2 text-2xl pb-5 font-semibold tracking-tight text-gray-900 dark:text-white">
                {{ $course->course_code . ' ' . $course->course_name }}
            </h5>
        </a>
        <a>Lecturer : {{ $course->lecturer }}</a>
        <br>
        <a>Occ : {{ $course->occ }}</a>
        <br>
        <a>Time : {{ $course->time_start }} hrs - {{ $course->time_end }} hrs</a>
        <br>
        <a>Day : {{ $course->day }}</a>
        <br>
        <a>Type : {{ $course->type }}</a>
        <br><br>
        @php
            //dd($course->time_end - $course->time_start);
        @endphp
        <form method="POST" action="/course/{{ $course->id }}">
            @csrf
            @method('DELETE')
            <button class="text-red-500 absolute bottom-5 right-10">
                <i class="fa-solid fa-trash"></i>
                Delete
            </button>
    </div>
@endsection
