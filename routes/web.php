<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\Administrasi\WakelController;
use App\Http\Controllers\Admin\Administrasi\TahunAjaranController;
use App\Http\Controllers\Admin\Administrasi\JurusanController;
use App\Http\Controllers\Admin\Administrasi\MapelController;
use App\Http\Controllers\Admin\Administrasi\PenggunaController;
use App\Http\Controllers\Admin\Datamaster\KelasController;
use App\Http\Controllers\Admin\Datamaster\SiswaController;
use App\Http\Controllers\Admin\Datamaster\PembelajaranController;
use App\Http\Controllers\Admin\Datamaster\SiswaPerKelasController;
use App\Http\Controllers\Admin\Result\NilaiController as ResultNilaiController;
use App\Http\Controllers\Admin\Result\PresensiController;
use App\Http\Controllers\Admin\Result\TampilanAdminController;
use App\Http\Controllers\Admin\Result\TranskripController;
use App\Http\Controllers\TampilanGuruController;
use App\Http\Controllers\TampilanKepsekController;
use App\Http\Controllers\TampilanWakelController;
use App\Http\Controllers\Wakel\Nilai\NilaiController as NilaiWakelController;
use App\Http\Controllers\Wakel\Presensi\PresensiController as PresensiWakelController;
use App\Http\Controllers\Wakel\Result\TranskripController as ResultTranskripController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/actionlogin', [AuthController::class, 'actionLogin'])->name('actionLogin');
Route::post('/actionlogout', [AuthController::class, 'actionLogout'])->name('actionLogout');
Route::get('/error', [AuthController::class, 'error'])->name('error');

