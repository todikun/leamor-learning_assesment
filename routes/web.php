<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\LoginController;
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

Route::get('/', function () {
    return view('pages.home');
});


Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'loginAction'])->name('login.action');

Route::middleware('auth')->group(function(){
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // proyek
    Route::get('proyek/my', [ProyekController::class, 'myProyek'])->name('proyek.my');
    Route::get('proyek/{id}/copy', [ProyekController::class, 'copyProyek'])->name('proyek.copy');
    Route::get('proyek/{id}/undo', [ProyekController::class, 'undo'])->name('proyek.undo');
    Route::get('proyek/{id}/redo', [ProyekController::class, 'redo'])->name('proyek.redo');
    Route::get('proyek/deleted', [ProyekController::class, 'myProyekDelete'])->name('proyek.deleted');
    Route::resource('proyek', ProyekController::class);

    // soal
    Route::post('soal/submit/', [SoalController::class, 'createOrUpdateSoal'])->name('soal.create_update');
    Route::get('soal/open-akses/{id}', function(){
        return view('pages.teacher.soal.open-akses');
    });
    Route::post('soal/open-akses', [SoalController::class, 'openAksesStore'])->name('soal.open-akses.store');
    Route::resource('soal', SoalController::class);
});
