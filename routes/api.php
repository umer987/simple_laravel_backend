<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/students',[StudentController::class , 'list']);
Route::put('/update',[StudentController::class , 'updatestudent']);
Route::post('/add',[StudentController::class , 'addstudent']);
Route::delete('/delete',[StudentController::class , 'deletestudent']);

