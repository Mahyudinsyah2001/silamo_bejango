<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\WargaBinaanController;
use App\Http\Controllers\AntrianAdminController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AntrianPublikController;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/informasi', [FrontendController::class, 'informasi'])->name('informasi');
Route::get('/kontak', [FrontendController::class, 'kontak'])->name('kontak');

Route::get('/informasi-sidang/download', [\App\Http\Controllers\FrontendController::class, 'downloadSidang'])->name('informasi_sidang.download');

Route::get('/ambil-antrian', [AntrianPublikController::class, 'create'])->name('antrian.create');
Route::post('/ambil-antrian', [AntrianPublikController::class, 'store'])->name('antrian.store')->middleware('throttle:5,1');
Route::get('/cek-antrian', [AntrianPublikController::class, 'cekStatus'])->name('antrian.cek');
Route::post('/cek-antrian', [AntrianPublikController::class, 'cariAntrian'])->name('antrian.cari')->middleware('throttle:5,1');
Route::get('/antrian/{antrian:kode_antrian}/sukses', [AntrianPublikController::class, 'show'])->name('antrian.sukses');
Route::get('/antrian/{antrian:kode_antrian}/cetak', [AntrianPublikController::class, 'cetak'])->name('antrian.cetak');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('sesi', SesiController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    
    Route::get('warga-binaan/template', [WargaBinaanController::class, 'downloadTemplate'])->name('warga-binaan.template');
    Route::post('warga-binaan/import', [WargaBinaanController::class, 'importCSV'])->name('warga-binaan.import');
    Route::delete('warga-binaan/destroy-all', [WargaBinaanController::class, 'destroyAll'])->name('warga-binaan.destroy-all');
    Route::resource('warga-binaan', WargaBinaanController::class);
    
        Route::prefix('antrian')->name('antrian.')->group(function () {
            Route::get('/', [AntrianAdminController::class, 'index'])->name('index');
            Route::get('/display', [AntrianAdminController::class, 'display'])->name('display');
            Route::get('/latest-dipanggil', [AntrianAdminController::class, 'getLatestDipanggil'])->name('latest');
            Route::get('/panggil-selanjutnya', [AntrianAdminController::class, 'panggilSelanjutnya'])->name('panggil-selanjutnya');
            Route::get('/statuses', [AntrianAdminController::class, 'getStatuses'])->name('statuses');
            Route::get('/{antrian}', [AntrianAdminController::class, 'show'])->name('show');
            Route::patch('/{antrian}/status', [AntrianAdminController::class, 'updateStatus'])->name('update-status');
            Route::post('/{antrian}/verifikasi', [AntrianAdminController::class, 'verifikasi'])->name('verifikasi');
            Route::delete('/{antrian}', [AntrianAdminController::class, 'destroy'])->name('destroy');
        });

    Route::resource('informasi-sidang', \App\Http\Controllers\InformasiSidangAdminController::class)->only(['index', 'store', 'destroy']);

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::post('/export-pdf', [LaporanController::class, 'exportPdf'])->name('export-pdf');
        Route::post('/export-excel', [LaporanController::class, 'exportExcel'])->name('export-excel');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
