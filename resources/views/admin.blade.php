@extends('adminLayout')
@section('content')
    <div class="p-4 pt-14">
        @if (session('successUpdate'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-red-400 relative"
                role="alert">
                <span class="font-medium">{{ session('successUpdate') }}</span>
                <button class="absolute center right-6 text-gray-500 hover:text-gray-800"
                    onclick="this.parentNode.style.display = 'none'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M2.293 2.293a1 1 0 011.414 0L10 8.586l6.293-6.293a1 1 0 111.414 1.414L11.414 10l6.293 6.293a1 1 0 01-1.414 1.414L10 11.414l-6.293 6.293a1 1 0 01-1.414-1.414L8.586 10 2.293 3.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        @elseif(session('failedUpdate'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 relative"
                role="alert">
                <span class="font-medium">{{ session('failedUpdate') }}</span>
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
        @elseif(session('failedDelete'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 relative"
                role="alert">
                <span class="font-medium">{{ session('failedDelete') }}</span>
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
        @if ($section === 'dashboard')
            <h1 class="mb-4 text-3xl font-bold leading-none tracking-tight text-gray-900">
                Admin's Dashboard</h1>

            <div class="grid grid-cols-2 gap-4">
                <h2 class="flex col-span-2">Add Semester</h2>
                <div class="flex col-span-2">
                    <form method="POST" action="/admin/semester/create">
                        @csrf
                        <div class="grid gap-6 mb-6 md:grid-cols-4">
                            <div>
                                <label for="course_code" class="block mb-2 text-sm font-medium text-gray-900">Semester
                                    Session</label>
                                <select id="session" name="session"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @php
                                        
                                        $currentYear = date('Y');
                                        $prevYear = $currentYear - 1;
                                    @endphp
                                    <option value="{{ $prevYear }}/{{ $currentYear }}" selected>
                                        {{ $prevYear }}/{{ $currentYear }}
                                    </option>
                                    @for ($i = 1; $i < 10; $i++)
                                        <option value="{{ $prevYear + $i }}/{{ $currentYear + $i }}">
                                            {{ $prevYear + $i }}/{{ $currentYear + $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label for="course_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                                <select id="semester" name="semester"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="Semester Khas">Semester Khas</option>
                                </select>
                            </div>
                            <div>
                                <label for="occ"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Week</label>
                                <input type="week" id="week" name="week"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Choose a Week" required>
                            </div>
                            <div>
                                <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Maximum Number of
                                    Weeks</label>
                                <input type="number" id="maxWeeks" name="maxWeeks" min="1" max="16"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Choose the maximum number of weeks" required>
                            </div>
                            <div>
                                <button type="submit"
                                    class="text-white bg-blue-950 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                                    Semester</button>
                            </div>

                    </form>
                </div>
            </div>

            <h2 class="flex col-span-2">Manage Semester</h2>
            <div class="dlex col-span-2 max-h-96 overflow-y-auto">


                <table class="w-full text-sm text-left text-gray-500 max-h-24 overflow-y-auto">
                    <thead
                        class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-4">No.</th>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Session</th>
                            <th class="px-14 py-4">Semester</th>
                            <th class="px-20 py-4">First Week</th>
                            <th class="px-20 py-4">Final Week</th>
                            <th class="px-20 py-4">Number of Week(s)</th>
                            <th class="px-20 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $index => $admin)
                            <tr class="bg-white border-b text-center dark:bg-gray-900">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $admin->id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $admin->session }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $admin->semester }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $admin->first_week }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $admin->final_week }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $admin->maxWeek }}</td>
                                <td class="px-6 py-4 content-center">
                                    <div>
                                        <button
                                            data-modal-target="deleteSemesterModal"data-modal-toggle="deleteSemesterModal"
                                            data-semester-id="{{ $admin->id }}"
                                            class="delete-semester-button self-center block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif ($section === 'Vstudents')
            {{-- Display student details --}}
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold leading-none tracking-tight text-gray-900">View Students</h1>
                <div class="flex">
                    <input type="text" id="searchInput" placeholder="Search by name or email"
                        class="border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <button id="searchUserButton"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg ml-2">Search</button>
                </div>
            </div>

            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400"e>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">No.</th>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Number of Course(s) Taken</th>
                        <th class="px-6 py-4">Register Time</th>
                        <th class="px-6 py-4">Last Modified</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $index => $student)
                        <tr class="bg-white border-b dark:bg-gray-900">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $student->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $student->name }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $student->email }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $count = DB::table('schedules')
                                        ->where('user_id', $student->id)
                                        ->where('user_role', 'Student')
                                        ->count();
                                    echo $count;
                                @endphp</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $formattedDateTime = date('d-m-Y H:i:s', strtotime($student->created_at));
                                @endphp
                                {{ $formattedDateTime }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $formattedDateTime = date('d-m-Y H:i:s', strtotime($student->updated_at));
                                @endphp
                                {{ $formattedDateTime }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($section === 'Mstudents')
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold leading-none tracking-tight text-gray-900">Manage Students</h1>
                <div class="flex">
                    <input type="text" id="searchInput" placeholder="Search by name or email"
                        class="border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <button id="searchUserButton"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg ml-2">Search</button>
                </div>
            </div>

            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400"e>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-14 py-4">Email</th>
                        <th class="px-20 py-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr class="bg-white border-b dark:bg-gray-900">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $student->id }}</td>
                            <form action="/admin/updateUser" id="adminUpdateUser{{ $student->id }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="id" aria-label="disabled input" name="id"
                                    value={{ $student->id }}>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <input type="text" name="name" value="{{ $student->name }}"
                                        class="border-b border-gray-300 focus:outline-none">
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <input type="email" name="email" value="{{ $student->email }}"
                                        class="border-b border-gray-300 focus:outline-none">
                                </td>
                            </form>
                            <td class="px-6 py-4">
                                <div class="flex space-x-4">
                                    <button type="submit" form="adminUpdateUser{{ $student->id }}"
                                        class=" text-white bg-blue-950 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update
                                    </button>
                                    <button data-modal-target="deleteModal"data-modal-toggle="deleteModal"
                                        data-username="{{ $student->name }} " data-user-id="{{ $student->id }}"
                                        class="delete-button block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</button>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="relative pt-5">

            </div>
        @elseif ($section === 'Vlecturers')
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold leading-none tracking-tight text-gray-900">View Lecturers</h1>
                <div class="flex">
                    <input type="text" id="searchInput" placeholder="Search by name or email"
                        class="border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <button id="searchUserButton"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg ml-2">Search</button>
                </div>
            </div>
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400"e>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">No.</th>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Number of Course(s) Taught</th>
                        <th class="px-6 py-4">Register Time</th>
                        <th class="px-6 py-4">Last Modified</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lecturers as $index => $lecturer)
                        <tr class="bg-white border-b dark:bg-gray-900">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $lecturer->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $lecturer->name }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $lecturer->email }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $count = DB::table('schedules')
                                        ->where('user_id', $lecturer->id)
                                        ->where('user_role', 'Lecturer')
                                        ->count();
                                    echo $count;
                                @endphp</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $formattedDateTime = date('d-m-Y H:i:s', strtotime($lecturer->created_at));
                                @endphp
                                {{ $formattedDateTime }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $formattedDateTime = date('d-m-Y H:i:s', strtotime($lecturer->updated_at));
                                @endphp
                                {{ $formattedDateTime }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($section === 'Mlecturers')
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold leading-none tracking-tight text-gray-900">Manage Lecturers</h1>
                <div class="flex">
                    <input type="text" id="searchInput" placeholder="Search by name or email"
                        class="border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <button id="searchUserButton"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg ml-2">Search</button>
                </div>
            </div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400"e>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-20 py-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lecturers as $lecturer)
                        <tr class="bg-white border-b dark:bg-gray-900">
                        <tr class="bg-white border-b dark:bg-gray-900">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $lecturer->id }}</td>
                            <form action="/admin/updateUser" id="adminUpdateUser{{ $lecturer->id }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="id" aria-label="disabled input" name="id"
                                    value={{ $lecturer->id }}>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <input type="text" name="name" value="{{ $lecturer->name }}"
                                        class="border-b border-gray-300 focus:outline-none">
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <input type="email" name="email" value="{{ $lecturer->email }}"
                                        class="border-b border-gray-300 focus:outline-none">
                                </td>
                            </form>
                            <td class="px-6 py-4">
                                <div class="flex space-x-4">
                                    <button type="submit" form="adminUpdateUser{{ $lecturer->id }}"
                                        class=" text-white bg-blue-950 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update
                                    </button>
                                    <button data-modal-target="deleteModal"data-modal-toggle="deleteModal"
                                        data-username="{{ $lecturer->name }} " data-user-id="{{ $lecturer->id }}"
                                        class="delete-button block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</button>
                                </div>
                            </td>

                        </tr>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($section === 'Vcourses')
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold leading-none tracking-tight text-gray-900">View Courses</h1>
                <div class="flex">
                    <input type="text" id="searchInput" placeholder="Search courses"
                        class="border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <button id="searchCourseButton"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg ml-2">Search</button>
                </div>
            </div>
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400"e>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Course Code</th>
                        <th class="px-6 py-4">Course Name</th>
                        <th class="px-6 py-4">Occ</th>
                        <th class="px-6 py-4">Lecturer</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Time Start</th>
                        <th class="px-6 py-4">Duration</th>
                        <th class="px-6 py-4">Day</th>
                        <th class="px-6 py-4">Session</th>
                        <th class="px-6 py-4">Semester</th>
                        <th class="px-6 py-4">Number of Student(s)</th>
                        <th class="px-6 py-4">Created Time</th>
                        <th class="px-6 py-4">Last Modified</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr class="bg-white border-b dark:bg-gray-900">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->course_code }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->course_name }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->occ }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->lecturer }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->type }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->time_start }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ ($course->time_end - $course->time_start) / 100 }} hour(s)</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->day }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->session }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->semester }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $count = DB::table('schedules')
                                        ->where('course_id', $course->id)
                                        ->where('user_role', 'Student')
                                        ->count();
                                    echo $count;
                                @endphp</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $formattedDateTime = date('d-m-Y H:i:s', strtotime($course->created_at));
                                @endphp
                                {{ $formattedDateTime }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $formattedDateTime = date('d-m-Y H:i:s', strtotime($course->updated_at));
                                @endphp
                                {{ $formattedDateTime }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($section === 'Mcourses')
            @php
                $session = DB::table('admins')
                    ->distinct('session')
                    ->pluck('session');
            @endphp
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold leading-none tracking-tight text-gray-900">Manage Courses</h1>
                <div class="flex">
                    <input type="text" id="searchInput" placeholder="Search courses"
                        class="border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <button id="searchCourseButton"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg ml-2">Search</button>
                </div>
            </div>
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400"e>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Course Code</th>
                        <th class="px-6 py-4">Course Name</th>
                        <th class="px-6 py-4">Occ</th>
                        <th class="px-6 py-4">Lecturer</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Time Start</th>
                        <th class="px-6 py-4">Time End</th>
                        <th class="px-6 py-4">Day</th>
                        <th class="px-6 py-4">Session</th>
                        <th class="px-6 py-4">Semester</th>
                        <th class="px-20 py-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr class="bg-white border-b dark:bg-gray-900">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->id }}
                            </td>
                            <form action="/admin/updateCourse" id="adminUpdateCourse{{ $course->id }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="id" aria-label="disabled input" name="id"
                                    value="{{ $course->id }}">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <input type="text" name="course_code" value="{{ $course->course_code }}"
                                        class="border-b border-gray-300 focus:outline-none">
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <input type="text" name="course_name" value="{{ $course->course_name }}"
                                        class="border-b border-gray-300 focus:outline-none">
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <input type="text" name="occ" value="{{ $course->occ }}"
                                        class="border-b border-gray-300 focus:outline-none">
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <input type="text" name="lecturer" value="{{ $course->lecturer }}"
                                        class="border-b border-gray-300 focus:outline-none">
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <select id="type" name="type"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                                        <option selected="{{ $course->type }}">{{ $course->type }}</option>
                                        <option value="Tutorial">Tutorial</option>
                                        <option value="Lab">Lab</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <select id="time_start" name="time_start"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                                        <option value="0800"@if ($course->time_start == '0800') selected @endif>0800
                                        </option>
                                        <option value="0900" @if ($course->time_start == '0900') selected @endif>0900
                                        </option>
                                        <option value="1000" @if ($course->time_start == '1000') selected @endif>1000
                                        </option>
                                        <option value="1100"@if ($course->time_start == '1100') selected @endif>1100
                                        </option>
                                        <option value="1200"@if ($course->time_start == '1200') selected @endif>1200
                                        </option>
                                        <option value="1300"@if ($course->time_start == '1300') selected @endif>1300
                                        </option>
                                        <option value="1400"@if ($course->time_start == '1400') selected @endif>1400
                                        </option>
                                        <option value="1500"@if ($course->time_start == '1500') selected @endif>1500
                                        </option>
                                        <option value="1600"@if ($course->time_start == '1600') selected @endif>1600
                                        </option>
                                        <option value="1700"@if ($course->time_start == '1700') selected @endif>1700
                                        </option>
                                        <option value="1800"@if ($course->time_start == '1800') selected @endif>1800
                                        </option>
                                        <option value="1900"@if ($course->time_start == '1900') selected @endif>1900
                                        </option>
                                        <option value="2000"@if ($course->time_start == '2000') selected @endif>2000
                                        </option>

                                    </select>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <select id="time_end" name="time_end"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                                        <option value="0900" @if ($course->time_end == '0900') selected @endif>0900
                                        </option>
                                        <option value="1000" @if ($course->time_end == '1000') selected @endif>1000
                                        </option>
                                        <option value="1100"@if ($course->time_end == '1100') selected @endif>1100
                                        </option>
                                        <option value="1200"@if ($course->time_end == '1200') selected @endif>1200
                                        </option>
                                        <option value="1300"@if ($course->time_end == '1300') selected @endif>1300
                                        </option>
                                        <option value="1400"@if ($course->time_end == '1400') selected @endif>1400
                                        </option>
                                        <option value="1500"@if ($course->time_end == '1500') selected @endif>1500
                                        </option>
                                        <option value="1600"@if ($course->time_end == '1600') selected @endif>1600
                                        </option>
                                        <option value="1700"@if ($course->time_end == '1700') selected @endif>1700
                                        </option>
                                        <option value="1800"@if ($course->time_end == '1800') selected @endif>1800
                                        </option>
                                        <option value="1900"@if ($course->time_end == '1900') selected @endif>1900
                                        </option>
                                        <option value="2000"@if ($course->time_end == '2000') selected @endif>2000
                                        </option>
                                        <option value="2100"@if ($course->time_end == '2100') selected @endif>2100
                                        </option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <select name="day"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                                        <option value="Monday" @if ($course->day == 'Monday') selected @endif>Monday
                                        </option>
                                        <option value="Tuesday" @if ($course->day == 'Tuesday') selected @endif>Tuesday
                                        </option>
                                        <option value="Wednesday"@if ($course->day == 'Wednesday') selected @endif>
                                            Wednesday</option>
                                        <option value="Thursday"@if ($course->day == 'Thursday') selected @endif>
                                            Thursday
                                        </option>
                                        <option value="Friday"@if ($course->day == 'Friday') selected @endif>Friday
                                        </option>
                                        <option value="Saturday"@if ($course->day == 'Saturday') selected @endif>
                                            Saturday
                                        </option>
                                        <option value="Sunday"@if ($course->day == 'Sunday') selected @endif>Sunday
                                        </option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <select id="session" name="session"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                                        @foreach ($session as $sesh)
                                            <option
                                                value={{ $sesh }}@if ($course->session == $sesh) selected @endif>
                                                {{ $sesh }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <select id="semester" name="semester"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                                        <option value="1" @if ($course->semester == '1') selected @endif>1
                                        </option>
                                        <option value="2" @if ($course->semester == '2') selected @endif>2
                                        </option>
                                        <option value="Semester Khas" @if ($course->semester == 'Semester Khas') selected @endif>
                                            Semester Khas</option>
                                    </select>
                                </td>

                            </form>
                            <td class="px-6 py-4">
                                <div class="flex space-x-4">
                                    <button type="submit" form="adminUpdateCourse{{ $course->id }}"
                                        class="text-white bg-blue-950 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                                        Update
                                    </button>
                                    <button data-modal-target="deleteModal" data-modal-toggle="deleteModal"
                                        data-username="{{ $course->course_name }}" data-user-id="{{ $course->id }}"
                                        class="delete-button block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        @elseif ($section === 'searchUser')
            {{-- Display student details --}}
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold leading-none tracking-tight text-gray-900">Search: {{ $query }}
                </h1>
                <div class="flex">
                    <input type="text" id="searchInput" placeholder="Search by name or email"
                        class="border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <button id="searchUserButton"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg ml-2">Search</button>
                </div>
            </div>

            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400"e>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Register Time</th>
                        <th class="px-6 py-4">Last Modified</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="bg-white border-b dark:bg-gray-900">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $user->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $user->name }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $user->email }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $formattedDateTime = date('d-m-Y H:i:s', strtotime($user->created_at));
                                @endphp
                                {{ $formattedDateTime }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $formattedDateTime = date('d-m-Y H:i:s', strtotime($user->updated_at));
                                @endphp
                                {{ $formattedDateTime }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($section === 'Vevents')
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold leading-none tracking-tight text-gray-900">View Events</h1>
            </div>

            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400"e>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">No.</th>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Course Code</th>
                        <th class="px-6 py-4">Lecturer Name</th>
                        <th class="px-6 py-4">Week</th>
                        <th class="px-6 py-4">Day</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Register Time</th>
                        <th class="px-6 py-4">Last Modified</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $index => $event)
                        <tr class="bg-white border-b dark:bg-gray-900">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $event->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $event->course_code }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $lecturer = DB::table('users')
                                        ->where('id', $event->lecturer_id)
                                        ->value('name');
                                @endphp
                                {{ $lecturer }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $event->week }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $day = date('l', strtotime($event->date));
                                @endphp
                                {{ $day }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $event->date }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $formattedDateTime = date('d-m-Y H:i:s', strtotime($event->created_at));
                                @endphp
                                {{ $formattedDateTime }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $formattedDateTime = date('d-m-Y H:i:s', strtotime($event->updated_at));
                                @endphp
                                {{ $formattedDateTime }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($section === 'searchCourses')
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold leading-none tracking-tight text-gray-900">Search: {{ $query }}
                </h1>
                <div class="flex">
                    <input type="text" id="searchInput" placeholder="Search courses"
                        class="border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <button id="searchCourseButton"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg ml-2">Search</button>
                </div>
            </div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400"e>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Course Code</th>
                        <th class="px-6 py-4">Course Name</th>
                        <th class="px-6 py-4">Occ</th>
                        <th class="px-6 py-4">Lecturer</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Time Start</th>
                        <th class="px-6 py-4">Duration</th>
                        <th class="px-6 py-4">Day</th>
                        <th class="px-6 py-4">Created Time</th>
                        <th class="px-6 py-4">Updated Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr class="bg-white border-b dark:bg-gray-900">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->course_code }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->course_name }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->occ }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->lecturer }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->type }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->time_start }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ ($course->time_end - $course->time_start) / 100 }} hour(s)</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $course->day }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $formattedDateTime = date('d-m-Y H:i:s', strtotime($course->created_at));
                                @endphp
                                {{ $formattedDateTime }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                @php
                                    $formattedDateTime = date('d-m-Y H:i:s', strtotime($course->updated_at));
                                @endphp
                                {{ $formattedDateTime }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            {{-- Error handling or default content --}}
            <p>Invalid section</p>
        @endif
    </div>
    <!-- Delete semester modal -->
    <div id="deleteSemesterModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Delete Semester Confirmation
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="deleteSemesterModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Are you sure you want to delete this semester from the database?
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        This action cannot be undone.
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id="deleteSemesterButton" data-modal-hide="deleteSemesterModal" type="button"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</button>
                    <button data-modal-hide="deleteSemesterModal" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete user modal -->
    <div id="deleteModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Delete User Confirmation
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="deleteModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Are you sure you want to delete user <span id="deleteUserName"></span> from the database?
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        This action cannot be undone.
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id="deleteUserButton" data-modal-hide="deleteModal" type="button"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</button>
                    <button data-modal-hide="deleteModal" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
