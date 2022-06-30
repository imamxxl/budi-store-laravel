<?php

use App\Http\Controllers\admin\BarangController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\pimpinan\UserController;
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

// For Pimpinan

Route::get('/user', [UserController::class, 'index'])->name('user');
Route::post('/user/tambah_admin', [UserController::class, 'storeAdmin']);
Route::post('/user/tambah_pimpinan', [UserController::class, 'storePimpinan']);
Route::post('/user/edit/{id}', [UserController::class, 'update']);
Route::post('/user/delete/{id}', [UserController::class, 'destroy']);

// For Admin
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/barang', [BarangController::class, 'index'])->name('barang');
Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian');