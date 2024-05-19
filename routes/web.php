<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\DashboardController;

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

Route::get('phpinfo', function(){
    return phpinfo();
});

Route::get('test', function(){
    // dd('ok');
    $soal = \App\Models\Soal::get()->first();
    // dd($soal);
    return view('pages.ujian.preview',compact('soal'));
});

Route::get('/', function () {
    return view('pages.home');
});


Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'loginAction'])->name('login.action');

Route::middleware('auth')->group(function(){
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::group(['middleware'=>'teacherRole', 'prefix'=>'teacher'], function(){
        // proyek
        Route::controller(ProyekController::class)
            ->prefix('proyek')
            ->as('proyek.')
            ->group(function(){
                Route::get('my', 'myProyek')->name('my');
                Route::get('{id}/copy', 'copyProyek')->name('copy');
                Route::get('{id}/undo', 'undo')->name('undo');
                Route::get('{id}/redo', 'redo')->name('redo');
                Route::get('deleted', 'myProyekDelete')->name('deleted');
            });
        Route::resource('proyek', ProyekController::class);

        // soal
        Route::controller(SoalController::class)
            ->prefix('soal')
            ->as('soal.')
            ->group(function(){
                Route::post('submit', 'createOrUpdateSoal')->name('create_update');
                Route::get('open-akses/{id}', function(){
                    return view('pages.teacher.soal.open-akses');
                })->name('open-akses');
                Route::post('tmpfile', 'tmpFile')->name('tmpfile');
                Route::post('open-akses', 'openAksesStore')->name('open-akses.store');
                Route::get('{id}/preview', 'preview')->name('preview');
                Route::post('{id}/nilai', 'nilai')->name('nilai');
                Route::get('{id}/users', 'listUsers')->name('users');
            });
        Route::resource('soal', SoalController::class);

        // rapor
        Route::controller(RaporController::class)
            ->prefix('rapor')
            ->as('rapor.teacher.')
            ->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('{id}/detail', 'detail')->name('detail');
                Route::get('{id}/ujian', 'ujian')->name('ujian');
            });
    });

    Route::group(['middleware'=>'studentRole', 'prefix'=>'student'], function(){

        Route::get('ayo_tes', [ProyekController::class, 'siswa'])->name('ayo_tes');

        // ujian
        Route::controller(UjianController::class)
            ->prefix('ujian')
            ->as('ujian.')
            ->group(function(){
                Route::post('akses', 'cekAkses')->name('akses');
                Route::post('form', 'ujianForm')->name('form');
                Route::post('{id}/nilai_feedback', 'storeNilaiFeedback')->name('nilai_feedback');
                Route::post('{id}/nilai', 'storeNilai')->name('nilai');
                Route::get('{id}/mandiri', 'ujianMandiri')->name('mandiri');
            });
    });
});
