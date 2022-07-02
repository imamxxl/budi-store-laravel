<?php

use App\Http\Controllers\admin\BarangController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\pimpinan\BarangController as PimpinanBarangController;
use App\Http\Controllers\pimpinan\PembelianController;
use App\Http\Controllers\pimpinan\UserController;
use App\Http\Middleware\CekLevel;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/cek-login', [LoginController::class, 'cekLogin'])->name('cek-login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'ceklevel:pimpinan,admin']], function () {
    // CRUD Barang
    Route::get('/pimpinan/barang', [PimpinanBarangController::class, 'index'])->name('crud-barang');
    Route::post('/pimpinan/barang/store', [PimpinanBarangController::class, 'store']);
    Route::post('/pimpinan/barang/update/{id}', [PimpinanBarangController::class, 'update']);
    Route::get('/pimpinan/barang/delete/{id}', [PimpinanBarangController::class, 'delete']);
    Route::get('/pimpinan/barang/trash', [PimpinanBarangController::class, 'indexTrash'])->name('barang-trash');
    Route::get('/pimpinan/barang/destroy/{id}', [PimpinanBarangController::class, 'destroy']);
    Route::post('/pimpinan/barang/tambah/{id}', [PimpinanBarangController::class, 'tambah']);
    Route::get('/pimpinan/barang/restore/{id}', [PimpinanBarangController::class, 'restore']);

    // Pembelian
    Route::get('/pimpinan/pembelian', [PembelianController::class, 'index'])->name('pembelian');

    // For Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/barang', [BarangController::class, 'index'])->name('barang');
    Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian');
});

Route::group(['middleware' => ['auth', 'ceklevel:pimpinan']], function () {
    // CRUD User
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/user/tambah_admin', [UserController::class, 'storeAdmin']);
    Route::post('/user/tambah_pimpinan', [UserController::class, 'storePimpinan']);
    Route::post('/user/update/{id}', [UserController::class, 'update']);
    Route::get('/user/delete/{id}', [UserController::class, 'delete']);
    Route::get('/user/trash', [UserController::class, 'indexTrash'])->name('trash');
    Route::get('/user/restore/{id}', [UserController::class, 'restore']);
    Route::get('/user/destroy/{id}', [UserController::class, 'destroy']);
});
