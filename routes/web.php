<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\OrtuController as ControllersOrtuController;
use App\Http\Controllers\Submenu\JurusanController;
use App\Http\Controllers\Submenu\KelasController;
use App\Http\Controllers\Submenu\WakelController;
use App\Http\Controllers\Parenting\SiswaController;
use App\Http\Controllers\Parenting\OrtuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Autasdh\LoginController;


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
        // SUBMENU
        Route::resource('submenu/wakel', WakelController::class);
        Route::resource('submenu/jurusan', JurusanController::class);
        Route::resource('submenu/kelas', KelasController::class);
        Route::post('/get-kelas', [KelasController::class, 'getkelas'])->name('get-kelas');
        //PARENTING
        Route::resource('parenting/siswa', SiswaController::class);
        Route::post('parenting/siswa/import', [SiswaController::class, 'import'])->name('parenting.siswa.import');
        // Route::resource('parenting/ortu', ControllersOrtuController::class);

        // ===============
        
        // ===============
        // ===============
        // =================================AWFBUIFHOIAJAOD========================================
    });
});




// Route::prefix('Siswa')->middleware('isSiswa')->group(function () {
// });