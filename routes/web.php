<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PembelianController;
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

// Route untuk Logina
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/cek-login', [LoginController::class, 'cekLogin'])->name('cek-login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Login dengan level pimpinan dan admin
Route::group(['middleware' => ['auth', 'ceklevel:pimpinan,admin']], function () {

    // Default Page
    Route::get('/', function () {
        return view('welcome');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Barang
    Route::get('/semua-barang', [BarangController::class, 'index'])->name('semua-barang');
    Route::post('/post-barang', [BarangController::class, 'postBarang'])->name('post-barang');
    Route::post('/update-barang/{id}', [BarangController::class, 'update'])->name('update-barang');
    Route::post('/post-stok/{id}', [BarangController::class, 'postStok'])->name('post-stok');
    Route::get('/recycle-barang', [BarangController::class, 'indexRecycle'])->name('recycle-barang');
    Route::get('/restore-barang/{id}', [BarangController::class, 'restore'])->name('restore-barang');
    Route::get('/delete-barang/{id}', [BarangController::class, 'delete'])->name('delete-barang');
    Route::get('/destroy-barang/{id}', [BarangController::class, 'destroy'])->name('destroy-barang');

    // transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::post('/post-belanja', [TransaksiController::class, 'postBelanja'])->name('post-belanja');
    Route::post('/post-pembelian', [TransaksiController::class, 'postPembelian'])->name('post-pembelian');

//    // belanja
//     Route::post('/post-chekout/{id}', [TransaksiController::class, 'postChekout'])->name('post-chekout');
//     Route::get('/barang', [BarangController::class, 'index'])->name('barang');
//     Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian');
});

// Login khusus untuk pimpinan
Route::group(['middleware' => ['auth', 'ceklevel:pimpinan']], function () {

    // CRUD User
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/post-admin', [UserController::class, 'postAdmin'])->name('post-admin');
    Route::post('/post-pimpinan', [UserController::class, 'postPimpinan'])->name('post-pimpinan');
    Route::post('/update-user/{id}', [UserController::class, 'update'])->name('update-user');
    Route::get('/delete-user/{id}', [UserController::class, 'delete'])->name('delete-user');
    Route::get('/recycle-user', [UserController::class, 'indexRecycle'])->name('recycle-user');
    Route::get('/restore-user/{id}', [UserController::class, 'restore'])->name('restore-user');
    Route::get('/destroy-user/{id}', [UserController::class, 'destroy'])->name('destroy-user');

});
