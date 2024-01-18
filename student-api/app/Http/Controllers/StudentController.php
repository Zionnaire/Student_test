<?php

namespace App\Http\Controllers;
use App\Models\Student;

// use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;


class StudentController extends Controller
{

    //Create New Student
    public function create(){
        return response(['message' => ' Student created successfully'], 200);
    }

   // Store Student
public function store(Request $request)
    {
        $validated = $request->validate([
            'name' =>'required',
            'email' =>'required|email|unique:students',
            'phone' =>'required',
            'address' =>'required',
            'dob' =>'required',
            'gender' =>'required',
            'age' =>'required',
            'nationality' =>'required',
            'city' =>'required',
           'state' =>'required',
            'country' =>'required',
            'course_score' =>'required',
            'course_id' =>'required',
        ]);

        $student = Student::create($validated);
        return response(['message' => 'Student added successfully!', 'student' => $student], 200);

    }

    //Show All Students
    public function index(){

        $students = Student::all();
        // return view('students.index', ['students' => $students]);
        return response(['message' => 'All students displayed successfully!', 'Students' => $students]);
    }

    //Show Specific Student
    public function show($id){
        $student = Student::find($id);
        // return view('students.show', ['student' => $student]);
        return response(['message', 'A single student displayed successfully!', 'Student', $student]);
    }

    //Edit Specific Student
    public function edit($id){
        $student = Student::find($id);
        // return view('students.edit', ['student' => $student]);
        return response(['message' => 'Details edited successfully!', 'Student' => $student]);
    }

    //Update Specific Student
    public function update(Request $request, $id){
        $student = Student::find($id);
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->phone = $request->input('phone');
        $student->address = $request->input('address');
        $student->dob = $request->input('dob');
        $student->gender = $request->input('gender');
        $student->age = $request->input('age');
        $student->nationality = $request->input('nationality');
        $student->city = $request->input('city');
        $student->state = $request->input('state');
        $student->country = $request->input('country');
        $student->course_score = $request->input('course_score');
        $student->course_id = $request->input('course_id');
        $student->save();
        return response(['message' => 'Student details updated successfully!', 'student' => $student]);
    }

    //Delete Specific Student
    public function delete($id){
        $student = Student::find($id);
        $student->delete();
        // return redirect('/students');
        // return redirect('/')->with('message', 'Student deleted successfully!', 'Student', $student);
        return response(['message' => 'Student deleted successfully!', 'Student' => $student]);
    }

    //Search Students
    public function search(Request $request)
    {
        try {
            // Get the search parameters from the request
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
    
            // Initialize a query builder for the Student model
            $query = Student::query();
    
            // Add conditions based on the provided parameters
            if ($name) {
                $query->orWhere('name', 'LIKE', "%{$name}%");
            }
    
            if ($email) {
                $query->orWhere('email', 'LIKE', "%{$email}%");
            }
    
            if ($phone) {
                $query->orWhere('phone', 'LIKE', "%{$phone}%");
            }
    
            // Get the results
            $students = $query->get();
    
            // Check if any students were found
            if ($students->isEmpty()) {
                return response(['message' => 'No students found.']);
            }
    
            // Return the students if found
            return response(['message' => 'Students found successfully!', 'Students' => $students]);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response(['error' => $e->getMessage()], 500);
        }
    }

    //Show Students in a Course
    public function showInCourse($id){
        $students = Student::where('course_id', $id)->get();
        // return view('students.index', ['students' => $students]);
        // return redirect('/')->with('message', 'Students displayed successfully!', 'Students', $students);
        return response(['message' => 'Students displayed successfully!', 'Students' => $students]);
    }
}
