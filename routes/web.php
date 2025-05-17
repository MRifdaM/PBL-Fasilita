<?php

use App\Models\SkoringKriteria;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SkoringKriteriaController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\LantaiController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KategoriFasilitasController;
use App\Http\Controllers\KategoriKerusakanController;




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


Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.attempt');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:ADM'])->group(function(){
        Route::prefix('peran')->group(function () {
            Route::get('/', [PeranController::class, 'index'])->name('peran.index');
            Route::get('/list', [PeranController::class, 'list'])->name('peran.list');
            Route::get('/show/{id}', [PeranController::class, 'show'])->name('peran.show');
            Route::get('/create', [PeranController::class, 'create'])->name('peran.create');
            Route::post('/store', [PeranController::class, 'store'])->name('peran.store');
            Route::get('/edit/{id}', [PeranController::class, 'edit'])->name('peran.edit');
            Route::put ('/update/{id}', [PeranController::class, 'update'])->name('peran.update');
            Route::get('/delete/{id}', [PeranController::class, 'delete'])->name('peran.delete');
            Route::delete('/destroy/{id}', [PeranController::class, 'destroy'])->name('peran.destroy');
        });

        Route::prefix('kategori_kerusakan')->group(function () {
            Route::get('/', [KategoriKerusakanController::class, 'index'])->name('kategori_kerusakan.index');
            Route::get('/list', [KategoriKerusakanController::class, 'list'])->name('kategori_kerusakan.list');
            Route::get('/show/{id}', [KategoriKerusakanController::class, 'show'])->name('kategori_kerusakan.show');
            Route::get('/create', [KategoriKerusakanController::class, 'create'])->name('kategori_kerusakan.create');
            Route::post('/store', [KategoriKerusakanController::class, 'store'])->name('kategori_kerusakan.store');
            Route::get('/edit/{id}', [KategoriKerusakanController::class, 'edit'])->name('kategori_kerusakan.edit');
            Route::put('/update/{id}', [KategoriKerusakanController::class, 'update'])->name('kategori_kerusakan.update');
            Route::get('/delete/{id}', [KategoriKerusakanController::class, 'delete'])->name('kategori_kerusakan.delete');
            Route::delete('/destroy/{id}', [KategoriKerusakanController::class, 'destroy'])->name('kategori_kerusakan.destroy');
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
        /* ----------  GEDUNG  ---------- */

        Route::prefix('gedung')->name('gedung.')->group(function () {

            Route::get('/',                [GedungController::class,'index'])->name('index');
            Route::get('/list',            [GedungController::class,'list'])->name('list');
            Route::get('/create',          [GedungController::class,'create'])->name('create');
            Route::post('/store',          [GedungController::class,'store'])->name('store');

            /* modal edit & hapus */
            Route::get('/{gedung}/edit',   [GedungController::class,'edit'])->name('edit');
            Route::get('/{gedung}/delete', [GedungController::class,'delete'])->name('delete');

            /* simpan edit & eksekusi hapus */
            Route::put('/{gedung}',        [GedungController::class,'update'])->name('update');   // ← ganti {id} → {gedung}
            Route::delete('/{gedung}',     [GedungController::class,'destroy'])->name('destroy'); // ← ganti {id} → {gedung}
        });

        // 1️⃣ Daftar & Tambah Lantai untuk satu Gedung
        Route::prefix('gedung/{gedung}/lantai')
            ->name('gedung.lantai.')
            ->group(function () {
                Route::get('/',       [LantaiController::class,'index'])->name('index');
                Route::get('list',    [LantaiController::class,'list'])->name('list');
                Route::get('create',  [LantaiController::class,'create'])->name('create');
                Route::post('store',  [LantaiController::class,'store'])->name('store');
            }
        );

        // 2️⃣ Akses langsung satu Lantai (Edit / Update / Delete / Show)
        Route::prefix('lantai')->name('lantai.')->group(function () {
            // modal edit (GET /lantai/{id}/edit)
            Route::get('{lantai}/edit', [LantaiController::class,'edit'])->name('edit');

            // ★ ganti jadi PUT /lantai/update/{id} ★
            Route::put('update/{lantai}', [LantaiController::class,'update'])->name('update');

            // modal delete (GET /lantai/{id}/delete)
            Route::get('{lantai}/delete', [LantaiController::class,'delete'])->name('delete');

            // ★ ganti jadi DELETE /lantai/delete/{id} ★
            Route::delete('delete/{lantai}', [LantaiController::class,'destroy'])->name('destroy');
        });
        // … pastikan import di atas …

        /*
        |--------------------------------------------------------------------------
        | Nested: RUANGAN di dalam LANTAI
        |--------------------------------------------------------------------------
        */

        Route::prefix('lantai/{lantai}/ruangan')
            ->name('lantai.ruangan.')
            ->group(function(){
                Route::get('/',      [RuanganController::class,'index'])->name('index');
                Route::get('list',   [RuanganController::class,'list'])->name('list');
                Route::get('create', [RuanganController::class,'create'])->name('create');
                Route::post('store', [RuanganController::class,'store'])->name('store');
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Direct CRUD: RUANGAN
        |--------------------------------------------------------------------------
        */
        Route::prefix('ruangan')
            ->name('ruangan.')
            ->group(function () {
                // Modal edit (GET /ruangan/13/edit)
                Route::get('{ruangan}/edit',    [RuanganController::class,'edit'])->name('edit');

                // Update (PUT /ruangan/update/13)
                Route::put('update/{ruangan}',  [RuanganController::class,'update'])->name('update');

                // Modal delete (GET /ruangan/13/delete)
                Route::get('{ruangan}/delete',   [RuanganController::class,'delete'])->name('delete');

                // Destroy (DELETE /ruangan/delete/13)
                Route::delete('delete/{ruangan}',[RuanganController::class,'destroy'])->name('destroy');

                // Show (GET /ruangan/13)
                Route::get('{ruangan}',          [RuanganController::class,'show'])->name('show');

            }
        );

        // Nested: Fasilitas di dalam Ruangan
        Route::prefix('ruangan/{ruangan}/fasilitas')
            ->name('ruangan.fasilitas.')
            ->group(function(){
                Route::get('/',       [FasilitasController::class,'index'])->name('index');
                Route::get('list',    [FasilitasController::class,'list'])->name('list');
                Route::get('create',  [FasilitasController::class,'create'])->name('create');
                Route::post('store',  [FasilitasController::class,'store'])->name('store');
            }
        );

        // CRUD langsung Fasilitas
        Route::prefix('fasilitas')
            ->name('fasilitas.')
            ->group(function(){
                // form edit
                Route::get('{fasilitas}/edit',   [FasilitasController::class,'edit'])->name('edit');
                // update = PUT /fasilitas/update/{id}
                Route::put('update/{fasilitas}', [FasilitasController::class,'update'])->name('update');
                // form delete
                Route::get('{fasilitas}/delete', [FasilitasController::class,'delete'])->name('delete');
                // destroy = DELETE /fasilitas/delete/{id}
                Route::delete('delete/{fasilitas}', [FasilitasController::class,'destroy'])->name('destroy');
                // detail show
                Route::get('{fasilitas}',        [FasilitasController::class,'show'])->name('show');
            }
        );

        /* -----------------------------------------------------------------
         |  FASILITAS (akses langsung: edit / update / delete)
         |------------------------------------------------------------------*/
        Route::prefix('fasilitas')->name('fasilitas.')->group(function () {
            Route::get('/{fasilitas}/edit', [FasilitasController::class, 'edit'])->name('edit');
            Route::put('/{fasilitas}',      [FasilitasController::class, 'update'])->name('update');
            Route::delete('/{fasilitas}',   [FasilitasController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('lantai')->group(function () {
            Route::get('/', 'LantaiController@index')->name('lantai.index');
            Route::post('/store', 'LantaiController@store')->name('lantai.store');
            Route::post('/update/{id}', 'LantaiController@update')->name('lantai.update');

        });
        Route::prefix('ruangan')->group(function () {
            Route::get('/', 'RuanganController@index')->name('ruangan.index');
            Route::post('/store', 'RuanganController@store')->name('ruangan.store');
            Route::post('/update/{id}', 'RuanganController@update')->name('ruangan.update');
        });

        // Kategori Fasilitas & Kategori Kerusakan
        Route::prefix('kategori-fasilitas')->group(function () {
            Route::get('/', [KategoriFasilitasController::class, 'index'])->name('kategoriF.index');
            Route::get('/list', [KategoriFasilitasController::class, 'list'])->name('kategoriF.list');
            Route::get('/show/{id}', [KategoriFasilitasController::class, 'show'])->name('kategoriF.show');
            Route::get('/create', [KategoriFasilitasController::class, 'create'])->name('kategoriF.create');
            Route::post('/store', [KategoriFasilitasController::class, 'store'])->name('kategoriF.store');
            Route::get('/edit/{id}', [KategoriFasilitasController::class, 'edit'])->name('kategoriF.edit');
            Route::put('/update/{id}', [KategoriFasilitasController::class, 'update'])->name('kategoriF.update');
            Route::get('/delete/{id}', [KategoriFasilitasController::class, 'delete'])->name('kategoriF.delete');
            Route::delete('/destroy/{id}', [KategoriFasilitasController::class, 'destroy'])->name('kategoriF.destroy');
        });

        // Fasilitas
        Route::prefix('fasilitas')->group(function () {
            Route::get('/', 'FasilitasController@index')->name('fasilitas.index');
            Route::post('/store', 'FasilitasController@store')->name('fasilitas.store');
            Route::post('/update/{id}', 'FasilitasController@update')->name('fasilitas.update');

        });

        // Laporan
        Route::prefix('laporan')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
            Route::get('/list', [LaporanController::class, 'list'])->name('laporan.list');
            Route::get('/show/{id}', [LaporanController::class, 'show'])->name('laporan.show');
            Route::get('/create', [LaporanController::class, 'create'])->name('laporan.create');
            Route::post('/store', [LaporanController::class, 'store'])->name('laporan.store');
            Route::get('/edit/{id}', [LaporanController::class, 'edit'])->name('laporan.edit');
            Route::put('/update/{id}', [LaporanController::class, 'update'])->name('laporan.update');
            Route::get('/delete/{id}', [LaporanController::class, 'delete'])->name('laporan.delete');
            Route::delete('/destroy/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
            Route::get('/get-lantai/{idGedung}', [LaporanController::class, 'getLantai']);
            Route::get('/get-ruangan/{idLantai}', [LaporanController::class, 'getRuangan']);

        });

        // Status (master)
        Route::prefix('status')->group(function () {
            Route::get('/', 'StatusController@index')->name('status.index');
            Route::post('/store', 'StatusController@store')->name('status.store');
            Route::post('/update/{id}', 'StatusController@update')->name('status.update');
            Route::delete('/destroy/{id}', 'StatusController@destroy')->name('status.destroy');
        });

        // Kriteria & Skoring Kriteria
        Route::prefix('kriteria')->group(function(){
            Route::get    ('/',[KriteriaController::class,'index'])->name('kriteria.index');
            Route::get    ('/list',[KriteriaController::class,'list'])->name('kriteria.list');
            Route::get    ('/show/{id}',[KriteriaController::class,'show'])->name('kriteria.show');
            Route::get    ('/create',[KriteriaController::class,'create'])->name('kriteria.create');
            Route::post   ('/store',[KriteriaController::class,'store'])->name('kriteria.store');
            Route::get    ('/edit/{id}',[KriteriaController::class,'edit'])->name('kriteria.edit');
            Route::put   ('/update/{id}',[KriteriaController::class,'update'])->name('kriteria.update');
            Route::get   ('/delete/{id}',[KriteriaController::class,'confirm'])->name('kriteria.confirm');
            Route::delete('/destroy/{id}',[KriteriaController::class,'destroy'])->name('kriteria.destroy');
        });

        Route::prefix('skoring-kriteria')->group(function(){
            Route::get   ('/',[SkoringKriteriaController::class, 'index'])->name('skoring.index');
            Route::get   ('/list/{id}',[SkoringKriteriaController::class, 'list'])->name('skoring.list');
            Route::get   ('/create/{id}',[SkoringKriteriaController::class, 'create'])->name('skoring.create');
            Route::post  ('/store/{id}',[SkoringKriteriaController::class, 'store'])->name('skoring.store');
            Route::get  ('/edit/{id}',[SkoringKriteriaController::class, 'edit'])->name('skoring.edit');
            Route::put  ('/update/{id}',[SkoringKriteriaController::class, 'update'])->name('skoring.update');
            Route::get('/delete/{id}',[SkoringKriteriaController::class, 'confirm'])->name('skoring.confirm');
            Route::delete('/destroy/{id}',[SkoringKriteriaController::class, 'destroy'])->name('skoring.destroy');

        });
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/update-photo', [ProfileController::class, 'update_photo'])->name('profile.update_photo');
        Route::post('/update-info', [ProfileController::class, 'update_info'])->name('profile.update_info');
        Route::post('/update-password', [ProfileController::class, 'update_password'])->name('profile.update_password');
    });

    Route::get('/icons', function () {
        return view('pages.icons.index');
    });

});


Route::get('/forms', function () {
    return view('pages.forms.index');
});
