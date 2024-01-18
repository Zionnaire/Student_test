<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;

Route::prefix('v1')->group(function () {
     // Authentication
   Route::post('register', [AuthController::class, 'register']);
   Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        // Students
        Route::get('/students', [StudentController::class, 'index']);
        Route::post('students/create', [StudentController::class, 'create']);
        Route::post('/students', [StudentController::class, 'store']);
        Route::get('/students/{id}', [StudentController::class, 'show']);
        Route::put('/students/update/{id}', [StudentController::class, 'update']);
        Route::get('search/students', [StudentController::class, 'search']);
        Route::delete('/students/{id}', [StudentController::class, 'delete']);
        Route::get('/students/showInCourse/{course_id}', [StudentController::class, 'showInCourse']);
        Route::get('/students/showInCourse/{course_id}/{student_id}', [StudentController::class, 'showInCourse']);

        // Courses
        Route::post('courses/create', [CourseController::class, 'create']);
        Route::post('courses/store', [CourseController::class, 'store']);
        Route::get('courses', [CourseController::class, 'index']);
        Route::get('courses/{id}', [CourseController::class, 'show']);
        Route::put('courses/{id}', [CourseController::class, 'update']);
        Route::get('search/courses', [CourseController::class, 'search']);
        Route::delete('courses/{id}', [CourseController::class, 'delete']);
    });
    
  
});
