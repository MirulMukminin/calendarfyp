<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/favicon.ico" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Collaborative Course Calendar</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[name="event"]').change(function() {
                var dropdown = $(this).closest('tr').find('.event-time-dropdown');
                if ($(this).is(':checked')) {
                    if ($(this).val() === 'outside_class_time') {
                        dropdown.show();
                    } else {
                        dropdown.hide();
                    }
                }
            });
        });
    </script>

</head>

<body class="mb-48">
    @php
        use App\Models\User;
        $user = auth()->user();
        $courses = $user->courses;
        $courseCodes = $courses->pluck('course_code')->unique();
        
        $events = DB::table('events')
            ->whereIn('course_code', $courseCodes)
            ->where(function ($query) use ($user) {
                if ($user->role == 'Lecturer') {
                    $query->where('lecturer_id', $user->id);
                }
            })
            ->whereDate('date', '>=', date('Y-m-d'))
            ->orderBy('date', 'asc')
            ->get();
        //dd($events);
    @endphp
    <nav class="bg-white border-gray-200">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-2xl p-4">
            <a href="/" class="flex items-center">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Collaborative Course
                    Calendar</span>
            </a>
            <div class="flex items-center mr-8 grid-cols-2">
                <a class="mr-10 text-sm  text-black">Welcome,
                    {{ $user->name }}</a>
                <a href="/logout" class="text-sm  text-black dark:text-blue-500">
                    Logout
                    <svg class="h-6 w-6 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg></a>
            </div>
        </div>
    </nav>
    <nav class="bg-blue-950">
        <div class="max-w-screen-xl px-4 py-3 mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 space-x-8 text-sm">
                    <li>
                        <a href="/" class="text-white border-x-2 border-white px-10 hover:text-yellow-300"
                            aria-current="page">Home</a>
                    </li>
                    '
                    <li>
                        <a href="/course/{{ $user->role }}/addCourse"
                            class="text-white border-r-2 border-white pr-10 hover:text-yellow-300">Add
                            Course</a>
                    </li>
                    <li>
                        <a href="/course/timetable/{{ $user->id }}"
                            class="text-white border-r-2 border-white pr-10 hover:text-yellow-300">My Timetable</a>
                    </li>
                    <li>
                        <a href="/course/groupProject"
                            class="text-white border-r-2 border-white pr-10 hover:text-yellow-300">Chat Room</a>
                    </li>
                    <li>
                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                            class="
                    flex 
                    items-center 
                    justify-between 
                    text-white 
                    border-r-2 
                    border-white 
                    pr-10
                    hover:text-yellow-300">External
                            Links <svg class="w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg></button>
                        <!-- Dropdown menu -->
                        <div id="dropdownNavbar"
                            class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-400"
                                aria-labelledby="dropdownLargeButton">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Spectrum</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Maya</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">MyUM</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-10">
        <div class="grid grid-cols-7 auto-rows-max gap-4 pt-10">
            <div class="col-span-4">
                @yield('content')
            </div>
            <div class="col-span-2 col-end-8 row-start-1">
                <div class="bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Upcoming Events</h5>
                    </div>
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 min-w-0">
                                        @if (isset($events[0]))
                                            <a href="/course/{{ $user->role }}/coursePlanning/{{ $events[0]->course_id }}"
                                                class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                {{ $events[0]->course_code }}
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        @if ($events[0]->date == date('Y-m-d'))
                                            Today {{ date('H:i', strtotime($events[0]->event_time)) }}
                                        @else
                                            @php
                                                $timestamp = strtotime($events[0]->date);
                                            @endphp
                                            {{ date('d-m-Y', $timestamp) }}
                                            {{ date('H:i', strtotime($events[0]->event_time)) }}
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        No Upcoming Event
                                    </p>
                                    @endif
                                    </a>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 min-w-0">
                                        @if (isset($events[1]))
                                            <a href="/course/{{ $user->role }}/coursePlanning/{{ $events[1]->course_id }}"
                                                class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                {{ $events[1]->course_code }}
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        @if ($events[1]->date == date('Y-m-d'))
                                            Today {{ date('H:i', strtotime($events[1]->event_time)) }}
                                        @else
                                            @php
                                                $timestamp = strtotime($events[1]->date);
                                            @endphp
                                            {{ date('d-m-Y', $timestamp) }}
                                            {{ date('H:i', strtotime($events[1]->event_time)) }}
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        No Upcoming Event
                                    </p>
                                    @endif
                                    </a>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 min-w-0">
                                        @if (isset($events[2]))
                                            <a href="/course/{{ $user->role }}/coursePlanning/{{ $events[2]->course_id }}"
                                                class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                {{ $events[2]->course_code }}
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        @if ($events[2]->date == date('Y-m-d'))
                                            Today {{ date('H:i', strtotime($events[2]->event_time)) }}
                                        @else
                                            @php
                                                $timestamp = strtotime($events[2]->date);
                                            @endphp
                                            {{ date('d-m-Y', $timestamp) }}
                                            {{ date('H:i', strtotime($events[2]->event_time)) }}
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        No Upcoming Event
                                    </p>
                                    @endif
                                    </a>
                                </div>
                    </div>
                    </li>

                    </ul>
                </div>
            </div>
        </div>
    </main>
    <footer class="fixed bottom-0 bg-white rounded-lg shadow m-4 dark:bg-gray-800">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="#"
                    class="hover:underline">Collaborative Course Calendar™</a>. All Rights Reserved.
            </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                <li>
                    <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
                </li>
                <li>
                    <a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="mr-4 hover:underline md:mr-6">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
    </footer>

    <script>
        function toggleDropdown(show, dropdownId) {
            var dropdown = document.getElementById(dropdownId);
            dropdown.style.display = show ? "block" : "none";
        }
    </script>
</body>



</html>
