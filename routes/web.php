<?php

use App\Models\MasterLaporan;
use App\Models\TempNormaHasil;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PpController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\NamaPpController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SuratKorespondensi;
use App\Http\Controllers\TimKerjaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterIKUController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\NomorSuratController;
use App\Http\Controllers\NormaHasilController;
use App\Http\Controllers\MasterHasilController;
use App\Http\Controllers\MasterUnsurController;
use App\Http\Controllers\SatuanKerjaController;
use App\Http\Controllers\MasterTujuanController;
use App\Http\Controllers\PaguAnggaranController;
use App\Http\Controllers\PegawaiTugasController;
use App\Http\Controllers\WilayahKerjaController;
use App\Http\Controllers\MasterKinerjaController;
use App\Http\Controllers\MasterLaporanController;
use App\Http\Controllers\MasterPegawaiController;
use App\Http\Controllers\MasterSasaranController;
use App\Http\Controllers\ObjekKegiatanController;
use App\Http\Controllers\SuratSrikandiController;
use App\Http\Controllers\TimNormaHasilController;
use App\Http\Controllers\TimSuratTugasController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\MasterAnggaranController;
use App\Http\Controllers\MasterPimpinanController;
use App\Http\Controllers\MasterSubUnsurController;
use App\Http\Controllers\PelaksanaTugasController;
use App\Http\Controllers\TempNormaHasilController;
use App\Http\Controllers\TimKendaliMutuController;
use App\Http\Controllers\AdminKinerjaTimController;
use App\Http\Controllers\AdminRekapNilaiController;
use App\Http\Controllers\AktivitasHarianController;
use App\Http\Controllers\DataKepegawaianController;
use App\Http\Controllers\MasterUnitKerjaController;
use App\Http\Controllers\ObjekPengawasanController;
use App\Http\Controllers\AnalisKompetensiController;
use App\Http\Controllers\MasterHasilKerjaController;
use App\Http\Controllers\AdminRencanaKerjaController;
use App\Http\Controllers\Auth\SingleSignOnController;
use App\Http\Controllers\PegawaiKompetensiController;
use App\Http\Controllers\NormaHasilAcceptedController;
use App\Http\Controllers\SuratKorespondensiController;
use App\Http\Controllers\TargetIkuUnitKerjaController;
use App\Http\Controllers\ArsiparisNormaHasilController;
use App\Http\Controllers\ArsiparisSuratTugasController;
use App\Http\Controllers\PegawaiRencanaKerjaController;
use App\Http\Controllers\PenilaianBerjenjangController;
use App\Http\Controllers\PimpinanRencanKerjaController;
use App\Http\Controllers\UsulanSuratSrikandiController;
use App\Http\Controllers\AdminRencanaJamKerjaController;
use App\Http\Controllers\AnggaranRencanaKerjaController;
use App\Http\Controllers\ArsiparisKendaliMutuController;
use App\Http\Controllers\EvaluasiIkuUnitKerjaController;
use App\Http\Controllers\KetuaTimRencanaKerjaController;
use App\Http\Controllers\KodeKlasifikasiArsipController;
use App\Http\Controllers\PegawaiLaporanKinerjaController;
use App\Http\Controllers\RealisasiIkuUnitKerjaController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\AdminRealisasiJamKerjaController;
use App\Http\Controllers\LaporanObjekPengawasanController;
use App\Http\Controllers\InspekturRencanaJamKerjaController;
use App\Http\Controllers\InspekturPenilaianKinerjaController;
use App\Http\Controllers\InspekturRealisasiJamKerjaController;

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


    /**
     * ===========================================================================
     * Sistem Informasi Manajemen Pengawasan (SIMWAS)
     * ===========================================================================
    */
    //SSO and Auth Route
    Route::get('/auth/sso-bps', [SingleSignOnController::class, 'redirectToSingleSignOn']);
    Route::get('/auth/sso-bps/callback', [SingleSignOnController::class, 'handleSingleSignOnCallback']);
    Route::get('/signout/sso-bps', [SingleSignOnController::class, 'logout']);



    Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
    Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);
    Route::post('sign-out', [SingleSignOnController::class, 'logout'])->middleware('auth')->name('logout');
    Route::get('/auth-login', function () {
        return view('pages.auth-login', ['type_menu' => 'auth']);
    })->middleware('guest')->name('login');