Route::middleware(['auth'])->group(function () {
    Route::middleware('CekLogin:1')->group(function () {
        // DASHBOARD
        Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

        //PENGGUNA
        Route::prefix('admin/administrasi/pengguna')->group(function () {
            Route::get('/', [PenggunaController::class, 'index'])->name('admin.pengguna.index');
            Route::get('/create', [PenggunaController::class, 'create'])->name('admin.pengguna.create');
            Route::post('/', [PenggunaController::class, 'store'])->name('admin.pengguna.store');
            Route::get('/{user}/edit', [PenggunaController::class, 'edit'])->name('admin.pengguna.edit');
            Route::put('/{user}', [PenggunaController::class, 'update'])->name('admin.pengguna.update');
            Route::delete('/{user}', [PenggunaController::class, 'destroy'])->name('admin.pengguna.destroy');
            Route::post('/{user}/reset-password', [PenggunaController::class, 'resetPassword'])->name('admin.pengguna.resetPassword');
        });

        // TAHUN AJARAN
        Route::prefix('admin/administrasi/thajaran')->group(function () {
            Route::get('/', [TahunAjaranController::class, 'index'])->name('admin.thajaran.index');
            Route::get('/{id}', [TahunAjaranController::class, 'aktifkanTahunAjaran'])->name('admin.thajaran.aktifkan');
            Route::post('/', [TahunAjaranController::class, 'store'])->name('admin.thajaran.store');
            Route::get('/{thajaran}/edit', [TahunAjaranController::class, 'edit'])->name('admin.thajaran.edit');
            Route::put('/{thajaran}', [TahunAjaranController::class, 'update'])->name('admin.thajaran.update');
            Route::delete('/{thajaran}', [TahunAjaranController::class, 'destroy'])->name('admin.thajaran.destroy');
        });

        // JURUSAN
        Route::prefix('admin/administrasi/jurusan')->group(function () {
            Route::get('/', [JurusanController::class, 'index'])->name('admin.jurusan.index');
            Route::post('/', [JurusanController::class, 'store'])->name('admin.jurusan.store');
            Route::get('/{jurusan}/edit', [JurusanController::class, 'edit'])->name('admin.jurusan.edit');
            Route::put('/{jurusan}', [JurusanController::class, 'update'])->name('admin.jurusan.update');
            Route::delete('/{jurusan}', [JurusanController::class, 'destroy'])->name('admin.jurusan.destroy');
            Route::get('/check/{jurusan}', [JurusanController::class, 'checkRelatedData'])->name('admin.jurusan.check');
        });

        // MAPEL
        Route::prefix('admin/administrasi/mapel')->group(function () {
            Route::get('/', [MapelController::class, 'index'])->name('admin.mapel.index');
            Route::post('/', [MapelController::class, 'store'])->name('admin.mapel.store');
            Route::get('/{mapel}/edit', [MapelController::class, 'edit'])->name('admin.mapel.edit');
            Route::put('/{mapel}', [MapelController::class, 'update'])->name('admin.mapel.update');
            Route::delete('/{mapel}', [MapelController::class, 'destroy'])->name('admin.mapel.destroy');
        });

        // KELAS
        Route::prefix('admin/datamaster/kelas')->group(function () {
            Route::get('/', [KelasController::class, 'index'])->name('admin.kelas.index');
            Route::get('/jurusan/{thajaran_id}', [KelasController::class, 'getJurusanByThajaran'])->name('admin.kelas.getJurusanByThajaran');
            Route::get('/wakel/{thajaran_id}', [KelasController::class, 'getWakelByThajaran'])->name('admin.kelas.getWakelByThajaran');
            Route::post('/', [KelasController::class, 'store'])->name('admin.kelas.store');
            Route::get('/edit/{id}', [KelasController::class, 'edit'])->name('admin.kelas.edit');
            Route::put('/update/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
            Route::delete('/destroy/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
            Route::post('/get-kelas', [KelasController::class, 'getkelas'])->name('admin.kelas.get-kelas');
            Route::get('/check/{id}', [KelasController::class, 'checkRelatedData'])->name('admin.kelas.checkRelatedData');

            //siswa perkelas
            Route::get('/{id}', [SiswaController::class, 'showSiswaPerKelas'])->name('admin.siswaperkelas.index');

        });

        //WAKEL
        Route::prefix('admin/administrasi/wakel')->group(function () {
            Route::get('/', [WakelController::class, 'index'])->name('admin.wakel.index');
            Route::post('/', [WakelController::class, 'store'])->name('admin.wakel.store');
            Route::put('/{wakel}', [WakelController::class, 'update'])->name('admin.wakel.update');
            Route::delete('/{wakel}', [WakelController::class, 'destroy'])->name('admin.wakel.destroy');
            Route::get('/check/{id}', [WakelController::class, 'checkRelatedData'])->name('admin.wakel.check');
        });

        //SISWAPERKELAS
        Route::prefix('admin/datamaster/siswaperkelas')->group(function () {
            Route::get('/{id}/tambahsiswaperkelas', [SiswaPerKelasController::class, 'create'])->name('admin.siswaperkelas.create');
            Route::post('/', [SiswaPerKelasController::class, 'store'])->name('admin.siswaperkelas.store');
            Route::get('/{nis}/edit', [SiswaPerKelasController::class, 'edit'])->name('admin.siswaperkelas.edit');
            Route::put('/{nis}', [SiswaPerKelasController::class, 'update'])->name('admin.siswaperkelas.update');
            Route::delete('/{nis}{kelas_id}', [SiswaPerKelasController::class, 'destroy'])->name('admin.siswaperkelas.destroy');
            Route::post('/import', [SiswaPerKelasController::class, 'import'])->name('admin.siswa.import');
            Route::get('/{kelas_id}/getsiswaperkelas', [SiswaPerKelasController::class, 'getsiswaperkelas'])->name('admin.siswaperkelas.getsiswaperkelas');
        });

        // PEMBELAJARAN
        Route::prefix('admin/datamaster/pembelajaran')->group(function () {
            Route::get('/', [PembelajaranController::class, 'index'])->name('admin.pembelajaran.index');
            Route::post('/', [PembelajaranController::class, 'store'])->name('admin.pembelajaran.store');
            Route::put('/{pembelajaran}', [PembelajaranController::class, 'update'])->name('admin.pembelajaran.update');
            Route::delete('/{pembelajaran}', [PembelajaranController::class, 'destroy'])->name('admin.pembelajaran.destroy');
            Route::get('/mapel/{thajaran_id}', [PembelajaranController::class, 'getMapel']);
            Route::get('/getKelasByThajaran/{thajaran_id}', [SiswaController::class, 'getKelasByThajaran']);
            Route::get('/getWakel/{kelas_id}', [SiswaController::class, 'getWakel']);
        });

        // SISWA
        Route::prefix('admin/datamaster/siswa')->group(function () {
            Route::get('/', [SiswaController::class, 'index'])->name('admin.siswa.index');
            Route::get('/create', [SiswaController::class, 'create'])->name('admin.siswa.create');
            Route::post('/store', [SiswaController::class, 'store'])->name('admin.siswa.store');
            Route::get('/{nis}/edit', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
            Route::put('/update/{nis}', [SiswaController::class, 'update'])->name('admin.siswa.update');
            Route::delete('/destroy/{nis}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');
            Route::get('/export', [SiswaController::class, 'export'])->name('admin.siswa.export');

            Route::get('/getKelasByThajaran/{thajaran_id}', [SiswaController::class, 'getKelasByThajaran']);
            Route::get('/getWakel/{kelas_id}', [SiswaController::class, 'getWakel']);

        });

        //RESULT
        Route::prefix('admin/result')->group(function () {
            Route::get('/', [TampilanAdminController::class, 'indexhasil'])->name('admin.result.index');
            Route::get('/rekappresensi/{id}', [TampilanAdminController::class, 'rekapPresensi'])->name('admin.result.rekap.presensi');
            Route::get('/rekapnilai/{id}', [TampilanAdminController::class, 'rekapNilai'])->name('admin.result.rekap.nilai');
        });

        // PRESENSI
        Route::prefix('admin/result/presensi')->group(function () {
            Route::get('/', [PresensiController::class, 'indexpresensi'])->name('admin.presensi.indexpresensi');
            Route::get('/{id}', [PresensiController::class, 'indexrekappresensi'])->name('admin.presensi.indexrekappresensi');
            Route::get('{kelas}/export', [PresensiController::class, 'export'])->name('admin.presensi.export');
        });

        // NILAI
        Route::prefix('admin/result/nilai')->group(function () {
            Route::get('/', [ResultNilaiController::class, 'indexnilai'])->name('admin.nilai.indexnilai');
            Route::get('/{id}', [ResultNilaiController::class, 'indexrekapnilai'])->name('admin.nilai.indexrekapnilai');
            Route::get('{kelas}/export', [ResultNilaiController::class, 'export'])->name('admin.nilai.export');
        });

        Route::prefix('admin/result/transkrip')->group(function () {
            Route::get('/nilai', [TranskripController::class, 'indextranskrip'])->name('admin.result.indextranskripnilai');
            Route::get('/presensi', [TranskripController::class, 'indextranskripPresensi'])->name('admin.result.indextranskrippresensi');
            Route::get('/nilai/{id}', [TranskripController::class, 'rekaptranskrip'])->name('admin.result.nilai.rekaptranskrip');

            Route::post("/nilai/{id}/export-all" , [TranskripController::class , "exportNilaiAllPdf"])->name('admin.result.nilai.rekaptranskrip.export-all');
            Route::post("/nilai/{id}/export-all/excel" , [TranskripController::class , "exportNilaiAllExcel"])->name('admin.result.nilai.rekaptranskrip.export-excel');

            Route::post("/presensi/{id}/export-all" , [TranskripController::class , "presensiAllPdf"])->name('admin.result.presensi.rekaptranskrip.export-all');
            Route::post("/presensi/{id}/export-all/excel" , [TranskripController::class , "presensiAllExcel"])->name('admin.result.presensi.rekaptranskrip.export-excel');

            Route::get('/presensi/{id}', [TranskripController::class, 'rekaptranskripPresensi'])->name('admin.result.presensi.rekaptranskrip');
            Route::post("/presensi/export-pdf/all/{kelas_id}" , [TranskripController::class , "exportPdfPresensi"])->name('admin.result.presensi.rekaptranskrip.pdf');
            Route::get('/siswa/export/{id}', [TranskripController::class, 'exportPdfSiswa'])->name('admin.result.rekaptranskrip.siswa.pdf');
            Route::get('{kelas}/export', [TranskripController::class, 'exportpdf'])->name('admin.result.exportpdf');


        });

    });

    Route::middleware('CekLogin:2')->group(function () {
        Route::get('/dashboard/kepsek', [TampilanKepsekController::class, 'kepsekDashboard'])->name('kepsek.dashboard');

        Route::get('/daftarpengguna', [TampilanKepsekController::class, 'pengguna'])->name('kepsek.pengguna.index');
        Route::get('/tahunajaran', [TampilanKepsekController::class, 'thajaran'])->name('kepsek.thajaran.index');
        Route::get('/jurusan', [TampilanKepsekController::class, 'jurusan'])->name('kepsek.jurusan.index');
        Route::get('/mapel', [TampilanKepsekController::class, 'mapel'])->name('kepsek.mapel.index');

        Route::get('/kelas', [TampilanKepsekController::class, 'kelas'])->name('kepsek.kelas.index');
        Route::get('/wakel', [TampilanKepsekController::class, 'wakel'])->name('kepsek.wakel.index');
        Route::get('/siswa', [TampilanKepsekController::class, 'siswa'])->name('kepsek.siswa.index');
        Route::get('/pembelajaran', [TampilanKepsekController::class, 'pembelajaran'])->name('kepsek.pembelajaran.index');


        Route::get('/result', [TampilanKepsekController::class, 'result'])->name('kepsek.result.index');
        Route::get('/result/rekappresensi/{id}', [TampilanKepsekController::class, 'rekapPresensi'])->name('kepsek.result.rekappresensi');
        Route::get('/result/rekapnilai/{id}', [TampilanKepsekController::class, 'rekapNilai'])->name('kepsek.result.rekapnilai');


    });

    Route::middleware('CekLogin:3')->group(function () {
        // DASHBOARD
        Route::get('/dashboard/wakel', [TampilanWakelController::class, 'wakelDashboard'])->name('wakel.dashboard');

        Route::prefix('wakel/')->group(function () {
            Route::get('/mengajar/{roleId}', [TampilanWakelController::class, 'mengajar'])->name('wakel.mengajar');

            Route::get('/mengajar/presensi/hasilkelola/{id_pembelajaran}', [TampilanWakelController::class, 'hasilkelolapresensiwakel'])->name('wakel.presensi.hasilkelola');
            Route::get('/mengajar/nilai/hasilkelola/{id_pembelajaran}', [TampilanWakelController::class, 'hasilkelolanilaiwakel'])->name('wakel.nilai.hasilkelola');
            
            Route::get('/mengajar/presensi/kelola/{id_pembelajaran}', [TampilanWakelController::class, 'kelolapresensi'])->name('wakel.presensi.kelola');
            Route::get('/mengajar/nilai/kelola/{id_pembelajaran}', [TampilanWakelController::class, 'kelolanilai'])->name('wakel.nilai.kelola');

            Route::get('/hasilkelolapresensi/{roleId}', [TampilanWakelController::class, 'hasilkelolapresensi'])->name('wakel.pengelolaanpresensi');
            Route::get('/hasilkelolanilai/{roleId}', [TampilanWakelController::class, 'hasilkelolanilai'])->name('wakel.pengelolaannilai');
            
            Route::post('/storepresensi', [TampilanWakelController::class, 'storepresensi'])->name('wakel.presensi.store');
            Route::post('/storenilai', [TampilanWakelController::class, 'storenilai'])->name('wakel.nilai.store');


            Route::post("/presensi/{id}/export-all" , [TampilanWakelController::class , "presensiAllPdf"])->name('wakel.exportPresensiAllPdf');
            Route::post("/nilai/{id}/export-all" , [TampilanWakelController::class , "nilaiAllPdf"])->name('wakel.exportNilaiAllPdf');
            Route::get('/siswa/export/{nis}', [TampilanWakelController::class, 'exportPdfSiswa'])->name('admin.rekapNilaiSiswaPdf');



            Route::get('/{id}', [PresensiWakelController::class, 'indexwakel'])->name('wakel.presensi.indexwakel');
            Route::put('/update/{id}', [PresensiController::class, 'update'])->name('wakel.presensi.update');
            Route::delete('/{id}', [PresensiController::class, 'destroy'])->name('wakel.presensi.destroy');
            Route::get('{kelas}/export', [PresensiController::class, 'export'])->name('wakel.presensi.export');
            Route::post('{kelas}/all/export', [PresensiController::class, 'exportAll'])->name('wakel.presensi.export.all');
        });

        // NILAI
        Route::prefix('wakel/nilai')->group(function () {
            Route::get('/{id}', [NilaiWakelController::class, 'indexwakel'])->name('wakel.nilai.indexwakel');
            Route::put('{id}', [NilaiWakelController::class, 'update'])->name('wakel.nilai.update');
            Route::delete('{id}', [NilaiWakelController::class, 'destroy'])->name('wakel.nilai.destroy');
            Route::get('{kelas}/export', [NilaiWakelController::class, 'export'])->name('wakel.nilai.export');
            Route::post('{kelas}/all/export', [NilaiWakelController::class, 'exportAll'])->name('wakel.nilai.all.export');
        });

        //TRANSKRIP
        Route::prefix('wakel/result/transkrip')->group(function () {
            Route::get('/', [ResultTranskripController::class, 'indextranskrip'])->name('wakel.result.indextranskrip');
            Route::get('/{id}', [ResultTranskripController::class, 'rekaptranskrip'])->name('wakel.result.rekaptranskrip');
            Route::get('{kelas}/export', [ResultTranskripController::class, 'exportpdf'])->name('wakel.result.exportpdf');
        });
    });

    Route::middleware('CekLogin:4')->group(function () {
        // DASHBOARD
        Route::get('/dashboard/guru', [TampilanGuruController::class, 'guruDashboard'])->name('guru.dashboard');

        //PRESENSI
        Route::prefix('guru/')->group(function () {
            Route::get('/mengajar/{roleId}', [TampilanGuruController::class, 'mengajar'])->name('guru.mengajar');

            Route::get('/mengajar/presensi/kelola/{id_pembelajaran}', [TampilanGuruController::class, 'kelolapresensi'])->name('guru.presensi.kelola');
            Route::get('/mengajar/nilai/kelola/{id_pembelajaran}', [TampilanGuruController::class, 'kelolanilai'])->name('guru.nilai.kelola');

            Route::get('/mengajar/presensi/hasilkelola/{id_pembelajaran}', [TampilanGuruController::class, 'hasilkelolapresensiguru'])->name('guru.presensi.hasilkelola');
            Route::get('/mengajar/nilai/hasilkelola/{id_pembelajaran}', [TampilanGuruController::class, 'hasilkelolanilaiguru'])->name('guru.nilai.hasilkelola');
            
            Route::post('/storepresensi', [TampilanGuruController::class, 'storepresensi'])->name('guru.presensi.store');
            Route::post('/storenilai', [TampilanGuruController::class, 'storenilai'])->name('guru.nilai.store');
        });
    });
});
