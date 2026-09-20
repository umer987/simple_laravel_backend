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



}
