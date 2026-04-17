<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\TagihanUserController;
use App\Http\Controllers\admin\ModuleTagihanController;
use App\Http\Controllers\admin\ModulePelangganController;
use App\Http\Controllers\admin\PembayaranController;
use App\Http\Controllers\admin\PenggunaController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\StatusController;
use App\Http\Controllers\admin\AdminProfileSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LaporanController;

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

        // Pembayaran sewa
        Route::get('/pembayaran-sewa', [PembayaranController::class, 'index'])->name('Pembayaran.index');
        Route::get('/pembayaran-sewa/upload-bukti', [PembayaranController::class, 'uploadBukti'])->name('Pembayaran.uploadBukti');
        Route::post('/pembayaran-sewa/store-bukti', [PembayaranController::class, 'storeBukti'])->name('Pembayaran.storeBukti');
        Route::get('/pembayaran-sewa/{id}', [PembayaranController::class, 'detail'])->name('Pembayaran.detail');
        Route::get('/pembayaran-sewa/{id}/verifikasi', [PembayaranController::class, 'verifikasi'])->name('Pembayaran.verifikasi');
        Route::post('/pembayaran-sewa/store-verifikasi', [PembayaranController::class, 'storeVerifikasi'])->name('Pembayaran.storeVerifikasi');
        Route::delete('/pembayaran-sewa/{id}', [PembayaranController::class, 'destroy'])->name('Pembayaran.destroy');

        // Multi-user admin & master role/status
        Route::get('/user-admin', [PenggunaController::class, 'index'])->name('User.index');
        Route::get('/user-admin/create', [PenggunaController::class, 'create'])->name('User.create');
        Route::post('/user-admin', [PenggunaController::class, 'store'])->name('User.store');
        Route::get('/user-admin/{id}/edit', [PenggunaController::class, 'edit'])->name('User.edit');
        Route::put('/user-admin/{id}', [PenggunaController::class, 'update'])->name('User.update');
        Route::delete('/user-admin', [PenggunaController::class, 'delete'])->name('User.delete');
        Route::get('/user-admin/detail', [PenggunaController::class, 'detail'])->name('User.detail');

        Route::get('/role', [RoleController::class, 'index'])->name('Role.index');
        Route::get('/role/create', [RoleController::class, 'create'])->name('Role.create');
        Route::post('/role', [RoleController::class, 'store'])->name('Role.store');
        Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('Role.edit');
        Route::put('/role/{id}', [RoleController::class, 'update'])->name('Role.update');
        Route::delete('/role', [RoleController::class, 'delete'])->name('Role.delete');
        Route::get('/role/detail', [RoleController::class, 'detail'])->name('Role.detail');

        Route::get('/status', [StatusController::class, 'index'])->name('status.index');
        Route::get('/status/create', [StatusController::class, 'create'])->name('status.create');
        Route::post('/status', [StatusController::class, 'store'])->name('status.store');
        Route::get('/status/{id}/edit', [StatusController::class, 'edit'])->name('status.edit');
        Route::put('/status/{id}', [StatusController::class, 'update'])->name('status.update');
        Route::delete('/status', [StatusController::class, 'delete'])->name('status.delete');
        Route::get('/status/detail', [StatusController::class, 'detail'])->name('status.detail');
        Route::post('/status/type', [StatusController::class, 'storeStatusType'])->name('status.storeType');
        Route::get('/status/type/combo', [StatusController::class, 'getComboJenisStatus'])->name('status.comboType');

        // Profil dan pengaturan admin
        Route::get('/profil-admin', [AdminProfileSettingController::class, 'profile'])->name('Admin.profile');
        // Laporan dan rekap pembayaran
        Route::get('/laporan', [LaporanController::class, 'index'])->name('Laporan.index');
        Route::put('/profil-admin', [AdminProfileSettingController::class, 'updateProfile'])->name('Admin.profile.update');
        Route::put('/profil-admin/password', [AdminProfileSettingController::class, 'updatePassword'])->name('Admin.profile.password');

        Route::get('/pengaturan-admin', [AdminProfileSettingController::class, 'settings'])->name('Admin.settings');
        Route::put('/pengaturan-admin', [AdminProfileSettingController::class, 'updateSettings'])->name('Admin.settings.update');
    });
});
