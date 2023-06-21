<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');;

Route::get('/course/Lecturer/addCourse', [CourseController::class, 'addL'])->middleware('auth');
Route::get('/course/Student/addCourse', [CourseController::class, 'addS'])->middleware('auth');
Route::get('/course/groupProject', function () {
    return redirect('/chatify');
})->middleware('auth');
Route::post('/course/create', [CourseController::class, 'create'])->middleware('auth');
Route::post('/course/add', [CourseController::class, 'add'])->middleware('auth');
Route::get('/coursePlaning/update', [CourseController::class, 'update'])->middleware('auth');
Route::delete('course/{course}', [CourseController::class, 'destroy'])->middleware('auth');
Route::get('/course/{course}', [CourseController::class, 'show'])->middleware('auth');
Route::get('course/Lecturer/coursePlanning/{id}', [CourseController::class, 'planL'])->middleware('auth');
Route::get('course/Student/coursePlanning/{id}', [CourseController::class, 'planS'])->middleware('auth');
Route::get('/course/timetable/{user_id}', [CourseController::class, 'timetable'])->middleware('auth');
Route::get('/schedule/{id}', [CourseController::class, 'schedule'])->middleware('auth');

Route::get('/admin', [AdminController::class, 'index'])->middleware('auth');
Route::get('/admin/{section?}', [AdminController::class, 'index'])
    ->where('section', 'dashboard|Vstudents|Mstudents|Vlecturers|Mlecturers|Vcourses|Mcourses|Vevents|Mevents')->middleware('auth');
Route::get('/admin/updateUser', [AdminController::class, 'updateUser'])->middleware('auth');
Route::get('admin/deleteUser/{id}', [AdminController::class, 'deleteUser'])->middleware('auth');
Route::get('/admin/updateCourse', [AdminController::class, 'updateCourse'])->middleware('auth');
Route::get('admin/deleteCourse/{id}', [AdminController::class, 'deleteCourse'])->middleware('auth');
Route::get('/admin/search/user', [AdminController::class, 'searchUser'])->middleware('auth');
Route::get('/admin/search/course', [AdminController::class, 'searchCourse'])->middleware('auth');
Route::post('/admin/semester/create', [AdminController::class, 'create'])->middleware('auth');
Route::get('/admin/semester/delete/{id}', [AdminController::class, 'destroy'])->middleware('auth');

Route::get('/users/register', [UserController::class, 'register']);
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
Route::post('/users/create', [UserController::class, 'create']);

Route::get('/logout', [UserController::class, 'logout'])->middleware('auth');
