<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EngineerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//-------------------------- Engineer Routes ---------------------------------------
Route::get('/', [EngineerController::class, 'index'])->name('engineer.index');

Route::post('/store_engineer', [EngineerController::class, 'store'])->name('engineer.store');

Route::get('fetch_all', [EngineerController::class, 'fetchAll'])->name('engineer.fetchall');

//-------------------------- Employee Routes ---------------------------------------
Route::get('/employee', [EmployeeController::class, 'index']);
Route::post('/employee', [EmployeeController::class, 'store']);
Route::get('/fetch-employee', [EmployeeController::class, 'fetchEmployee']);
Route::get('/edit-employee/{id}', [EmployeeController::class, 'edit']);
Route::post('/update-employee/{id}', [EmployeeController::class, 'update']);
Route::delete('/delete-employee/{id}', [EmployeeController::class, 'destroy']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
