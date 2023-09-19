<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\UserController;
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
  return view('welcome');
});

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(["prefix" => "admin", "namespace" => "admin", 'as' => 'admin.'], function () {
  Route::get('/', [AdminController::class, 'index'])->name('login');
  Route::post('/verifylogin', [AdminController::class, 'verifylogin'])->name('verifylogin');
  Route::get('/forget-password', [AdminController::class, 'forgetPassword'])->name('forget-password');
  Route::post('/forget-password', [AdminController::class, 'postForgetPassword'])->name('post-forget-password');
  Route::get('/password-reset/{token}',[AdminController::class, 'getResetPassword'])->name('form-reset-password');
  Route::post('/password-reset',[AdminController::class, 'postResetPassword'])->name('reset-password');  
  Route::group(['middleware' => 'admin'], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboardView'])->name('dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    
    //User
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user-list-table', [UserController::class, 'userListTable'])->name('user.list.table');
    Route::get('/add-user', [UserController::class, 'create'])->name('add-user');
    Route::post('/add-user', [UserController::class, 'store'])->name('add-user.post');
    Route::get('/edit-user/{subadmin_id}', [UserController::class, 'edit'])->name('edit-user');
    Route::put('/update-user/{subadmin_id}', [UserController::class, 'update'])->name('update.user');
    Route::get('/delete-user/{subadmin_id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('/reset-user-status/{encryptCode}', [UserController::class, 'resetuserStatus'])->name('reset-user-status');
  });
});
