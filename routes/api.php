<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::controller(StudentController::class)->group(function () {

// });

// Route::controller(CourseController::class)->group(function () {

// });

// Route::controller(TeacherController::class)->group(function () {

// });
Route::view('/', 'upload');

//admin and student
Route::group(['middleware' => ['auth:sanctum', 'checkId:student']], function () {
    Route::get('/student/{student}', [StudentController::class, 'show']);
    Route::get('/student/{student}/class', [StudentController::class, 'showStudentClass']);
});

Route::group(['middleware' => ['auth:sanctum', 'role:teacher']], function () {
    Route::put('/class/{course}/student', [CourseController::class, 'addStudent']);
    Route::put('/class/{course}/student/{student}', [CourseController::class, 'updateMark']);
    Route::put('/class/{course}/upload', [CourseController::class, 'update']);
});

//admin and teacher
Route::group(['middleware' => ['auth:sanctum', 'adminTeacherRole']], function () {
    Route::get('/student', [StudentController::class, 'index']); //show all student
    Route::get('/class', [CourseController::class, 'index']); //show all classes
});
//admin and teacher
Route::group(['middleware' => ['auth:sanctum', 'checkId:teacher']], function () {
    Route::get('/teacher/{teacher}', [TeacherController::class, 'show']); //show teacher details
    Route::get('/teacher/{teacher}/class', [TeacherController::class, 'showClasses']); //show teacher's class
});

//extra api
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::post('/class/{course}/teacher', [CourseController::class, 'addTeacher']);
    Route::post('/class', [CourseController::class, 'store']); //add class
});

//extra api
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/teacher', [TeacherController::class, 'index']); //show all teachers
    Route::get('/class/{course}', [CourseController::class, 'show']); //show class details
});

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegistrationController::class, 'register']);
