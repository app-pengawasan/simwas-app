<?php

namespace App\Http\Controllers;

use App\Models\KendaliMutuTim;
use App\Models\Sl;
use App\Models\Stp;
use App\Models\Stpd;
use App\Models\User;
use App\Models\Surat;
use App\Models\TimKerja;
use App\Models\StKinerja;
use App\Models\Kompetensi;
use App\Models\NormaHasil;
use App\Models\RencanaKerja;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\MasterUnitKerja;
use App\Models\ObjekPengawasan;
use App\Models\TargetIkuUnitKerja;
use App\Models\UsulanSuratSrikandi;
use App\Models\LaporanObjekPengawasan;
use App\Models\NormaHasilTim;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    protected $months = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    function admin(Request $request) {
        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $pegawaiCount = $this->pegawaiCount();
        $objekCount = $this->objekCount();
        $timKerjaCount = $this->adminTimKerjaCount($year);


        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }
        return view('admin.index',[
            'type_menu' => 'dashboard',
            'pegawai8000Count' => $pegawaiCount['pegawai8000'],
            'pegawai8010Count' => $pegawaiCount['pegawai8010'],
            'pegawai8100Count' => $pegawaiCount['pegawai8100'],
            'pegawai8200Count' => $pegawaiCount['pegawai8200'],
            'pegawai8300Count' => $pegawaiCount['pegawai8300'],

            'unitKerjaCount' => $objekCount['unitKerjaCount'],
            'satuanKerjaCount' => $objekCount['satuanKerjaCount'],
            'wilayahKerjaCount' => $objekCount['wilayahKerjaCount'],

            'timKerjaTotalCount' => $timKerjaCount['timKerjaTotalCount'],
            'timKerjaPenyusunanCount' => $timKerjaCount['timKerjaPenyusunanCount'],
            'timKerjaDiterimaCount' => $timKerjaCount['timKerjaDiterimaCount'],
            'timKerjaPercentagePenyusunan' => $timKerjaCount['timKerjaPercentagePenyusunan'],
            'timKerjaPercentageDiterima' => $timKerjaCount['timKerjaPercentageDiterima'],
        ]);
    }


    function pegawai(Request $request) {

        $year = $request->year;
        $id_unitkerja = auth()->user()->unit_kerja;

        // dd($year);

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $suratSrikandiCount = $this->suratSrikandiCount($year);
        $normaHasilCount = $this->usulanNormaHasilCount($year);
        $usulanNormaHasilCount = NormaHasil::with('user', 'normaHasilAccepted')->latest()->whereYear('created_at', $year)->whereHas('rencanaKerja.timkerja', function ($query) {
            $query->where('id_ketua', auth()->user()->id)->where('status_norma_hasil', 'diperiksa');
        })->count();
        $timKerjaCount = $this->ketuaTimKerjaCount($year);


        return view('pegawai.index', [
            'type_menu' => 'usulan-surat-srikandi',
            // Surat Srikandi
            'percentage_usulan' => $suratSrikandiCount['percentage_usulan'],
            'percentage_disetujui' => $suratSrikandiCount['percentage_disetujui'],
            'percentage_ditolak' => $suratSrikandiCount['percentage_ditolak'],
            'total_usulan' => $suratSrikandiCount['usulanCount'],
            'usulanCount' => $suratSrikandiCount['usulanCount'],
            'disetujuiCount' => $suratSrikandiCount['disetujuiCount'],
            'ditolakCount' => $suratSrikandiCount['ditolakCount'],
            'suratCount' => $suratSrikandiCount['totalCount'],
            // Norma Hasil
            'normaHasilCount' => $normaHasilCount['usulanCount'],
            'normaHasilDisetujui' => $normaHasilCount['disetujuiCount'],
            'normaHasilDitolak' => $normaHasilCount['ditolakCount'],
            'normaHasilDiperiksa' => $normaHasilCount['diperiksaCount'],
            'normaHasilPercentageDiperiksa' => $normaHasilCount['percentage_diperiksa'],
            'normaHasilPercentageDisetujui' => $normaHasilCount['percentage_disetujui'],
            'normaHasilPercentageDitolak' => $normaHasilCount['percentage_ditolak'],
            'usulanNormaHasilCount' => $usulanNormaHasilCount,
            // Tim Kerja - Ketua Tim Kerja
            'timKerjaTotalCount' => $timKerjaCount['timKerjaTotalCount'],
            'timKerjaPenyusunanCount' => $timKerjaCount['timKerjaPenyusunanCount'],
            'timKerjaDiterimaCount' => $timKerjaCount['timKerjaDiterimaCount'],
            'timKerjaPercentagePenyusunan' => $timKerjaCount['timKerjaPercentagePenyusunan'],
            'timKerjaPercentageDiterima' => $timKerjaCount['timKerjaPercentageDiterima'],
        ]);
    }

    function sekretaris(Request $request) {
        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }
        $this->authorize('sekretaris');
        $suratSrikandiCount = $this->sekretarisSuratSrikandiCount($year);


        return view('sekretaris.index', [
            'type_menu' => 'usulan-surat-srikandi',
            'percentage_usulan' => $suratSrikandiCount['percentage_usulan'],
            'percentage_disetujui' => $suratSrikandiCount['percentage_disetujui'],
            'percentage_ditolak' => $suratSrikandiCount['percentage_ditolak'],
            'total_usulan' => $suratSrikandiCount['total_usulan'],
            'usulanCount' => $suratSrikandiCount['usulanCount'],
            'disetujuiCount' => $suratSrikandiCount['disetujuiCount'],
            'ditolakCount' => $suratSrikandiCount['ditolakCount'],

        ]);
    }

    function inspektur() {
        $this->authorize('inspektur');
        // $stk = StKinerja::where('unit_kerja', auth()->user()->unit_kerja)->count();
        // $stk_sum = StKinerja::whereHas('rencanaKerja.proyek.timkerja', function ($query) {
        //     $query->where('unitkerja', auth()->user()->unit_kerja);
        // })->count();
        // $stk_need_approval = StKinerja::where('status', 0)->whereHas('rencanaKerja.proyek.timkerja', function ($query) {
        //     $query->where('unitkerja', auth()->user()->unit_kerja);
        // })->count();
        // $stp_sum = Stp::where('unit_kerja', auth()->user()->unit_kerja)->count();
        // $stp_need_approval = Stp::where('status', 3)->where('unit_kerja', auth()->user()->unit_kerja)->count();
        // $stpd_sum = Stpd::where('unit_kerja', auth()->user()->unit_kerja)->count();
        // $stpd_need_approval = Stpd::where('status', 0)->where('unit_kerja', auth()->user()->unit_kerja)->count();


        return view('inspektur.index', [
            // "stk_sum" => $stk_sum,
            // "stk_need_approval" => $stk_need_approval,
            // "stp_sum" => $stp_sum,
            // "stp_need_approval" => $stp_need_approval,
            // "stpd_sum" => $stpd_sum,
            // "stpd_need_approval" => $stpd_need_approval
        ]);
    }

    function analis_sdm() {
        $this->authorize('analis_sdm');
        $pegawai = User::all();
        $kompetensi = Kompetensi::where('status', 1)->get();
        $count = $kompetensi->groupBy('pegawai_id')->map->countBy('pp_id');

        return view('analis-sdm.index', [
            'pegawai' => $pegawai,
            'kompetensi' => $kompetensi,
            'count' => $count
        ]);
    }


    function ikuUnitKerja($year) {
        $targetIkuUnitKerjaCount = TargetIkuUnitKerja::latest()->whereYear('created_at', $year)->where('status', 1)->count();
        $realisasiIkuUnitKerjaCount = TargetIkuUnitKerja::latest()->whereYear('created_at', $year)->where('status', 2)->count();
        $evaluasiIkuUnitKerjaCount = TargetIkuUnitKerja::latest()->whereYear('created_at', $year)->where('status', 3)->count();
        $selesaiIkuUnitKerjaCount = TargetIkuUnitKerja::latest()->whereYear('created_at', $year)->where('status', 4)->count();

        $totalIkuUnitKerjaCount = TargetIkuUnitKerja::latest()->whereYear('created_at', $year)->count();

        $percentageTarget = $targetIkuUnitKerjaCount != 0 ? intval($targetIkuUnitKerjaCount/($totalIkuUnitKerjaCount)*100) : 0;
        $percentageRealisasi = $realisasiIkuUnitKerjaCount != 0 ? intval($realisasiIkuUnitKerjaCount/($totalIkuUnitKerjaCount)*100) : 0;
        $percentageEvaluasi = $evaluasiIkuUnitKerjaCount != 0 ? intval($evaluasiIkuUnitKerjaCount/($totalIkuUnitKerjaCount)*100) : 0;
        $percentageSelesai = $selesaiIkuUnitKerjaCount != 0 ? intval($selesaiIkuUnitKerjaCount/($totalIkuUnitKerjaCount)*100) : 0;

        return [
            'totalIkuUnitKerjaCount' => $totalIkuUnitKerjaCount,
            'targetIkuUnitKerjaCount' => $targetIkuUnitKerjaCount,
            'realisasiIkuUnitKerjaCount' => $realisasiIkuUnitKerjaCount,
            'evaluasiIkuUnitKerjaCount' => $evaluasiIkuUnitKerjaCount,
            'selesaiIkuUnitKerjaCount' => $selesaiIkuUnitKerjaCount,
            'percentageTarget' => $percentageTarget,
            'percentageRealisasi' => $percentageRealisasi,
            'percentageEvaluasi' => $percentageEvaluasi,
            'percentageSelesai' => $percentageSelesai,
        ];


    }


    function perencana(Request $request) {
        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $ikuUnitKerja = $this->ikuUnitKerja($year);

        $this->authorize('perencana');
        return view('perencana.index', [
            'type_menu' => 'rencana-kerja',
            'totalIkuUnitKerjaCount' => $ikuUnitKerja['totalIkuUnitKerjaCount'],
            'targetIkuUnitKerjaCount' => $ikuUnitKerja['targetIkuUnitKerjaCount'],
            'realisasiIkuUnitKerjaCount' => $ikuUnitKerja['realisasiIkuUnitKerjaCount'],
            'evaluasiIkuUnitKerjaCount' => $ikuUnitKerja['evaluasiIkuUnitKerjaCount'],
            'selesaiIkuUnitKerjaCount' => $ikuUnitKerja['selesaiIkuUnitKerjaCount'],
            'percentageTarget' => $ikuUnitKerja['percentageTarget'],
            'percentageRealisasi' => $ikuUnitKerja['percentageRealisasi'],
            'percentageEvaluasi' => $ikuUnitKerja['percentageEvaluasi'],
            'percentageSelesai' => $ikuUnitKerja['percentageSelesai'],

        ]);
    }

    function arsiparis(Request $request) {
        $this->authorize('arsiparis');

        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $data_tim = [];
        $timkerja = TimKerja::where('tahun', $year)->get();

        //data tiap tim
        foreach ($timkerja as $tim) {
            $data_tim[$tim->id_timkerja]['nama'] = $tim->nama;
            $data_tim[$tim->id_timkerja]['pjk'] = $tim->ketua->name;
            //data tiap bulan
            for ($i=1; $i < 13; $i++) {
                $laporanobjek = LaporanObjekPengawasan::
                                whereRelation('objekPengawasan.rencanakerja.proyek.timkerja', function (Builder $query) use ($tim) {
                                    $query->where('id_timkerja', $tim->id_timkerja);
                                })->where('month', $i)->where('status', 1)->get();

                //jumlah tugas
                $jumlah_tugas = $laporanobjek->countBy('objekPengawasan.id_rencanakerja')->count();
                if ($jumlah_tugas == 0) {
                    $data_tim[$tim->id_timkerja]['data_bulan'][$i]['jumlah_tugas'] = '-';
                    $data_tim[$tim->id_timkerja]['data_bulan'][$i]['jumlah_st'] = '-';
                    $data_tim[$tim->id_timkerja]['data_bulan'][$i]['target_nh'] = '-';
                    $data_tim[$tim->id_timkerja]['data_bulan'][$i]['jumlah_nh'] = '-';
                    $data_tim[$tim->id_timkerja]['data_bulan'][$i]['jumlah_km'] = '-';
                    continue;
                }
                $data_tim[$tim->id_timkerja]['data_bulan'][$i]['jumlah_tugas'] = $jumlah_tugas;

                $surat_tugas = UsulanSuratSrikandi::whereIn('rencana_kerja_id', $laporanobjek->pluck('objekPengawasan.id_rencanakerja'))
                                // ->where('status', 'disetujui')
                                ->get();
                //jumlah surat tugas masuk
                $data_tim[$tim->id_timkerja]['data_bulan'][$i]['jumlah_st'] = $surat_tugas->count();

                //jumlah target norma hasil
                $data_tim[$tim->id_timkerja]['data_bulan'][$i]['target_nh'] = $laporanobjek->count();
                                
                $norma_hasil = NormaHasilTim::whereRelation('normaHasilAccepted', function (Builder $query) use ($i, $laporanobjek) {
                                    // $query->where('status_verifikasi_arsiparis', 'disetujui');
                                    $query->whereRelation('normaHasil.laporanPengawasan', function (Builder $q) use ($i, $laporanobjek) {
                                                $q->where('month', $i)->where('status', 1);
                                                $q->whereRelation('objekPengawasan', function (Builder $q2) use ($laporanobjek) {
                                                    $q2->whereIn('id_rencanakerja', $laporanobjek->pluck('objekPengawasan.id_rencanakerja'));
                                                });
                                            });
                                })->orWhereRelation('normaHasilDokumen', function (Builder $query) use ($i, $laporanobjek) {
                                    // $query->where('status_verifikasi_arsiparis', 'disetujui');
                                    $query->whereRelation('laporanPengawasan', function (Builder $q) use ($i, $laporanobjek) {
                                        $q->where('month', $i)->where('status', 1);
                                        $q->whereRelation('objekPengawasan', function (Builder $q2) use ($laporanobjek) {
                                            $q2->whereIn('id_rencanakerja', $laporanobjek->pluck('objekPengawasan.id_rencanakerja'));
                                        });
                                    });
                                })->get(); 

                //jumlah norma hasil masuk
                $data_tim[$tim->id_timkerja]['data_bulan'][$i]['jumlah_nh'] = $norma_hasil->count();

                $kendali_mutu = KendaliMutuTim::whereRelation('laporanObjekPengawasan', function (Builder $query) use ($i, $laporanobjek) {
                                                    $query->where('month', $i)->where('status', 1);
                                                    $query->whereRelation('objekPengawasan', function (Builder $q) use ($laporanobjek) {
                                                        $q->whereIn('id_rencanakerja', $laporanobjek->pluck('objekPengawasan.id_rencanakerja'));
                                                    });
                                                })
                                                // ->where('status', 'disetujui')
                                                ->get();
                //jumlah kendali mutu
                $data_tim[$tim->id_timkerja]['data_bulan'][$i]['jumlah_km'] = $kendali_mutu->count();
            }
        } 

        return view('arsiparis.index',[
            'type_menu'     => 'kinerja-tim',
            'months'    => $this->months
        ])->with('data_tim', $data_tim);
    }

    function detailKinerjaTim($id, $bulan) {
        $this->authorize('arsiparis');

        $laporanObjek = LaporanObjekPengawasan::where('month', $bulan)->where('status', 1)
                        ->whereRelation('objekPengawasan.rencanakerja.proyek.timkerja', function (Builder $query) use ($id) {
                            $query->where('id_timkerja', $id);
                        })->get();

        $surat_tugas = UsulanSuratSrikandi::whereIn('rencana_kerja_id', $laporanObjek->pluck('objekPengawasan.id_rencanakerja'))
                        // ->where('status', 'disetujui')
                        ->get();
        $surat_tugas_arr = [];
        foreach ($surat_tugas as $surat) {
            $surat_tugas_arr[$surat->rencana_kerja_id] = $surat;
        }

        $norma_hasil = NormaHasilTim::whereRelation('normaHasilAccepted', function (Builder $query) use ($laporanObjek) {
                            // $query->where('status_verifikasi_arsiparis', 'disetujui');
                            $query->whereRelation('normaHasil', function (Builder $q) use ($laporanObjek) {
                                $q->whereIn('laporan_pengawasan_id', $laporanObjek->pluck('id'));
                            });
                        })->orWhereRelation('normaHasilDokumen', function (Builder $query) use ($laporanObjek) {
                            $query->whereIn('laporan_pengawasan_id', $laporanObjek->pluck('id'));
                            // $query->where('status_verifikasi_arsiparis', 'disetujui');
                        })->get();
        
        $norma_hasil_arr = [];
        foreach ($norma_hasil as $dokumen) {
            if ($dokumen->jenis == 1) {
                $bulan_id = $dokumen->normaHasilAccepted->normaHasil->laporan_pengawasan_id;
                $norma_hasil_arr[$bulan_id] = $dokumen->normaHasilAccepted;
            }
            else {
                $bulan_id = $dokumen->normaHasilDokumen->laporan_pengawasan_id;
                $norma_hasil_arr[$bulan_id] = $dokumen->normaHasilDokumen;
            }
            $norma_hasil_arr[$bulan_id]['jenis'] = $dokumen->jenis;
        }

        $kendali_mutu = KendaliMutuTim::whereIn('laporan_pengawasan_id', $laporanObjek->pluck('id'))->get();
                        // ->where('status', 'disetujui')->get();
        $kendali_mutu_arr = [];
        foreach ($kendali_mutu as $dokumen) {
            $kendali_mutu_arr[$dokumen->laporan_pengawasan_id] = $dokumen;
        }

        return view('arsiparis.show', [
            'type_menu' => 'kinerja-tim',
            'laporanObjek' => $laporanObjek,
            'months' => $this->months,
            'norma_hasil' => $norma_hasil_arr,
            'kendali_mutu' => $kendali_mutu_arr,
            'surat_tugas' => $surat_tugas_arr,
            'bulan' => $bulan
        ]);
    }


    // Admin
    function pegawaiCount() {
        $pegawai8000 = User::where('unit_kerja', 8000)->count();
        $pegawai8010 = User::where('unit_kerja', 8010)->count();
        $pegawai8100 = User::where('unit_kerja', 8100)->count();
        $pegawai8200 = User::where('unit_kerja', 8200)->count();
        $pegawai8300 = User::where('unit_kerja', 8300)->count();

        return [
            'pegawai8000' => $pegawai8000,
            'pegawai8010' => $pegawai8010,
            'pegawai8100' => $pegawai8100,
            'pegawai8200' => $pegawai8200,
            'pegawai8300' => $pegawai8300,
        ];

    }

    function objekCount() {
        $unitKerjaCount = MasterUnitKerja::where('kategori', '1')->count();
        $satuanKerjaCount = MasterUnitKerja::where('kategori', '2')->count();
        $wilayahKerjaCount = MasterUnitKerja::where('kategori', '3')->count();
        return [
            'unitKerjaCount' => $unitKerjaCount,
            'satuanKerjaCount' => $satuanKerjaCount,
            'wilayahKerjaCount' => $wilayahKerjaCount,
        ];

    }

    function adminTimKerjaCount($year){
        $timKerjaPenyusunanCount = TimKerja::with('ketua', 'iku')->whereIn('status', [0,1])->where('tahun', $year)->get()->count();
        $timKerjaDiterimaCount = TimKerja::with('ketua', 'iku')->whereIn('status', [2])->where('tahun', $year)->get()->count();

        $timKerjaTotalCount = TimKerja::with('ketua', 'iku')->where('tahun', $year)->get()->count();

        $timKerjaPercentagePenyusunan = $timKerjaPenyusunanCount != 0 ? intval($timKerjaPenyusunanCount/($timKerjaTotalCount)*100) : 0;
        $timKerjaPercentageDiterima = $timKerjaDiterimaCount != 0 ? intval($timKerjaDiterimaCount/($timKerjaTotalCount)*100) : 0;


        return [
            'timKerjaTotalCount' => $timKerjaTotalCount,
            'timKerjaPenyusunanCount' => $timKerjaPenyusunanCount,
            'timKerjaDiterimaCount' => $timKerjaDiterimaCount,
            'timKerjaPercentagePenyusunan' => $timKerjaPercentagePenyusunan,
            'timKerjaPercentageDiterima' => $timKerjaPercentageDiterima,
        ];
    }


    // Pegawai

    function suratSrikandiCount($year){
        $usulanCount= UsulanSuratSrikandi::with('user')->latest()->where('user_id', auth()->user()->id)->whereYear('created_at', $year)->where('status', 'usulan')->count();
        $disetujuiCount= UsulanSuratSrikandi::with('user')->latest()->where('user_id', auth()->user()->id)->whereYear('created_at', $year)->where('status', 'disetujui')->count();
        $ditolakCount= UsulanSuratSrikandi::with('user')->latest()->where('user_id', auth()->user()->id)->whereYear('created_at', $year)->where('status', 'ditolak')->count();

        if ($usulanCount+$disetujuiCount+$ditolakCount != 0) {
            $percentage_usulan = intval($usulanCount/($usulanCount+$disetujuiCount+$ditolakCount)*100);
            $percentage_disetujui = intval($disetujuiCount/($usulanCount+$disetujuiCount+$ditolakCount)*100);
            $percentage_ditolak = intval($ditolakCount/($usulanCount+$disetujuiCount+$ditolakCount)*100);
        } else
        {
            $percentage_usulan = 0;
            $percentage_disetujui = 0;
            $percentage_ditolak = 0;
        }

        return [
            'percentage_usulan' => $percentage_usulan,
            'percentage_disetujui' => $percentage_disetujui,
            'percentage_ditolak' => $percentage_ditolak,
            'usulanCount' => $usulanCount,
            'disetujuiCount' => $disetujuiCount,
            'ditolakCount' => $ditolakCount,
            'totalCount' => $usulanCount+$disetujuiCount+$ditolakCount
        ];
    }

    function ketuaTimKerjaCount($year){
        $id_pegawai = auth()->user()->id;
        $timKerjaPenyusunanCount = TimKerja::with('ketua', 'iku')
            ->where(function($query) use ($id_pegawai) {
                $query->where('id_ketua', $id_pegawai)
                    ->orWhereHas('operatorRencanaKinerja', function($query) use ($id_pegawai) {
                        $query->where('operator_id', $id_pegawai);
                    });
            })
            ->whereIn('status', [0, 1])
            ->where('tahun', $year)
            ->count();
        $timKerjaDiterimaCount = TimKerja::with('ketua', 'iku')
            ->where(function($query) use ($id_pegawai) {
                $query->where('id_ketua', $id_pegawai)
                    ->orWhereHas('operatorRencanaKinerja', function($query) use ($id_pegawai) {
                        $query->where('operator_id', $id_pegawai);
                    });
            })
            ->whereIn('status', [2])
            ->where('tahun', $year)
            ->count();

        $timKerjaTotalCount =TimKerja::with('ketua', 'iku')
            ->where(function($query) use ($id_pegawai) {
                $query->where('id_ketua', $id_pegawai)
                    ->orWhereHas('operatorRencanaKinerja', function($query) use ($id_pegawai) {
                        $query->where('operator_id', $id_pegawai);
                    });
            })
            ->where('tahun', $year)
            ->count();

        $timKerjaPercentagePenyusunan = $timKerjaPenyusunanCount != 0 ? intval($timKerjaPenyusunanCount/($timKerjaTotalCount)*100) : 0;
        $timKerjaPercentageDiterima = $timKerjaDiterimaCount != 0 ? intval($timKerjaDiterimaCount/($timKerjaTotalCount)*100) : 0;


        return [
            'timKerjaTotalCount' => $timKerjaTotalCount,
            'timKerjaPenyusunanCount' => $timKerjaPenyusunanCount,
            'timKerjaDiterimaCount' => $timKerjaDiterimaCount,
            'timKerjaPercentagePenyusunan' => $timKerjaPercentagePenyusunan,
            'timKerjaPercentageDiterima' => $timKerjaPercentageDiterima,
        ];
    }

    function usulanNormaHasilCount($year){
        $usulan = NormaHasil::with('normaHasilAccepted')->where('user_id', auth()->user()->id)->whereYear('created_at', $year)->get();
        $usulanCount = $usulan->count();
        $diperiksaCount = $usulan->where('status_norma_hasil', 'diperiksa')->count();
        $disetujuiCount = $usulan->where('status_norma_hasil', 'disetujui')->count();
        $ditolakCount = $usulan->where('status_norma_hasil', 'ditolak')->count();
        return [
            'usulanCount' => $usulanCount,
            'disetujuiCount' => $disetujuiCount,
            'ditolakCount' => $ditolakCount,
            'diperiksaCount' => $diperiksaCount,

            'percentage_diperiksa' => $diperiksaCount != 0 ? intval($diperiksaCount/($usulanCount)*100) : 0,
            'percentage_disetujui' => $disetujuiCount != 0 ? intval($disetujuiCount/($usulanCount)*100) : 0,
            'percentage_ditolak' => $ditolakCount != 0 ? intval($ditolakCount/($usulanCount)*100) : 0,
        ];

    }

    // Sekretaris
    function sekretarisSuratSrikandiCount($year){

        if(auth()->user()->is_sekma){
            $usulanCount= UsulanSuratSrikandi::with('user')->latest()->whereYear('created_at', $year)->where('status', 'usulan')->count();
            $disetujuiCount= UsulanSuratSrikandi::with('user')->latest()->whereYear('created_at', $year)->where('status', 'disetujui')->count();
            $ditolakCount= UsulanSuratSrikandi::with('user')->latest()->whereYear('created_at', $year)->where('status', 'ditolak')->count();
            $totalCount = UsulanSuratSrikandi::with('user')->latest()->whereYear('created_at', $year)->count();
        } else {
            $unitKerja = auth()->user()->unit_kerja;
            $usulanCount= UsulanSuratSrikandi::with('user')->latest()->where('pejabat_penanda_tangan', $unitKerja)->whereYear('created_at', $year)->where('status', 'usulan')->count();
            $disetujuiCount= UsulanSuratSrikandi::with('user')->latest()->where('pejabat_penanda_tangan', $unitKerja)->whereYear('created_at', $year)->where('status', 'disetujui')->count();
            $ditolakCount= UsulanSuratSrikandi::with('user')->latest()->where('pejabat_penanda_tangan', $unitKerja)->whereYear('created_at', $year)->where('status', 'ditolak')->count();
            $totalCount = UsulanSuratSrikandi::with('user')->latest()->where('pejabat_penanda_tangan', $unitKerja)->whereYear('created_at', $year)->count();
        }

        if ($usulanCount+$disetujuiCount+$ditolakCount != 0) {
            $percentage_usulan = intval($usulanCount/($usulanCount+$disetujuiCount+$ditolakCount)*100);
            $percentage_disetujui = intval($disetujuiCount/($usulanCount+$disetujuiCount+$ditolakCount)*100);
            $percentage_ditolak = intval($ditolakCount/($usulanCount+$disetujuiCount+$ditolakCount)*100);
        } else
        {
            $percentage_usulan = 0;
            $percentage_disetujui = 0;
            $percentage_ditolak = 0;
        }

        return [
            'percentage_usulan' => $percentage_usulan,
            'percentage_disetujui' => $percentage_disetujui,
            'percentage_ditolak' => $percentage_ditolak,
            'usulanCount' => $usulanCount,
            'disetujuiCount' => $disetujuiCount,
            'ditolakCount' => $ditolakCount,
            'total_usulan' => $totalCount,
        ];
    }

    function kinerjaTim(Request $request) {
        $months=[
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $tugas = PelaksanaTugas::where('id_pegawai', auth()->user()->id)
                    ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                        $query->whereIn('status', [1,2]);
                        $query->where('tahun', $year);
                    })->get();

        $surat_tugas = UsulanSuratSrikandi::whereIn('rencana_kerja_id', $tugas->pluck('id_rencanakerja'))->get();
                        // ->where('status', 'disetujui')->get();
        $surat_tugas_arr = [];

        foreach ($surat_tugas as $surat) {
            $surat_tugas_arr[$surat->rencana_kerja_id] = $surat;
        }

        $laporanObjek = LaporanObjekPengawasan::whereRelation('objekPengawasan', function (Builder $query) use ($tugas) {
                                $query->whereIn('id_rencanakerja', $tugas->pluck('id_rencanakerja'));
                            })->where('status', 1)->get();

        $norma_hasil = NormaHasilTim::whereRelation('normaHasilAccepted', function (Builder $query) use ($laporanObjek) {
                            // $query->where('status_verifikasi_arsiparis', 'disetujui');
                            $query->whereRelation('normaHasil', function (Builder $q) use ($laporanObjek) {
                                $q->whereIn('laporan_pengawasan_id', $laporanObjek->pluck('id'));
                            });
                        })->orWhereRelation('normaHasilDokumen', function (Builder $query) use ($laporanObjek) {
                            $query->whereIn('laporan_pengawasan_id', $laporanObjek->pluck('id'));
                            // $query->where('status_verifikasi_arsiparis', 'disetujui');
                        })->get();
        $norma_hasil_arr = [];

        foreach ($norma_hasil as $dokumen) {
            if ($dokumen->jenis == 1) {
                $bulan_id = $dokumen->normaHasilAccepted->normaHasil->laporan_pengawasan_id;
                $norma_hasil_arr[$bulan_id] = $dokumen->normaHasilAccepted;
            }
            else {
                $bulan_id = $dokumen->normaHasilDokumen->laporan_pengawasan_id;
                $norma_hasil_arr[$bulan_id] = $dokumen->normaHasilDokumen;
            }
            $norma_hasil_arr[$bulan_id]['jenis'] = $dokumen->jenis;
        } 

        $kendali_mutu = KendaliMutuTim::whereIn('laporan_pengawasan_id', $laporanObjek->pluck('id'))->get();
                        // ->where('status', 'disetujui')->get();
        $kendali_mutu_arr = [];

        foreach ($kendali_mutu as $dokumen) {
            $kendali_mutu_arr[$dokumen->laporan_pengawasan_id] = $dokumen;
        }
                 
        return view('pegawai.tugas-tim.index', [
            'type_menu' => 'tugas-tim',
            'laporanObjek' => $laporanObjek,
            'months' => $months,
            'norma_hasil' => $norma_hasil_arr,
            'kendali_mutu' => $kendali_mutu_arr,
            'surat_tugas' => $surat_tugas_arr
        ]);
    }

}
