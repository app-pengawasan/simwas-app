<?php

use App\Http\Controllers\AdminRencanaKerjaController;
use App\Http\Controllers\AnggaranRencanaKerjaController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SatuanKerjaController;
use App\Http\Controllers\PaguAnggaranController;
use App\Http\Controllers\WilayahKerjaController;
use App\Http\Controllers\MasterPegawaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\MasterAnggaranController;
use App\Http\Controllers\MasterHasilController;
use App\Http\Controllers\MasterIKUController;
use App\Http\Controllers\MasterPimpinanController;
use App\Http\Controllers\StKinerjaController;
use App\Http\Controllers\NormaHasilController;
use App\Http\Controllers\StpController;
use App\Http\Controllers\StpdController;
use App\Http\Controllers\SlController;
use App\Http\Controllers\KirimController;
use App\Http\Controllers\EksternalController;
use App\Http\Controllers\NomorSuratController;
use App\Http\Controllers\SlSekreController;
use App\Http\Controllers\NormaHasilSekreController;
use App\Http\Controllers\PpController;
use App\Http\Controllers\NamaPpController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\InspekturStpController;
use App\Http\Controllers\InspekturStpdController;
use App\Http\Controllers\InspekturStKinerjaController;
use App\Http\Controllers\KetuaTimRencanaKerjaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\MasterSasaranController;
use App\Http\Controllers\MasterTujuanController;
use App\Http\Controllers\MasterUnitKerjaController;
use App\Http\Controllers\ObjekKegiatanController;
use App\Http\Controllers\ObjekPengawasanController;
use App\Http\Controllers\PegawaiRencanaKerjaController;
use App\Http\Controllers\PegawaiTugasController;
use App\Http\Controllers\PelaksanaTugasController;
use App\Http\Controllers\PimpinanRencanKerjaController;
use App\Http\Controllers\TimKerjaController;
use App\Http\Controllers\TugasController;

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
 * Simwas here...
 * ===========================================================================
*/
//SSO and Auth Route
Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);

Route::post('sign-out', [SessionController::class, 'destroy'])->middleware('auth')->name('logout');

/**
 * ---------------------------------------------------------------------------
 * ADMIN
 * ---------------------------------------------------------------------------
 * */
Route::get('/admin', function(){return view('admin.index', ['type_menu' => 'dashboard']);})->middleware('auth')->name('admin-dashboard');

//Kelola-anggaran
//1.Master Anggaran
Route::resource('/admin/master-anggaran', MasterAnggaranController::class)->except(['show']);
//2.Pagu Anggaran
Route::resource('/admin/pagu-anggaran', PaguAnggaranController::class);

//Master-pegawai
Route::resource('/admin/master-pegawai', MasterPegawaiController::class);
Route::post('/admin/master-pegawai/import', [MasterPegawaiController::class, 'import']);

//Master-pimpinan
Route::resource('/admin/master-pimpinan', MasterPimpinanController::class);
// Route::post('/admin/master-pegawai/import', [MasterPegawaiController::class, 'import']);




//Master Objek
//1. Unit Kerja
Route::resource('/admin/master-unit-kerja', MasterUnitKerjaController::class);
Route::post('/admin/master-unit-kerja/import', [MasterUnitKerjaController::class, 'import']);
//2. Satuan Kerja
Route::resource('/admin/master-satuan-kerja', SatuanKerjaController::class);
Route::post('/admin/master-satuan-kerja/import', [SatuanKerjaController::class, 'import']);
//3. Wilayah Kerja
Route::resource('/admin/master-wilayah-kerja', WilayahKerjaController::class);
Route::post('/admin/master-wilayah-kerja/import', [WilayahKerjaController::class, 'import']);
//4. Objek Kegiatan
Route::resource('/admin/objek-kegiatan', ObjekKegiatanController::class);
Route::get('/admin/objek-kegiatan/count/{id}', [ObjekKegiatanController::class, 'unitkerja']);

