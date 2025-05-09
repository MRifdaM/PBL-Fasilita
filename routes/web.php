<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeranController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\DashboardController;

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


Route::get('/register', [AuthController::class,'showRegister'])->name('register');
Route::post('/register', [AuthController::class,'register'])->name('register.store');
Route::get('/login',    [AuthController::class,'showLogin'])->name('login');
Route::post('/login',   [AuthController::class,'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:ADM'])->group(function(){
        Route::prefix('peran')->group(function () {
            Route::get('/', [PeranController::class, 'index'])->name('peran.index');
            Route::get('/list', [PeranController::class, 'list'])->name('peran.list');
            Route::get('/show/{id}', [PeranController::class, 'show'])->name('peran.show');
            Route::get('/create', [PeranController::class, 'create'])->name('peran.create');
            Route::post('/store', [PeranController::class, 'store'])->name('peran.store');
            Route::get('/edit/{id}', [PeranController::class, 'edit'])->name('peran.edit');
            Route::post('/update/{id}', [PeranController::class, 'update'])->name('peran.update');
            Route::get('/delete/{id}', [PeranController::class, 'delete'])->name('peran.delete');
            Route::delete('/destroy/{id}', [PeranController::class, 'destroy'])->name('peran.destroy');
        });

        // Pengguna
        Route::prefix('pengguna')->group(function(){
            Route::get   ('/',[PenggunaController::class, 'index'])->name('pengguna.index');
            Route::get   ('/list', [PenggunaController::class, 'list'])->name('pengguna.list');
            Route::get   ('/create',[PenggunaController::class, 'create'])->name('pengguna.create');
            Route::get   ('/show/{id}',[PenggunaController::class, 'show'])->name('pengguna.show');
            Route::post  ('/store',[PenggunaController::class, 'store'])->name('pengguna.store');
            Route::get   ('/edit/{id}',[PenggunaController::class, 'edit'])->name('pengguna.edit');
            Route::put  ('/update/{id}',[PenggunaController::class, 'update'])->name('pengguna.update');
            Route::get   ('/delete/{id}',[PenggunaController::class, 'confirm'])->name('pengguna.delete');
            Route::delete('/destroy/{id}',[PenggunaController::class, 'destroy'])->name('pengguna.destroy');
            Route::get  ('/import',      [PenggunaController::class, 'import'])->name('pengguna.import');
            Route::post ('/import_ajax', [PenggunaController::class, 'importAjax'])->name('pengguna.import_ajax');
            Route::get  ('/export_excel', [PenggunaController::class, 'exportExcel'])->name('pengguna.export_excel');
            Route::get  ('/export_pdf',   [PenggunaController::class, 'exportPdf'])->name('pengguna.export_pdf');
        });

        // Master Data Fisik: Gedung, Lantai, Ruangan
        Route::prefix('gedung')->group(function(){
            Route::get   ('/','GedungController@index')->name('gedung.index');
            Route::post  ('/store','GedungController@store')->name('gedung.store');
            Route::post  ('/update/{id}','GedungController@update')->name('gedung.update');
            Route::delete('/destroy/{id}','GedungController@destroy')->name('gedung.destroy');
        });
        Route::prefix('lantai')->group(function(){
            Route::get   ('/','LantaiController@index')->name('lantai.index');
            Route::post  ('/store','LantaiController@store')->name('lantai.store');
            Route::post  ('/update/{id}','LantaiController@update')->name('lantai.update');
            Route::delete('/destroy/{id}','LantaiController@destroy')->name('lantai.destroy');
        });
        Route::prefix('ruangan')->group(function(){
            Route::get   ('/','RuanganController@index')->name('ruangan.index');
            Route::post  ('/store','RuanganController@store')->name('ruangan.store');
            Route::post  ('/update/{id}','RuanganController@update')->name('ruangan.update');
            Route::delete('/destroy/{id}','RuanganController@destroy')->name('ruangan.destroy');
        });

        // Kategori Fasilitas & Kategori Kerusakan
        Route::prefix('kategori-fasilitas')->group(function(){
            Route::get   ('/','KategoriFasilitasController@index')->name('kategoriF.index');
            Route::post  ('/store','KategoriFasilitasController@store')->name('kategoriF.store');
            Route::post  ('/update/{id}','KategoriFasilitasController@update')->name('kategoriF.update');
            Route::delete('/destroy/{id}','KategoriFasilitasController@destroy')->name('kategoriF.destroy');
        });
        Route::prefix('kategori-kerusakan')->group(function(){
            Route::get   ('/','KategoriKerusakanController@index')->name('kategoriK.index');
            Route::post  ('/store','KategoriKerusakanController@store')->name('kategoriK.store');
            Route::post  ('/update/{id}','KategoriKerusakanController@update')->name('kategoriK.update');
            Route::delete('/destroy/{id}','KategoriKerusakanController@destroy')->name('kategoriK.destroy');
        });

        // Fasilitas
        Route::prefix('fasilitas')->group(function(){
            Route::get   ('/','FasilitasController@index')->name('fasilitas.index');
            Route::post  ('/store','FasilitasController@store')->name('fasilitas.store');
            Route::post  ('/update/{id}','FasilitasController@update')->name('fasilitas.update');
            Route::delete('/destroy/{id}','FasilitasController@destroy')->name('fasilitas.destroy');
        });

        // Status (master)
        Route::prefix('status')->group(function(){
            Route::get   ('/','StatusController@index')->name('status.index');
            Route::post  ('/store','StatusController@store')->name('status.store');
            Route::post  ('/update/{id}','StatusController@update')->name('status.update');
            Route::delete('/destroy/{id}','StatusController@destroy')->name('status.destroy');
        });

        // Kriteria & Skoring Kriteria
        Route::prefix('kriteria')->group(function(){
            Route::get   ('/','KriteriaController@index')->name('kriteria.index');
            Route::post  ('/store','KriteriaController@store')->name('kriteria.store');
            Route::post  ('/update/{id}','KriteriaController@update')->name('kriteria.update');
            Route::delete('/destroy/{id}','KriteriaController@destroy')->name('kriteria.destroy');
        });
        Route::prefix('skoring-kriteria')->group(function(){
            Route::get   ('/','SkoringKriteriaController@index')->name('skoring.index');
            Route::post  ('/store','SkoringKriteriaController@store')->name('skoring.store');
            Route::post  ('/update/{id}','SkoringKriteriaController@update')->name('skoring.update');
            Route::delete('/destroy/{id}','SkoringKriteriaController@destroy')->name('skoring.destroy');
        });
    });
});
