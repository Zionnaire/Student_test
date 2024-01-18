<?php

namespace App\Http\Controllers;
use App\Models\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CourseController extends Controller
{

    //Show Registration Form
    public function create()
    {
        // return view('courses.create');
        return response(['message' => 'Course created successfully'], 200);
    }

    //Store Course
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'course_level' => 'required',
                'course_status' => 'required',
                'course_duration' => 'required',
                'course_id' => 'required|unique:courses',
                'course_type' => 'required',
                'total_score' => 'required',
            ]);
    
            $course = Course::create($validated);
    
            // If you want to redirect, uncomment the following line
            // return redirect(route('courses.index'));
    
            return response(['message' => 'Course added successfully!', 'course' => $course], 200);
        } catch (QueryException $e) {
            // Handle unique constraint violation (duplicate course_id)
            if ($e->errorInfo[1] == 1062) {
                return response(['message' => 'Course ID must be unique.'], 422);
            }
    
            // Handle other database-related exceptions
            // You can log the exception for further investigation
            // Log::error($e);
    
            return response(['message' => 'An error occurred while adding the course.'], 500);
        } catch (\Exception $e) {
            // Handle other exceptions
            // You can log the exception for further investigation
            // Log::error($e);
    
            return response(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    //Show All Courses

    public function index()
    {
        try {
            $courses = Course::all();
    
            if ($courses->isEmpty()) {
                return response(['message' => 'No courses found.'], 404);
            }
    
            return response(['message' => 'All courses displayed successfully!', 'courses' => $courses], 200);
        } catch (ModelNotFoundException $e) {
            // Handle model not found exception
            // You can log the exception for further investigation
            // Log::error($e);
    
            return response(['message' => 'No courses found.'], 404);
        } catch (\Exception $e) {
            // Handle other exceptions
            // You can log the exception for further investigation
            // Log::error($e);
    
            return response(['message' => 'An unexpected error occurred.'], 500);
        }
    }
    


    // Show Specific Course
    public function show($id)
    {
        try {
            $course = Course::findOrFail($id);
            return response(['message' => 'A single course displayed successfully!', 'course' => $course]);
        } catch (ModelNotFoundException $e) {
            // Handle model not found exception
            // You can log the exception for further investigation
            // Log::error($e);
    
            return response(['message' => 'Course not found.'], 404);
        } catch (\Exception $e) {
            // Handle other exceptions
            // You can log the exception for further investigation
            // Log::error($e);
    
            return response(['message' => 'An unexpected error occurred.'], 500);
        }
    }
    
    // Edit Specific Course
    public function edit($id)
    {
        $course = Course::find($id);
        // return view('courses.edit', ['course' => $course]);
        return response(['message' => 'Details edited successfully!', 'course' => $course]);
    }
    
    // Update Specific Course
    public function update(Request $request, $id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->update($request->all());
            return response(['message' => 'Course details updated successfully!', 'course' => $course]);
        } catch (ModelNotFoundException $e) {
            // Handle model not found exception
            // You can log the exception for further investigation
            // Log::error($e);
    
            return response(['message' => 'Course not found.'], 404);
        } catch (\Exception $e) {
            // Handle other exceptions
            // You can log the exception for further investigation
            // Log::error($e);
    
            return response(['message' => 'An unexpected error occurred.'], 500);
        }
    }
    
    // Delete Specific Course
    public function delete($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();
            return response(['message' => 'Course deleted successfully!', 'course' => $course]);
        } catch (ModelNotFoundException $e) {
            // Handle model not found exception
            // You can log the exception for further investigation
            // Log::error($e);
    
            return response(['message' => 'Course not found.'], 404);
        } catch (\Exception $e) {
            // Handle other exceptions
            // You can log the exception for further investigation
            // Log::error($e);
    
            return response(['message' => 'An unexpected error occurred.'], 500);
        }
    }
    
// Search Courses
public function search(Request $request)
{
    try {
        $search = $request->input('search');
        $courses = Course::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->get();

        if ($courses->isEmpty()) {
            return response(['message' => 'No courses found.'], 404);
        }

        return response(['message' => 'All courses displayed successfully!', 'courses' => $courses], 200);
    } catch (\Exception $e) {
        // Handle other exceptions
        // You can log the exception for further investigation
        // Log::error($e);

        return response(['message' => 'An unexpected error occurred.'], 500);
    }
}

// Show Students in a Course
public function showInCourse($id)
{
    try {
        $course = Course::with('students')->findOrFail($id);
        $students = $course->students;

        return response(['message' => 'All students displayed successfully!', 'students' => $students], 200);
    } catch (ModelNotFoundException $e) {
        // Handle model not found exception
        // You can log the exception for further investigation
        // Log::error($e);

        return response(['message' => 'Course not found.'], 404);
    } catch (\Exception $e) {
        // Handle other exceptions
        // You can log the exception for further investigation
        // Log::error($e);

        return response(['message' => 'An unexpected error occurred.'], 500);
    }
}

}

