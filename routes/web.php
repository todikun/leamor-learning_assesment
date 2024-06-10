<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\UserController;
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

Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return "Optimization cache cleared!";
});

Route::get('/optimize', function () {
    Artisan::call('optimize');
    return "Application optimized!";
});

Route::get('/route-clear', function () {
    Artisan::call('route:clear');
    return "Route cache cleared!";
});

Route::get('/config-clear', function () {
    Artisan::call('config:clear');
    return "Config cache cleared!";
});

Route::get('test', function(){
    // dd('ok');
    $soal = \App\Models\Soal::get()->first();
    // dd($soal);
    return view('pages.ujian.preview',compact('soal'));
});

Route::get('/migrate-fresh-seed', function () {
    Artisan::call('migrate:fresh', [
        '--seed' => true,
    ]);
    return "Database migrated and seeded!";
});

Route::get('/', function () {
    return view('pages.home');
});


Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'loginAction'])->name('login.action');

Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'registerStore'])->name('register.store');
Route::middleware('auth')->group(function(){
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('user', UserController::class);

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
                Route::post('{id}/nilai', 'previewNilai')->name('nilai');
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
                Route::get('{soalId}/{idUjian}/rank', 'rank')->name('rank');

                // feedback
                Route::get('{id}/feedback', 'feedbackForm')->name('feedback');
                Route::post('{id}/feedback', 'feedbackStore')->name('feedback_store');

                // koreksi
                Route::get('{id}/koreksi', 'koreksiForm')->name('koreksi');
                Route::post('{id}/koreksi', 'koreksiStore')->name('koreksi_store');

                // submit
                Route::get('{id}/submit', 'submit')->name('submit');

            });
    });

    // pdf
    Route::get('{id}/export/pdf', [RaporController::class,'exportPdf'])->name('export');

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

            // rapor
        Route::controller(RaporController::class)
            ->prefix('rapor')
            ->as('rapor.student.')
            ->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('{id}/detail', 'detail')->name('detail');
                Route::get('{soalId}/{idUjian}/rank', 'rank')->name('rank');
                Route::get('{id}/ujian', 'ujian')->name('ujian');
            });
    });
});
