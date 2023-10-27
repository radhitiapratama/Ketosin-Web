<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PemilihanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\TPSController;
use App\Http\Controllers\WaktuController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest'])->group(function () {
    Route::get("/", [AuthController::class, 'index'])->name("login");
    Route::post("login", [AuthController::class, 'login']);
});


Route::middleware(['auth'])->group(function () {
    Route::get("logout", [AuthController::class, 'logout']);

    Route::get("dashboard", [DashboardController::class, 'index']);
    Route::match(['get', 'post'], "kelas", [KelasController::class, 'index']);
    Route::get("kelas/add", [KelasController::class, 'add']);
    Route::post("kelas/store", [KelasController::class, 'store']);
    Route::get("kelas/edit/{id_kelas}", [KelasController::class, 'edit']);
    Route::post("kelas/update", [KelasController::class, 'update']);
    Route::post("kelas/import", [KelasController::class, 'import']);

    Route::match(['get', 'post'], "peserta", [PesertaController::class, 'index']);
    Route::get("peserta/add", [PesertaController::class, 'add']);
    Route::post("peserta/store", [PesertaController::class, 'store']);
    Route::get("peserta/edit/{id_peserta}", [PesertaController::class, 'edit']);
    Route::post("peserta/update", [PesertaController::class, 'update']);
    Route::post("peserta/import", [PesertaController::class, 'import']);

    Route::get("batas-waktu", [WaktuController::class, 'index']);
    Route::get("batas-waktu/add", [WaktuController::class, 'add']);
    Route::post("batas-waktu/store", [WaktuController::class, 'store']);
    Route::get("batas-waktu/edit/{id_waktu}", [WaktuController::class, 'edit']);
    Route::post("batas-waktu/update", [WaktuController::class, 'update']);

    Route::get("kandidat", [KandidatController::class, 'index']);
    Route::get("kandidat/add", [KandidatController::class, 'add']);
    Route::post("kandidat/store", [KandidatController::class, 'store']);
    Route::get("kandidat/edit/{id_kandidat}", [KandidatController::class, 'edit']);
    Route::post("kandidat/update", [KandidatController::class, 'update']);

    Route::match(['get', 'post'], "pemilihan", [PemilihanController::class, 'index']);

    Route::get("qr-code", [QrCodeController::class, 'index']);
    Route::post("qr-code/store", [QrCodeController::class, 'store']);

    Route::post("qr-code/cetak-qr", [QrCodeController::class, 'cetak']);

    Route::get("token-tps", [TPSController::class, 'index']);
});
