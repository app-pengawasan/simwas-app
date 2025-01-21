<?php

namespace App\Http\Controllers;

use App\Models\KendaliMutuTim;
use App\Models\LaporanObjekPengawasan;
use App\Models\NormaHasilTim;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\RencanaKerja;
use App\Models\TimKerja;
use App\Models\UsulanSuratSrikandi;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Time;

class AdminKinerjaTimController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('admin');

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

        return view('admin.kinerja-tim.index',[
            'type_menu'     => 'kinerja-tim',
            'months'    => $this->months
        ])->with('data_tim', $data_tim);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $bulan)
    {
        $this->authorize('admin');

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

        return view('admin.kinerja-tim.show', [
            'type_menu' => 'kinerja-tim',
            'laporanObjek' => $laporanObjek,
            'months' => $this->months,
            'norma_hasil' => $norma_hasil_arr,
            'kendali_mutu' => $kendali_mutu_arr,
            'surat_tugas' => $surat_tugas_arr,
            'bulan' => $bulan
        ]);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $start = $request->tgl.' '.$request->start;
    //     $end = $request->tgl.' '.$request->end;
    //     $duplicateStart = Event::where('start', '<=', $start)->where('end', '>', $start)->count();
    //     $duplicateEnd = Event::where('start', '<=', $end)->where('end', '>', $end)->count();

    //     $rules = [
    //         'id_pelaksana'   => 'required',
    //         'start'             => [
    //                                     'required',
    //                                     'date_format:H:i',
    //                                     'before:end',
    //                                     Rule::when($duplicateStart != 0 , ['boolean'])
    //                                ],
    //         'end'               => [
    //                                     'required',
    //                                     'date_format:H:i',
    //                                     'after:start',
    //                                     Rule::when($duplicateStart != 0 && $duplicateEnd != 0, ['boolean'])
    //                                 ],
    //         'aktivitas'         => 'required',
    //     ];

    //     $customMessages = [
    //         'boolean' => 'Sudah ada aktivitas pada jam ini',
    //         'required' => ':attribute harus diisi',
    //         'date_format' => 'Format jam harus JJ:MM',
    //         'before' => 'Jam mulai harus sebelum jam selesai',
    //         'after' => 'Jam selesai harus setelah jam mulai',
    //     ];

    //     $validator = Validator::make($request->all(), $rules, $customMessages)
    //                 ->setAttributeNames(
    //                     [
    //                         'id_pelaksana' => 'Tugas',
    //                         'aktivitas' => 'Aktivitas',
    //                     ], // Your field name and alias
    //                 );

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $validateData = $request->validate($rules);
    //     $validateData['start'] = $start;
    //     $validateData['end'] = $end;

    //     Event::create($validateData);
    //     $request->session()->put('status', 'Berhasil menambahkan aktivitas.');
    //     $request->session()->put('alert-type', 'success');

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Berhasil menambah aktivitas.',
    //     ]);
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $event = Event::where('id', $id)->get();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Detail Data Event',
    //         'data'    => $event
    //     ]);
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $rules = [
    //         'start'             => 'required|date_format:H:i|before:end',
    //         'end'               => 'required|date_format:H:i|after:start',
    //         'aktivitas'         => 'required',
    //         'tgl'               => 'required|date_format:Y-m-d',
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $validateData = $request->validate($rules);
    //     $validateData['start'] = $request->tgl.' '.$request->start;
    //     $validateData['end'] = $request->tgl.' '.$request->end;

    //     $eventEdit = Event::where('id', $id)->update(Arr::except($validateData, ['tgl']));

    //     $request->session()->put('status', 'Berhasil memperbarui data aktivitas.');
    //     $request->session()->put('alert-type', 'success');

    //     return response()->json([
    //         'success'   => true,
    //         'message'   => 'Data Berhasil Diperbarui',
    //         'data'      => $eventEdit
    //     ]);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Request $request, $id)
    // {
    //     Event::destroy($id);
    //     $request->session()->put('status', 'Berhasil menghapus data aktivitas.');
    //     $request->session()->put('alert-type', 'success');

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Berhasil menghapus data aktivitas',
    //     ]);
    // }
}
