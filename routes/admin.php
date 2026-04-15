<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\TagihanUserController;
use App\Http\Controllers\admin\ModuleTagihanController;
use App\Http\Controllers\admin\ModulePelangganController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cek_login:Admin|Super Admin']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('Dashboard.index');
        Route::get('/dashboard/permohonan-baru', [DashboardController::class, 'permohonanBaru'])->name('Dashboard.permohonanBaru');
        Route::get('/dashboard/permohonan-disetujui', [DashboardController::class, 'permohonanDisetujui'])->name('Dashboard.permohonanDisetujui');
        Route::get('/dashboard/tagihan-jatuh-tempo', [DashboardController::class, 'tagihanJatuhTempo'])->name('Dashboard.tagihanJatuhTempo');

        Route::get('/tagihan-user', [TagihanUserController::class, 'index'])->name('TagihanUser.index');
        Route::post('/tagihan-user', [TagihanUserController::class, 'store'])->name('TagihanUser.store');
        Route::put('/tagihan-user/{id}', [TagihanUserController::class, 'update'])->name('TagihanUser.update');
        Route::delete('/tagihan-user/{id}', [TagihanUserController::class, 'delete'])->name('TagihanUser.delete');

        // Module Tagihan CRUD
        Route::get('/module-tagihan', [ModuleTagihanController::class, 'index'])->name('ModuleTagihan.index');
        Route::get('/module-tagihan/create', [ModuleTagihanController::class, 'create'])->name('ModuleTagihan.create');
        Route::post('/module-tagihan', [ModuleTagihanController::class, 'store'])->name('ModuleTagihan.store');
        Route::get('/module-tagihan/{id}/edit', [ModuleTagihanController::class, 'edit'])->name('ModuleTagihan.edit');
        Route::put('/module-tagihan/{id}', [ModuleTagihanController::class, 'update'])->name('ModuleTagihan.update');
        Route::delete('/module-tagihan/{id}', [ModuleTagihanController::class, 'destroy'])->name('ModuleTagihan.destroy');

        // Module Pelanggan CRUD
        Route::get('/module-pelanggan', [ModulePelangganController::class, 'index'])->name('ModulePelanggan.index');
        Route::get('/module-pelanggan/create', [ModulePelangganController::class, 'create'])->name('ModulePelanggan.create');
        Route::post('/module-pelanggan', [ModulePelangganController::class, 'store'])->name('ModulePelanggan.store');
        Route::get('/module-pelanggan/{id}/edit', [ModulePelangganController::class, 'edit'])->name('ModulePelanggan.edit');
        Route::put('/module-pelanggan/{id}', [ModulePelangganController::class, 'update'])->name('ModulePelanggan.update');
        Route::delete('/module-pelanggan/{id}', [ModulePelangganController::class, 'destroy'])->name('ModulePelanggan.destroy');
    });
});
