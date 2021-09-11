<?php

use App\Http\Controllers\AdminController;
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

Route::get('/', function () {
    return view('profile.userlogin');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/adminlogin',[AdminController::class,'AdminLog'])->name('admin.log');

Route::get('/user',[AdminController::class,'UserLog'])->name('user.log');

Route::get('/admindash',[AdminController::class,'AdminSignIn'])->name('admin.dash');
Route::post('/store/employee', [AdminController::class, 'EmployeeStore'])->name('store.employee');

Route::get('/employee/edit/{id}', [AdminController::class, 'Edit']);
Route::post('/update/employee/{id}', [AdminController::class, 'UpdateEmployee']);
Route::get('/delete/employee/{id}', [AdminController::class, 'DeleteEmployee']);
Route::get('/search',[AdminController::class, 'SearchEmployee']);

Route::get('/user/logout', [AdminController::class, 'Logout'])->name('user.logout');

