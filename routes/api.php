<?php

use App\Http\Controllers\api\ModuleAuthController;
use App\Http\Controllers\api\ModuleDashboardController;
use App\Http\Controllers\api\ModulePaymentGatewayController;
use App\Http\Controllers\api\ModulePelangganController;
use App\Http\Controllers\api\ModuleTagihanController;
use App\Http\Controllers\api\ModuleTagihanUserController;
use App\Http\Controllers\api\ModuleTransaksiController;
use Illuminate\Support\Facades\Route;

// MODULE AUTH
Route::post('/register', [ModuleAuthController::class, 'register']);
Route::post('/login', [ModuleAuthController::class, 'login']);
Route::post('/logout', [ModuleAuthController::class, 'logout'])->middleware(['jwt.client']);

// MODULE PAYMENT GATEWAY CALLBACK (PUBLIC FOR MIDTRANS)
Route::post('/midtrans-callback', [ModulePaymentGatewayController::class, 'midtransCallback']);

Route::middleware(['jwt.client'])->group(function () {
    // MODULE TAGIHAN (CRUD)
    Route::get('/tagihan', [ModuleTagihanController::class, 'index']);
    Route::post('/tagihan', [ModuleTagihanController::class, 'store']);
    Route::get('/tagihan/{id}', [ModuleTagihanController::class, 'show']);
    Route::put('/tagihan/{id}', [ModuleTagihanController::class, 'update']);
    Route::delete('/tagihan/{id}', [ModuleTagihanController::class, 'destroy']);

    // MODULE PELANGGAN (CRUD)
    Route::get('/pelanggan', [ModulePelangganController::class, 'index']);
    Route::post('/pelanggan', [ModulePelangganController::class, 'store']);
    Route::get('/pelanggan/{id}', [ModulePelangganController::class, 'show']);
    Route::put('/pelanggan/{id}', [ModulePelangganController::class, 'update']);
    Route::delete('/pelanggan/{id}', [ModulePelangganController::class, 'destroy']);

    // MODULE RELASI TAGIHAN & PELANGGAN (tagihan_user)
    Route::get('/tagihan-user', [ModuleTagihanUserController::class, 'index']);
    Route::post('/tagihan-user', [ModuleTagihanUserController::class, 'store']);
    Route::get('/tagihan-user/{id}', [ModuleTagihanUserController::class, 'show']);
    Route::put('/tagihan-user/{id}', [ModuleTagihanUserController::class, 'update']);
    Route::delete('/tagihan-user/{id}', [ModuleTagihanUserController::class, 'destroy']);

    // MODULE DASHBOARD
    Route::get('/dashboard', [ModuleDashboardController::class, 'index']);

    // API UNTUK MUTIARA
    Route::get('/billing/detail/{id}', [ModuleTagihanController::class, 'show']);
    Route::post('/transaksi', [ModuleTransaksiController::class, 'createTransaksi']);
    Route::put('/transaksi/status', [ModuleTransaksiController::class, 'updateStatusPembayaran']);

    // MODULE INPUT MANUAL (CASH)
    Route::post('/manual-cash', [ModuleTransaksiController::class, 'markManualCash']);

    // MODULE PAYMENT GATEWAY (MIDTRANS)
    Route::post('/create-payment', [ModulePaymentGatewayController::class, 'createPayment']);
});