//Master Tujuan
Route::resource('/admin/master-tujuan', MasterTujuanController::class);

//Master Sasaran
Route::resource('/admin/master-sasaran', MasterSasaranController::class);

//Master IKU
Route::resource('/admin/master-iku', MasterIKUController::class);

//Master Hasil
Route::resource('/admin/master-hasil', MasterHasilController::class);
Route::get('/master-hasil/unsur/{id}',[MasterHasilController::class, 'subunsur1']);
Route::post('/master-hasil/subunsur1/{id}',[MasterHasilController::class, 'subunsur2']);
Route::post('/master-hasil/subunsur2/{id}',[MasterHasilController::class, 'kategoriHasil']);
Route::resource('/admin/tim-kerja', TimKerjaController::class);

//Rencana Kinerja
Route::resource('/admin/rencana-kinerja', AdminRencanaKerjaController::class);
Route::put('/admin/rencana-kinerja/send/{id}', [AdminRencanaKerjaController::class, 'sendToInspektur']);
Route::put('/admin/rencana-kinerja/return/{id}', [AdminRencanaKerjaController::class, 'sendBackToKetuaTim']);

/**
 * ---------------------------------------------------------------------------
 * PIMPINAN
 * ---------------------------------------------------------------------------
 * */
//Rencana Kinerja
Route::resource('/pimpinan/rencana-kinerja', PimpinanRencanKerjaController::class);
Route::put('/pimpinan/rencana-kinerja/accept/{id}', [PimpinanRencanKerjaController::class, 'accept']);
Route::put('/pimpinan/rencana-kinerja/return/{id}', [PimpinanRencanKerjaController::class, 'sendBackToKetuaTim']);

/**
 * ---------------------------------------------------------------------------
 * PEGAWAI
 * ---------------------------------------------------------------------------
 * */
