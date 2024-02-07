<?php

use App\Http\Controllers\LoginController;
// use App\Http\Controllers\Autasdh\LoginController;
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

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/actionlogin', [LoginController::class, 'actionLogin'])->name('actionLogin');
Route::post('/logout', [LoginController::class, 'actionLogout'])->name('actionLogout')->middleware('auth');
Route::get('/error', [LoginController::class, 'error'])->name('error');

Route::prefix('Admin')->middleware('isAdmin')->group(function () {
    // =================================DASHBOARD============================================
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
    // =================================AWFBUIFHOIAJAOD========================================
});

Route::prefix('Guru')->middleware('isGuru')->group(function () {
});

Route::prefix('Siswa')->middleware('isSiswa')->group(function () {
});