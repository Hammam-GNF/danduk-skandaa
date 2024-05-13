<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WakelController;
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

// Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::post('/actionlogin', [AuthController::class, 'actionLogin'])->name('actionLogin');
Route::post('/actionlogout', [AuthController::class, 'actionLogout'])->name('actionLogout');
Route::get('/error', [AuthController::class, 'error'])->name('error');

Route::middleware(['auth'])->group(function () {
    Route::middleware('CekLogin:1')->group(function () {
        // DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        // USER
        Route::resource('user', UserController::class);
        // WAKEL
        Route::resource('wakel', WakelController::class);
        // JURUSAN
        Route::resource('jurusan', JurusanController::class);
        // KELAS
        Route::resource('kelas', KelasController::class);

        // ===============
        
        // ===============
        // ===============
        // =================================AWFBUIFHOIAJAOD========================================
    });
});





// Route::prefix('Guru')->middleware('isGuru')->group(function () {
    
// });

// Route::prefix('Siswa')->middleware('isSiswa')->group(function () {
// });