Route::group(['middleware'=>'auth'], function(){// Dashboard
    /**
     * ---------------------------------------------------------------------------
     * SEKRETARIS
     * ---------------------------------------------------------------------------
     * */

    Route::get('/sekretaris', [DashboardController::class, 'sekretaris'])->name('sekretaris-dashboard');

    // Sekretaris-surat-lain
    Route::resource('sekretaris/usulan-surat', SlSekreController::class);

    // Sekretaris-norma-hasil
    Route::resource('sekretaris/norma-hasil', NormaHasilSekreController::class);

    /**
     * ---------------------------------------------------------------------------
     * ANALIS SDM
     * ---------------------------------------------------------------------------
     * */
    Route::get('analis-sdm/pp-nonaktif', [PpController::class, 'ppNonaktif']);

    Route::resource('analis-sdm/pp', PpController::class)->names([
        'index' => 'analis-sdm-pp',
        'show' => 'st-kinerja.show',
    ]);

    Route::resource('analis-sdm/namaPp', NamaPpController::class);

    /**
     * ---------------------------------------------------------------------------
     * INSPEKTUR
     * ---------------------------------------------------------------------------
     * */
    Route::get('/inspektur', [DashboardController::class, 'inspektur'])->name('inspektur-dashboard');

    // Inspektur-stp
    Route::resource('inspektur/st-pp', InspekturStpController::class);

    // Inspektur-st-kinerja
    Route::resource('inspektur/st-kinerja', InspekturStKinerjaController::class);

    // Inspektur-st-pd
    Route::resource('inspektur/st-pd', InspekturStpdController::class);

    Route::get('cetak-spd', function () {
        return view('cetak-spd', ['type_menu' => 'dashboard']);
    });

    /**
     * ---------------------------------------------------------------------------
     * PEGAWAI
     * ---------------------------------------------------------------------------
     * */
    Route::get('/pegawai/dashboard', [DashboardController::class, 'pegawai'])->name('dashboard');
    Route::resource('/pegawai/rencana-kinerja', PegawaiRencanaKerjaController::class);
    Route::put('/pegawai/rencana-kinerja/send/{id}', [PegawaiRencanaKerjaController::class, 'sendToAnalis']);

    // Ketua Tim
    Route::resource('/ketua-tim/rencana-kinerja', KetuaTimRencanaKerjaController::class);
    Route::put('/ketua-tim/rencana-kinerja/disable/{id}', [KetuaTimRencanaKerjaController::class, 'disableRencanaKerja']);
    Route::put('/ketua-tim/rencana-kinerja/send/{id}', [KetuaTimRencanaKerjaController::class, 'sendToAnalis']);
    Route::resource('/ketua-tim/tim-pelaksana', PegawaiTugasController::class);

    Route::resource('/pegawai/rencana-kinerja', PegawaiRencanaKerjaController::class);
    Route::put('/pegawai/rencana-kinerja/send/{id}', [PegawaiRencanaKerjaController::class, 'sendToAnalis']);
    Route::resource('/pegawai/tim-pelaksana', PegawaiTugasController::class);
    Route::get('/objek-bykategori/{id}', [ObjekKegiatanController::class, 'objekByKategori']);
    Route::resource('/objek-pengawasan', ObjekPengawasanController::class);
    Route::resource('/anggaran-rencana-kerja', AnggaranRencanaKerjaController::class);
    Route::resource('/pelaksana-tugas', PelaksanaTugasController::class);
    Route::put('/pegawai/rencana-kinerja/send/{id}', [PegawaiRencanaKerjaController::class, 'sendToAnalis']);

    // Ajax
    Route::get('/tugas', [TugasController::class, 'getRencanaKerja']);

    // ST Kinerja
    Route::resource('pegawai/st-kinerja', StKinerjaController::class)->names([
        'index' => 'st-kinerja.index',
        'show' => 'st-kinerja.show',
    ]);

    // Norma Hasil
    Route::resource('pegawai/norma-hasil', NormaHasilController::class)->names([
        'index' => 'norma-hasil.index',
        'show' => 'norma-hasil.show',
    ]);

    // ST Pengembangan Profesi
    Route::post('/get-nama-pp-by-pp', [StpController::class, 'getNamaPp']);
    Route::resource('pegawai/st-pp', StpController::class)->names([
        'index' => 'st-pp.index'
    ]);

    // ST Perjalanan Dinas
    Route::resource('pegawai/st-pd', StpdController::class)->names([
        'index' => 'st-pd.index',
        'show' => 'st-pd.show',
    ]);

    // Surat Lain
    Route::resource('pegawai/surat-lain', SlController::class)->names([
        'index' => 'surat-lain.index',
        'show' => 'surat-lain.show'
    ]);

    // Kirim Dokumen
    Route::resource('pegawai/kirim-dokumen', KirimController::class)->names([
        'index' => 'kirim-dokumen.index',
        'show' => 'kirim-dokumen.show',
    ]);

    // Surat Eksternal
    Route::get('/pegawai/eksternal/form', [EksternalController::class, 'form']);
    Route::resource('pegawai/eksternal', EksternalController::class)->names([
        'index' => 'surat-eksternal.index',
        'show' => 'surat-eksternal.show',
    ]);

    // Usulan Nomor Surat
    Route::resource('sekretaris/nomor-surat', NomorSuratController::class);

    // Surat
    Route::resource('sekretaris/surat', SuratController::class);

    // Templating dokumen
    Route::get('word', function () {
        return view('word');
    });
    Route::post('word', [WordController::class, 'index'])->name('word.index');
});

/**
 * ===========================================================================
 * End of Simwas
 * ===========================================================================
 * */

Route::redirect('/', '/pegawai/dashboard')->name('dashboard');

Route::get('/dashboard-general-dashboard', function () {
    return view('pages.dashboard-general-dashboard', ['type_menu' => 'dashboard']);
});
Route::get('/dashboard-ecommerce-dashboard', function () {
    return view('pages.dashboard-ecommerce-dashboard', ['type_menu' => 'dashboard']);
});

