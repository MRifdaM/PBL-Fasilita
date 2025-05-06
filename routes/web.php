<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard.index');
});

Route::get('/register', [AuthController::class,'showRegister'])->name('register');
Route::post('/register', [AuthController::class,'register'])->name('register.store');
Route::get('/login',    [AuthController::class,'showLogin'])->name('login');
Route::post('/login',   [AuthController::class,'login'])->name('login.attempt');


Route::get('/peran', function () {
    return view('peran.index');
});
