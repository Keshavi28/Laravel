<?php
error_reporting(0);
use Illuminate\Support\Facades\Auth;
use App\Models\UserTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserTableController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user-form', [UserTableController::class,'form'])->name('user_form');
Route::post('/user-form', [UserTableController::class,'save'])->name('form.save');
Route::get('/user-delete/{id}', [UserTableController::class,'delete'])->name('user_delete');
