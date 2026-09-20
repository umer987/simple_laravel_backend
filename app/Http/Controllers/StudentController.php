<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
class StudentController extends Controller
{
    function list(){
        return Student::all();
    }
    function addstudent(Request $req){
        $student = new Student();
        $student->name = $req->name;
        $student->email = $req->email;
        $student->batch = $req->batch;
        if($student->save()){
            return 'opration successfull';
        }else{
            return 'opration failed';
        }

    }

    function updatestudent(Request $req){
        $student = Student::find($req->id);
         $student->name = $req->name;
        $student->email = $req->email;
        $student->batch = $req->batch;
        if($student->save()){
            return 'update opration successfull';
        }else{
            return 'update opration failed';
        }
    }
    function deletestudent(Request $req){
        $student = Student::find($req->id);
        $student->delete();
        return 'student delete';
    }

 /**
     * 1️⃣ INDEX — Get all students (with optional search & pagination)
     * GET /api/students
     * GET /api/students?search=ali&page=2
     */
    public function index(Request $req)
    {
        $search = $req->query('search');

        $students = Student::when($search, function ($query, $search) {
                            return $query->where('name', 'like', "%{$search}%")
                                         ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return response()->json([
            'message'  => 'Students fetched successfully',
            'students' => $students,
        ], 200);
    }

    /**
     * 2️⃣ STORE — Create a new student
     * POST /api/students
     */
    public function store(Request $req)
    {
        // Validate input
        $validated = $req->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'batch' => 'required|string|max:50',
            'age'   => 'nullable|integer|min:1|max:120',
        ]);

        // Create student
        $student = Student::create($validated);

        return response()->json([
            'message' => 'Student created successfully',
            'student' => $student,
        ], 201); // 201 = Created
    }

    /**
     * 3️⃣ SHOW — Get one student by ID
     * GET /api/students/{id}
     */
    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Student fetched successfully',
            'student' => $student,
        ], 200);
    }

    /**
     * 4️⃣ UPDATE — Update an existing student
     * PUT /api/students/{id}
     */
    public function update(Request $req, $id)
    {
        // Find student
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
            ], 404);
        }

        // Validate (note: "sometimes" = only validate if present)
        $validated = $req->validate([
            'name'  => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:students,email,' . $id,
            'batch' => 'sometimes|required|string|max:50',
            'age'   => 'nullable|integer|min:1|max:120',
        ]);

        // Update
        $student->update($validated);

        return response()->json([
            'message' => 'Student updated successfully',
            'student' => $student,
        ], 200);
    }

    /**
     * 5️⃣ DESTROY — Delete a student
     * DELETE /api/students/{id}
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully',
            'id'      => $id,
        ], 200);
    }


}