/**
     * ---------------------------------------------------------------------------
     * PERLU AUTENTIKASI/LOGIN
     * ---------------------------------------------------------------------------
     * */

Route::group(['middleware'=>'auth'], function(){



    /**
     * ---------------------------------------------------------------------------
     * ADMIN
     * ---------------------------------------------------------------------------
     * */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'admin'])->name('dashboard');

        //Master Anggaran & Pagu Anggaran
        Route::resource('master-anggaran', MasterAnggaranController::class)->except(['show']);
        Route::resource('pagu-anggaran', PaguAnggaranController::class);

        //Master-pegawai
        Route::resource('master-pegawai', MasterPegawaiController::class);
        Route::get('master-pegawai/getPegawai/{nip}', [MasterPegawaiController::class, 'getPegawai']);
        Route::post('master-pegawai/import', [MasterPegawaiController::class, 'import']);

        //Master-pimpinan
        Route::resource('master-pimpinan', MasterPimpinanController::class);
        Route::post('master-pegawai/import', [MasterPegawaiController::class, 'import']);

        // Master Unsur, Sub Unsur, Hasil Kerja
        Route::resource('master-laporan', MasterLaporanController::class);
        Route::get('master-laporan/edit-status/{id}', [MasterLaporanController::class, 'editStatus']);
        Route::resource('master-kode-klasifikasi-arsip', KodeKlasifikasiArsipController::class);
        Route::get('master-kode-klasifikasi-arsip/edit-status/{id}', [KodeKlasifikasiArsipController::class, 'editStatus']);
        Route::resource('master-unsur', MasterUnsurController::class);
        Route::resource('master-subunsur', MasterSubUnsurController::class);
        Route::resource('master-hasil-kerja', MasterHasilKerjaController::class);
        Route::resource('master-kinerja', MasterKinerjaController::class);
        Route::get('master-kinerja/detail/{id}', [MasterKinerjaController::class, 'showMasterKinerja']);
        Route::get('master-kinerja/update/{id}', [MasterKinerjaController::class, 'update']);
        Route::get('master-subunsur/unsur/{id}',[MasterSubUnsurController::class, 'getSubUnsurByUnsur'])->middleware('auth');
        Route::get('master-hasil-kerja/detail/{id}',[MasterHasilKerjaController::class, 'showMasterHasilKerja'])->middleware('auth');
        Route::get('master-unsur/subunsur/{id}',[MasterUnsurController::class, 'getUnsurBySubUnsur'])->middleware('auth');

        //Unit Kerja - Satuan Kerja - Wilayah Kerja - Objek Kegiatan
        Route::resource('master-unit-kerja', MasterUnitKerjaController::class);
        Route::post('master-unit-kerja/import', [MasterUnitKerjaController::class, 'import']);
        Route::resource('master-satuan-kerja', SatuanKerjaController::class);
        Route::post('master-satuan-kerja/import', [SatuanKerjaController::class, 'import']);
        Route::resource('master-wilayah-kerja', WilayahKerjaController::class);
        Route::post('master-wilayah-kerja/import', [WilayahKerjaController::class, 'import']);
        Route::resource('objek-kegiatan', ObjekKegiatanController::class);
        Route::get('objek-kegiatan/count/{id}', [ObjekKegiatanController::class, 'unitkerja']);

        //Tujuan - Sasaran - IKU
        Route::resource('master-tujuan', MasterTujuanController::class);
        Route::resource('master-sasaran', MasterSasaranController::class);
        Route::resource('master-iku', MasterIKUController::class);
        Route::resource('master-hasil', MasterHasilController::class);

        //Rencana Kinerja Admin
        Route::resource('rencana-kinerja', AdminRencanaKerjaController::class);
        Route::put('rencana-kinerja/send/{id}', [AdminRencanaKerjaController::class, 'acceptRencanaKerja']);
        Route::put('rencana-kinerja/return/{id}', [AdminRencanaKerjaController::class, 'sendBackToKetuaTim']);
        Route::resource('tim-kerja', TimKerjaController::class);
        Route::get('tim-kerja/detail/{id}', [TimKerjaController::class, 'detail']);
        Route::put('tim-kerja/update/{id}', [TimKerjaController::class, 'updateTimKerja']);
        Route::post('tim-kerja/lock/{id}', [TimKerjaController::class, 'lockTimKerja']);
        Route::post('tim-kerja/unlock/{id}', [TimKerjaController::class, 'unlockTimKerja']);

        //Rencana Jam Kerja
        Route::get('rencana-jam-kerja/rekap', [AdminRencanaJamKerjaController::class, 'rekap']);
        Route::get('rencana-jam-kerja/pool', [AdminRencanaJamKerjaController::class, 'pool']);
        Route::get('rencana-jam-kerja/pool/{id}/{year}', [AdminRencanaJamKerjaController::class, 'show']);
        Route::get('rencana-jam-kerja/detail/{id}', [AdminRencanaJamKerjaController::class, 'detailTugas']);

        //Realisasi Jam Kerja
        Route::get('realisasi-jam-kerja/rekap', [AdminRealisasiJamKerjaController::class, 'rekap']);
        Route::get('realisasi-jam-kerja/pool', [AdminRealisasiJamKerjaController::class, 'pool']);
        Route::get('realisasi-jam-kerja/pool/{id}/{year}', [AdminRealisasiJamKerjaController::class, 'show']);
        Route::get('realisasi-jam-kerja/detail/{id}', [AdminRealisasiJamKerjaController::class, 'detailTugas']);

        //Kinerja Tim
        Route::resource('kinerja-tim', AdminKinerjaTimController::class);
        Route::get('kinerja-tim/{id}/{bulan}', [AdminKinerjaTimController::class, 'show']);

        //Rekap Nilai
        Route::resource('rekap-nilai', AdminRekapNilaiController::class);
    });





    /**
     * ---------------------------------------------------------------------------
     * PIMPINAN
     * ---------------------------------------------------------------------------
     * */
    //Rencana Kinerja
    Route::prefix('pimpinan')->name('pimpinan.')->group(function () {
        Route::resource('rencana-kinerja', PimpinanRencanKerjaController::class);
        Route::put('rencana-kinerja/accept/{id}', [PimpinanRencanKerjaController::class, 'accept']);
        Route::put('rencana-kinerja/return/{id}', [PimpinanRencanKerjaController::class, 'sendBackToKetuaTim']);
    });





    /**
     * ---------------------------------------------------------------------------
     * ANALIS SDM
     * ---------------------------------------------------------------------------
     * */

    Route::prefix('analis-sdm')->name('analis-sdm.')->group(function () {
        Route::get('/', [DashboardController::class, 'analis_sdm'])->name('dashboard');
        Route::get('pp-nonaktif', [PpController::class, 'ppNonaktif']);
        Route::resource('pp', PpController::class)->names([
            'index' => 'pp',
            'show' => 'st-kinerja.show',
        ]);
        Route::resource('namaPp', NamaPpController::class);
        Route::resource('kelola-kompetensi', AnalisKompetensiController::class);
        Route::resource('master-data-kepegawaian', DataKepegawaianController::class);
        Route::get('master-data-kepegawaian-nonaktif', [DataKepegawaianController::class, 'nonaktif']);
        Route::get('data-kepegawaian', [DataKepegawaianController::class, 'kelola']);
        Route::post('data-kepegawaian/import', [DataKepegawaianController::class, 'import']);
        Route::get('data-kepegawaian/export', [DataKepegawaianController::class, 'export']);
        Route::put('data-kepegawaian/editNilai/{id}', [DataKepegawaianController::class, 'editNilai']);
    });



    /**
     * ---------------------------------------------------------------------------
     * INSPEKTUR
     * ---------------------------------------------------------------------------
     * */
    Route::prefix('inspektur')->name('inspektur.')->group(function () {

        Route::get('/', [DashboardController::class, 'inspektur'])->name('dashboard');

        //Rencana Jam Kerja
        Route::get('rencana-jam-kerja/rekap', [InspekturRencanaJamKerjaController::class, 'rekap']);
        Route::get('rencana-jam-kerja/pool', [InspekturRencanaJamKerjaController::class, 'pool']);
        Route::get('rencana-jam-kerja/pool/{id}/{year}', [InspekturRencanaJamKerjaController::class, 'show']);
        Route::get('rencana-jam-kerja/detail/{id}', [InspekturRencanaJamKerjaController::class, 'detailTugas']);

        //Realisasi Jam Kerja
        Route::get('realisasi-jam-kerja/rekap', [InspekturRealisasiJamKerjaController::class, 'rekap']);
        Route::get('realisasi-jam-kerja/pool', [InspekturRealisasiJamKerjaController::class, 'pool']);
        Route::get('realisasi-jam-kerja/pool/{id}/{year}', [InspekturRealisasiJamKerjaController::class, 'show']);
        Route::get('realisasi-jam-kerja/detail/{id}', [InspekturRealisasiJamKerjaController::class, 'detailTugas']);

        //Penilaian Kinerja Pegawai
        Route::resource('penilaian-kinerja', InspekturPenilaianKinerjaController::class);
        Route::get('penilaian-kinerja/detail/{id}', [InspekturPenilaianKinerjaController::class, 'detail']);
        Route::get('penilaian-kinerja/{pegawai_dinilai}/{bulan}/{tahun}', [InspekturPenilaianKinerjaController::class, 'show']);
        Route::get('penilaian-kinerja/nilai/{id_pegawai}/{bulan}/{tahun}', [InspekturPenilaianKinerjaController::class, 'getNilai']);
        Route::get('penilaian-kinerja/export/{pegawai}/{bulan}/{tahun}', [InspekturPenilaianKinerjaController::class, 'export']);
    });



    /**
     * ---------------------------------------------------------------------------
     * PEGAWAI
     * ---------------------------------------------------------------------------
     * */

    Route::prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'pegawai'])->name('dashboard');
        Route::resource('rencana-kinerja', PegawaiRencanaKerjaController::class);
        Route::get('rencana-jam-kerja', [PegawaiRencanaKerjaController::class, 'rencanaJamKerja']);
        Route::put('rencana-kinerja/send/{id}', [PegawaiRencanaKerjaController::class, 'sendToAnalis']);
        Route::resource('tim-pelaksana', PegawaiTugasController::class);
        Route::resource('norma-hasil', NormaHasilController::class)->names([
                'index' => 'pegawai.norma-hasil.index',
                'create' => 'pegawai.norma-hasil.create',
                'store' => 'pegawai.norma-hasil.store',
                'show' => 'pegawai.norma-hasil.show',
                'edit' => 'pegawai.norma-hasil.edit',
                'update' => 'pegawai.norma-hasil.update',
                'destroy' => 'pegawai.norma-hasil.destroy',
        ]);
        Route::resource('kompetensi', PegawaiKompetensiController::class);

        //Aktivitas Harian
        Route::resource('aktivitas-harian', AktivitasHarianController::class);
        Route::get('aktivitas-harian/export/{bulan}/{tahun}', [AktivitasHarianController::class, 'export']);

        //Isi Realisasi
        Route::resource('realisasi', RealisasiController::class);

        //Penilaian Berjenjang
        Route::resource('nilai-berjenjang', PenilaianBerjenjangController::class);
        Route::get('nilai-berjenjang/nilai/{id}', [PenilaianBerjenjangController::class, 'getNilai']);
        Route::get('nilai-berjenjang/detail/{id}', [PenilaianBerjenjangController::class, 'detail']);
        Route::get('nilai-berjenjang/{pegawai_dinilai}/{bulan}/{tahun}', [PenilaianBerjenjangController::class, 'show']);
        Route::get('nilai-berjenjang/export/{pegawai}/{bulan}/{tahun}', [PenilaianBerjenjangController::class, 'export']);

        //Laporan Kinerja
        Route::resource('laporan-kinerja', PegawaiLaporanKinerjaController::class);

        //Tugas Tim
        Route::resource('tim/norma-hasil', TimNormaHasilController::class)->names([
            'index' => 'pegawai.tim.norma-hasil.index',
            'create' => 'pegawai.tim.norma-hasil.create',
            'store' => 'pegawai.tim.norma-hasil.store',
            'show' => 'pegawai.tim.norma-hasil.show',
            'edit' => 'pegawai.tim.norma-hasil.edit',
            'update' => 'pegawai.tim.norma-hasil.update',
            'destroy' => 'pegawai.tim.norma-hasil.destroy',
        ]);
        Route::resource('tim/surat-tugas', TimSuratTugasController::class)->names([
            'index' => 'pegawai.tim.surat-tugas.index',
            'create' => 'pegawai.tim.surat-tugas.create',
            'store' => 'pegawai.tim.surat-tugas.store',
            'show' => 'pegawai.tim.surat-tugas.show',
            'edit' => 'pegawai.tim.surat-tugas.edit',
            'update' => 'pegawai.tim.surat-tugas.update',
            'destroy' => 'pegawai.tim.surat-tugas.destroy',
        ]);
        Route::resource('tim/kendali-mutu', TimKendaliMutuController::class);
        Route::get('tim', [DashboardController::class, 'kinerjaTim']);
        Route::get('tim/surat-tugas/view/{nomor}', [TimSuratTugasController::class, 'view'])->name('tim.surat-tugas.view');
        Route::get('tim/norma-hasil/downloadUsulan/{id}', [TimNormaHasilController::class, 'downloadUsulan']);
        Route::get('tim/norma-hasil/viewLaporan/{id}/{jenis}', [TimNormaHasilController::class, 'viewLaporan']);
        Route::get('tim/kendali-mutu/download/{id}', [TimKendaliMutuController::class, 'download']);

        Route::get('usulan-surat-srikandi/download/{id}', [UsulanSuratSrikandiController::class, 'downloadUsulanSurat'])->name('usulan-surat-srikandi.download');

        Route::resource('usulan-surat/surat-tugas', UsulanSuratSrikandiController::class)->names([
            'index' => 'usulan-surat-srikandi.index',
            'show' => 'usulan-surat-srikandi.show',
            'update' => 'usulan-surat-srikandi.update',
            'create' => 'usulan-surat-srikandi.create',
            'store' => 'usulan-surat-srikandi.store',
        ]);
        Route::resource('usulan-surat/surat-korespondensi', SuratKorespondensiController::class)->names([
            'index' => 'usulan-surat-korespondensi.index',
            'show' => 'usulan-surat-korespondensi.show',
            'update' => 'usulan-surat-korespondensi.update',
            'create' => 'usulan-surat-korespondensi.create',
            'store' => 'usulan-surat-korespondensi.store',
        ]);
    });



    // Ketua Tim
    Route::prefix('ketua-tim')->name('ketua-tim.')->group(function () {
        Route::resource('rencana-kinerja', KetuaTimRencanaKerjaController::class);
        Route::put('rencana-kinerja/update/{id}', [KetuaTimRencanaKerjaController::class, 'update']);
        Route::put('rencana-kinerja/disable/{id}', [KetuaTimRencanaKerjaController::class, 'disableRencanaKerja']);
        Route::put('rencana-kinerja/send/{id}', [KetuaTimRencanaKerjaController::class, 'sendToAnalis']);
        Route::resource('tim-pelaksana', PegawaiTugasController::class);
        Route::resource('rencana-kinerja/proyek', ProyekController::class);
        Route::put('rencana-kinerja/proyek/update/{id}', [ProyekController::class, 'update']);
        Route::resource('norma-hasil', NormaHasilAcceptedController::class)->names([
            'index' => 'usulan-norma-hasil.index',
            'show' => 'usulan-norma-hasil.show',
            'update' => 'usulan-norma-hasil.update',
            'create' => 'usulan-norma-hasil.create',
            'store' => 'usulan-norma-hasil.store',
        ]);
        Route::get('objek-pengawasan/detail/{id}', [ObjekPengawasanController::class, 'detailObjekPengawasan']);
    });

    Route::get('/objek-bykategori/{id}', [ObjekKegiatanController::class, 'objekByKategori']);
    Route::resource('/objek-pengawasan', ObjekPengawasanController::class);
    Route::get('/objek-pengawasan-search/', [ObjekPengawasanController::class, 'getObjekPengawasan']);
    Route::get('/objek-pengawasan/laporan/{id}', [LaporanObjekPengawasanController::class, 'getLaporanObjekPengawasan']);

    Route::resource('/anggaran-rencana-kerja', AnggaranRencanaKerjaController::class);
    Route::resource('/pelaksana-tugas', PelaksanaTugasController::class);
    Route::get('/tugas', [TugasController::class, 'getRencanaKerja']);
    Route::get('/tugas-list', [TugasController::class, 'getRencanaKerjaList']);
    // migrate norma hasil
    Route::get('/norma-hasil/migrate', [TempNormaHasilController::class, 'migrateNormaHasil']);




    // Templating dokumen
    Route::get('word', function () {
        return view('word');
    });
    Route::post('word', [WordController::class, 'index'])->name('word.index');

    /**
     * ---------------------------------------------------------------------------
     * SEKRETARIS
     * ---------------------------------------------------------------------------
     * */

    //  Surat Srikandi
    Route::prefix('sekretaris')->name('sekretaris.')->group(function () {
        Route::get('/', [DashboardController::class, 'sekretaris'])->name('dashboard');
        Route::resource('surat-srikandi', SuratSrikandiController::class);
        Route::put('surat-srikandi/decline/{id}', [SuratSrikandiController::class, 'declineUsulanSurat'])->name('surat-srikandi.decline');
        Route::get('surat-srikandi/download/{id}', [SuratSrikandiController::class, 'downloadSuratSrikandi'])->name('surat-srikandi.download');
        Route::put('surat-srikandi/batal/{id}', [SuratSrikandiController::class, 'batalSuratSrikandi']);
        Route::get('arsip-surat', [SuratSrikandiController::class, 'arsip'])->name('surat-srikandi.arsip');
        Route::resource('nomor-surat', NomorSuratController::class);
        Route::resource('surat', SuratController::class);
    });



    /**
     * ---------------------------------------------------------------------------
     * PERENCANA
     * ---------------------------------------------------------------------------
     * */
    Route::prefix('perencana')->name('perencana.')->group(function () {
        Route::get('/', [DashboardController::class, 'perencana'])->name('dashboard');
        Route::resource('target-iku-unit-kerja', TargetIkuUnitKerjaController::class);
        Route::resource('realisasi-iku-unit-kerja', RealisasiIkuUnitKerjaController::class);
        Route::resource('evaluasi-iku-unit-kerja', EvaluasiIkuUnitKerjaController::class);
        Route::put('target-iku-unit-kerja/status/{id}', [TargetIkuUnitKerjaController::class, 'editStatus'])->name('target-iku-unit-kerja.status');
    });

    /**
     * ---------------------------------------------------------------------------
     * ARSIPARIS
     * ---------------------------------------------------------------------------
     * */
    Route::prefix('arsiparis')->name('arsiparis.')->group(function () {
        Route::get('/', [DashboardController::class, 'arsiparis'])->name('dashboard');
        Route::resource('norma-hasil', ArsiparisNormaHasilController::class);
        Route::get('norma-hasil/edit/{id}', [ArsiparisNormaHasilController::class, 'edit']);
        Route::put('norma-hasil/update-norma-hasil/{id}', [ArsiparisNormaHasilController::class, 'updateNormaHasil'])->name('norma-hasil.update-norma-hasil');
        Route::resource('surat-tugas', ArsiparisSuratTugasController::class);
        Route::resource('kendali-mutu', ArsiparisKendaliMutuController::class);
    });

});


Route::redirect('/', '/pegawai/dashboard')->name('dashboard');

// If in production, force https
if (App::environment('production')) {
    URL::forceScheme('https');
}
