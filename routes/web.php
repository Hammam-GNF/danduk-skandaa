<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\OrtuController as ControllersOrtuController;
use App\Http\Controllers\Submenu\JurusanController;
use App\Http\Controllers\Submenu\KelasController;
use App\Http\Controllers\Submenu\WakelController;
use App\Http\Controllers\Submenu\SiswaController;
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
        //jurusan
        Route::resource('submenu/jurusan', JurusanController::class);
        //kelas
        Route::resource('submenu/kelas', KelasController::class);
        Route::post('/get-kelas', [KelasController::class, 'getkelas'])->name('get-kelas');
        // siswa
        Route::prefix('submenu/siswa')->group(function () {
            Route::get('/index/{id_kelas}', [SiswaController::class, 'index'])->name('submenu.siswa.index');
            Route::post('/store', [SiswaController::class, 'store'])->name('submenu.siswa.store');
            Route::post('/update/{id}', [SiswaController::class, 'update'])->name('submenu.siswa.update');
            Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('submenu.siswa.destroy');
            Route::post('/import/{id_kelas}', [SiswaController::class, 'import'])->name('submenu.siswa.import');
        });
        
        // Route::get('submenu/siswa/index2/{id_kelas}', [SiswaController::class, 'index2'])->name('submenu.siswa.index2');
        //PARENTING
        
        // Route::resource('parenting/ortu', ControllersOrtuController::class);

        // ===============
        
        // ===============
        // ===============
        // =================================AWFBUIFHOIAJAOD========================================
    });
});




// Route::prefix('Siswa')->middleware('isSiswa')->group(function () {
// });