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
}