// UserController
Route::get('/search', [UserController::class, 'search'])->name('search');

// Layout
Route::get('/layout-default-layout', function () {
    return view('pages.layout-default-layout', ['type_menu' => 'layout']);
});

// Blank Page
Route::get('/blank-page', function () {
    return view('pages.blank-page', ['type_menu' => '']);
});

// Bootstrap
Route::get('/bootstrap-alert', function () {
    return view('pages.bootstrap-alert', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-badge', function () {
    return view('pages.bootstrap-badge', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-breadcrumb', function () {
    return view('pages.bootstrap-breadcrumb', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-buttons', function () {
    return view('pages.bootstrap-buttons', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-card', function () {
    return view('pages.bootstrap-card', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-carousel', function () {
    return view('pages.bootstrap-carousel', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-collapse', function () {
    return view('pages.bootstrap-collapse', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-dropdown', function () {
    return view('pages.bootstrap-dropdown', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-form', function () {
    return view('pages.bootstrap-form', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-list-group', function () {
    return view('pages.bootstrap-list-group', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-media-object', function () {
    return view('pages.bootstrap-media-object', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-modal', function () {
    return view('pages.bootstrap-modal', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-nav', function () {
    return view('pages.bootstrap-nav', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-navbar', function () {
    return view('pages.bootstrap-navbar', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-pagination', function () {
    return view('pages.bootstrap-pagination', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-popover', function () {
    return view('pages.bootstrap-popover', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-progress', function () {
    return view('pages.bootstrap-progress', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-table', function () {
    return view('pages.bootstrap-table', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-tooltip', function () {
    return view('pages.bootstrap-tooltip', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-typography', function () {
    return view('pages.bootstrap-typography', ['type_menu' => 'bootstrap']);
});


// components
Route::get('/components-article', function () {
    return view('pages.components-article', ['type_menu' => 'components']);
});
Route::get('/components-avatar', function () {
    return view('pages.components-avatar', ['type_menu' => 'components']);
});
Route::get('/components-chat-box', function () {
    return view('pages.components-chat-box', ['type_menu' => 'components']);
});
Route::get('/components-empty-state', function () {
    return view('pages.components-empty-state', ['type_menu' => 'components']);
});
Route::get('/components-gallery', function () {
    return view('pages.components-gallery', ['type_menu' => 'components']);
});
Route::get('/components-hero', function () {
    return view('pages.components-hero', ['type_menu' => 'components']);
});
Route::get('/components-multiple-upload', function () {
    return view('pages.components-multiple-upload', ['type_menu' => 'components']);
});
Route::get('/components-pricing', function () {
    return view('pages.components-pricing', ['type_menu' => 'components']);
});
Route::get('/components-statistic', function () {
    return view('pages.components-statistic', ['type_menu' => 'components']);
});
Route::get('/components-tab', function () {
    return view('pages.components-tab', ['type_menu' => 'components']);
});
Route::get('/components-table', function () {
    return view('pages.components-table', ['type_menu' => 'components']);
});
Route::get('/components-user', function () {
    return view('pages.components-user', ['type_menu' => 'components']);
});
Route::get('/components-wizard', function () {
    return view('pages.components-wizard', ['type_menu' => 'components']);
});

// forms
Route::get('/forms-advanced-form', function () {
    return view('pages.forms-advanced-form', ['type_menu' => 'forms']);
});
Route::get('/forms-editor', function () {
    return view('pages.forms-editor', ['type_menu' => 'forms']);
});
Route::get('/forms-validation', function () {
    return view('pages.forms-validation', ['type_menu' => 'forms']);
});

// google maps
// belum tersedia

// modules
Route::get('/modules-calendar', function () {
    return view('pages.modules-calendar', ['type_menu' => 'modules']);
});
Route::get('/modules-chartjs', function () {
    return view('pages.modules-chartjs', ['type_menu' => 'modules']);
});
Route::get('/modules-datatables', function () {
    return view('pages.modules-datatables', ['type_menu' => 'modules']);
});
Route::get('/modules-flag', function () {
    return view('pages.modules-flag', ['type_menu' => 'modules']);
});
Route::get('/modules-font-awesome', function () {
    return view('pages.modules-font-awesome', ['type_menu' => 'modules']);
});
Route::get('/modules-ion-icons', function () {
    return view('pages.modules-ion-icons', ['type_menu' => 'modules']);
});
Route::get('/modules-owl-carousel', function () {
    return view('pages.modules-owl-carousel', ['type_menu' => 'modules']);
});
Route::get('/modules-sparkline', function () {
    return view('pages.modules-sparkline', ['type_menu' => 'modules']);
});
Route::get('/modules-sweet-alert', function () {
    return view('pages.modules-sweet-alert', ['type_menu' => 'modules']);
});
Route::get('/modules-toastr', function () {
    return view('pages.modules-toastr', ['type_menu' => 'modules']);
});
Route::get('/modules-vector-map', function () {
    return view('pages.modules-vector-map', ['type_menu' => 'modules']);
});
Route::get('/modules-weather-icon', function () {
    return view('pages.modules-weather-icon', ['type_menu' => 'modules']);
});

// auth
Route::get('/auth-forgot-password', function () {
    return view('pages.auth-forgot-password', ['type_menu' => 'auth']);
});
Route::get('/auth-login', function () {
    return view('pages.auth-login', ['type_menu' => 'auth']);
})->middleware('guest')->name('login');
Route::get('/auth-login2', function () {
    return view('pages.auth-login2', ['type_menu' => 'auth']);
});
Route::get('/auth-register', function () {
    return view('pages.auth-register', ['type_menu' => 'auth']);
});
Route::get('/auth-reset-password', function () {
    return view('pages.auth-reset-password', ['type_menu' => 'auth']);
});

// error
Route::get('/error-403', function () {
    return view('pages.error-403', ['type_menu' => 'error']);
});
Route::get('/error-404', function () {
    return view('pages.error-404', ['type_menu' => 'error']);
});
Route::get('/error-500', function () {
    return view('pages.error-500', ['type_menu' => 'error']);
});
Route::get('/error-503', function () {
    return view('pages.error-503', ['type_menu' => 'error']);
});

// features
Route::get('/features-activities', function () {
    return view('pages.features-activities', ['type_menu' => 'features']);
});
Route::get('/features-post-create', function () {
    return view('pages.features-post-create', ['type_menu' => 'features']);
});
Route::get('/features-post', function () {
    return view('pages.features-post', ['type_menu' => 'features']);
});
Route::get('/features-profile', function () {
    return view('pages.features-profile', ['type_menu' => 'features']);
});
Route::get('/features-settings', function () {
    return view('pages.features-settings', ['type_menu' => 'features']);
});
Route::get('/features-setting-detail', function () {
    return view('pages.features-setting-detail', ['type_menu' => 'features']);
});
Route::get('/features-tickets', function () {
    return view('pages.features-tickets', ['type_menu' => 'features']);
});

// utilities
Route::get('/utilities-contact', function () {
    return view('pages.utilities-contact', ['type_menu' => 'utilities']);
});
Route::get('/utilities-invoice', function () {
    return view('pages.utilities-invoice', ['type_menu' => 'utilities']);
});
Route::get('/utilities-subscribe', function () {
    return view('pages.utilities-subscribe', ['type_menu' => 'utilities']);
});

// credits
Route::get('/credits', function () {
    return view('pages.credits', ['type_menu' => '']);
});
Route::get('/testing', function () {
    return view('welcome');
});
Route::get('/testing1', function () {
    return view('welcome');
});
Route::get('/testing2', function () {
    return view('welcome');
});

// if in production force redirect to https
if (App::environment('production')) {
    URL::forceScheme('https');
}
