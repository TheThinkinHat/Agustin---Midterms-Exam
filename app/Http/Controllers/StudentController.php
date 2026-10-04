<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Replaces the query and stats logic from dashboard.php
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Replaces the raw INNER JOIN and LIKE clauses[cite: 1]
        $students = Student::with('course')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($query) use ($search) {
                            $query->where('course_name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('last_name', 'asc')
            ->get();

        // Replaces the while-loop counting logic[cite: 1]
        $total_students = $students->count();
        $count_y1 = $students->where('year_level', 1)->count();
        $count_y2 = $students->where('year_level', 2)->count();
        $count_y3y4 = $students->whereIn('year_level', [3, 4])->count();

        return view('dashboard', compact('students', 'search', 'total_students', 'count_y1', 'count_y2', 'count_y3y4'));
    }

    // Displays the add student form
    public function create()
    {
        $courses = Course::all();

        return view('add_student', compact('courses'));
    }

    // Replaces the POST handling and validation in add_student.php[cite: 8]
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'regex:/^[a-zA-Z\s\'-]+$/'],
            'last_name' => ['required', 'regex:/^[a-zA-Z\s\'-]+$/'],
            'email' => 'required|email|unique:students,email',
            'year_level' => 'required|integer|between:1,4',
            'course_id' => 'required|exists:courses,course_id',
        ], [
            'first_name.regex' => 'Names should only contain letters, spaces, apostrophes, or hyphens.',
            'last_name.regex' => 'Names should only contain letters, spaces, apostrophes, or hyphens.',
            'email.unique' => 'A student with that email already exists.',
        ]);

        Student::create($validated);

        // Redirects with the flash message[cite: 8]
        return redirect()->route('dashboard')
            ->with('flash', "Student \"{$validated['first_name']} {$validated['last_name']}\" was added successfully!");
    }

    // Replaces the deletion logic in delete_student.php[cite: 2]
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $name = "{$student->first_name} {$student->last_name}";

        $student->delete();

        return redirect()->route('dashboard')
            ->with('flash', "Student \"{$name}\" was deleted successfully.");
    }

    // Displays the edit form
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $courses = Course::all();

        return view('edit_student', compact('student', 'courses'));
    }

    // Handles the POST/PUT request to update the record[cite: 3]
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'first_name' => ['required', 'regex:/^[a-zA-Z\s\'-]+$/'],
            'last_name' => ['required', 'regex:/^[a-zA-Z\s\'-]+$/'],
            'email' => 'required|email|unique:students,email,'.$id.',student_id',
            'year_level' => 'required|integer|between:1,4',
            'course_id' => 'required|exists:courses,course_id',
        ], [
            'first_name.regex' => 'Names should only contain letters, spaces, apostrophes, or hyphens.',
            'last_name.regex' => 'Names should only contain letters, spaces, apostrophes, or hyphens.',
            'email.unique' => 'A student with that email already exists.',
        ]);

        $student->update($validated);

        return redirect()->route('dashboard')
            ->with('flash', "Student record for \"{$validated['first_name']} {$validated['last_name']}\" was updated successfully!");
    }
}
