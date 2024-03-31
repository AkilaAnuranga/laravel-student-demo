<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Services\Student\StudentFacade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia("Student/Index",[
            'students'=> StudentResource::collection(Student::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia("Student/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        StudentFacade::create($request);
        return to_route('student.index')
            ->with('message', 'Student was created');

    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return inertia("Student/Show",[
            'student'=> new StudentResource($student)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return inertia("Student/Edit",[
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        StudentFacade::update($request,$student);
        return to_route('student.show',$student)
            ->with('message', "Student \"$student->name\" was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        StudentFacade::delete($student);
        return redirect('/student')->with('message',"Student Deleted");
    }
}
