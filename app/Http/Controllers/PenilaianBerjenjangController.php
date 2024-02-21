<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\RealisasiKinerja;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class PenilaianBerjenjangController extends Controller
{
    protected $colorText = [
        1   => 'success',
        2   => 'primary',
    ];

    protected $status = [
        1   => 'Selesai',
        2   => 'Belum selesai',
    ];

    protected $hasilKerja = [
        'mhk001' => 'Konsep rencana strategis pengawasan internal',
        'mhk002' => 'Konsep rencana pengawasan tahunan',
        'mhk003' => 'Laporan Hasil Pemantauan rencana pengawasan tahunan',
        'mhk004' => 'Peraturan/pedoman pengawasan intern',
        'mhk005' => 'Kebijakan pengawasan internal',
        'mhk006' => 'Laporan Hasil Audit Kinerja',
        'mhk007' => 'Laporan Hasil audit dengan tujuan tertentu',
        'mhk008' => 'Laporan Hasil Audit Investigatif/PKKN',
        'mhk009' => 'Laporan Hasil Reviu',
        'mhk010' => 'Laporan Hasil Evaluasi',
        'mhk011' => 'Laporan Hasil Pemantauan',
        'mhk012' => 'Laporan Pemberian Keterangan Ahli',
        'mhk013' => 'Hasil Telaah',
        'mhk014' => 'Laporan Hasil Monitoring Tindak Lanjut',
        'mhk015' => 'Laporan Kegiatan Sosialisasi',
        'mhk016' => 'Laporan Kegiatan bimbingan teknis',
        'mhk017' => 'Laporan Kegiatan asistensi',
        'mhk018' => 'Laporan Hasil Evaluasi',
        'mhk019' => 'Laporan Hasil Telaah Sejawat',
        'mhk020' => 'Laporan Penjaminan Kualitas',
    ];

    protected $jabatan = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim'];

    protected $unitkerja = [
        '8000'    => 'Inspektorat Utama',
        '8010'    => 'Bagian Umum Inspektorat Utama',
        '8100'    => 'Inspektorat Wilayah I',
        '8200'    => 'Inspektorat Wilayah II',
        '8300'    => 'Inspektorat Wilayah III',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_pegawai = auth()->user()->id;

        //tugas penilai
        $tugasSaya = PelaksanaTugas::where('id_pegawai', $id_pegawai)
            ->whereRelation('rencanaKerja.timKerja', function (Builder $query){
                $query->where('status', 6);
            })->select('id_rencanakerja', 'pt_jabatan');
        
        //tugas jenjang di bawahnya
        $tugasDinilai = PelaksanaTugas::joinSub($tugasSaya, 'penilai', function (JoinClause $join) {
                $join->on('pelaksana_tugas.id_rencanakerja', '=', 'penilai.id_rencanakerja');
            })
            ->where('penilai.pt_jabatan', '<', 4) //penilai bukan anggota
            ->whereRaw(
                    '(
                        CASE
                            when penilai.pt_jabatan = 1 then pelaksana_tugas.pt_jabatan between 2 and 3
                            else pelaksana_tugas.pt_jabatan = 4 
                        end
                    )'
                )
            ->select('id_pelaksana');
        
        //realisasi untuk dinilai
        $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugasDinilai)->get();
        $jamRealisasiCount = $realisasiDinilai->groupBy('pelaksana.user.id')
                            ->map(function ($items) {
                                $realisasi_jam = 0;
                                foreach ($items as $realisasi) {
                                    $start = $realisasi->start;
                                    $end = $realisasi->end;
                                    $realisasi_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                                }
                                return [
                                    'realisasi_jam' => $items->groupBy(function ($item) {
                                                                    return date("m",strtotime($item->tgl));
                                                                })->map(function ($item) {
                                                                    $realisasi_jam = 0;
                                                                    foreach ($item as $realisasi) {
                                                                        $start = $realisasi->start;
                                                                        $end = $realisasi->end;
                                                                        $realisasi_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                                                                    }
                                                                    return $realisasi_jam;
                                                                })->toArray(), //realisasi jam kerja per bulan
                                    'realisasi_jam_all' => $realisasi_jam
                                ];
                            })->toArray();

        $bulans = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $tugasCount = $realisasiDinilai->where('status', 1)->groupBy('pelaksana.user.id')
                        ->map(function ($items) use ($bulans) {
                            $rencana_jam = 0;
                            foreach ($bulans as $bulan) {
                                $rencana_jam += $items->sum('pelaksana.'.$bulan);
                            }
                            return [
                                'nama' => $items[0]->pelaksana->user->name,
                                'unit_kerja' => $items[0]->pelaksana->user->unit_kerja,
                                'count' => $items->countBy(function ($item) {
                                                        return date("m",strtotime($item->tgl));
                                                    })->toArray(), //jumlah tugas per bulan
                                'count_all' => $items->count(),
                                'avg' => $items->groupBy(function ($item) {
                                                    return date("m",strtotime($item->tgl));
                                                })->map(function ($item) {
                                                    return round($item->avg('nilai'), 2);
                                                })->toArray(), //rata rata nilai per bulan
                                'avg_all' => round($items->avg('nilai'), 2),
                                'rencana_jam' => $items->groupBy(function ($item) {
                                                            return date("m",strtotime($item->tgl));
                                                        })->map(function ($item)  use ($bulans) {
                                                            $rencana_jam = 0;
                                                            foreach ($bulans as $bulan) {
                                                                $rencana_jam += $item->sum('pelaksana.'.$bulan);
                                                            }
                                                            return $rencana_jam;
                                                        })->toArray(), //rencana jam kerja per bulan
                                'rencana_jam_all' => $rencana_jam,
                            ];
                        })->toArray();

        $tugasCount = array_replace_recursive($tugasCount, $jamRealisasiCount);
        foreach ($tugasCount as $id_pegawai => &$tugas) {
            $tugas['count']['all'] = $tugas['count_all'];
            $tugas['avg']['all'] = $tugas['avg_all'];
            $tugas['rencana_jam']['all'] = $tugas['rencana_jam_all'];
            $tugas['realisasi_jam']['all'] = $tugas['realisasi_jam_all'];
        }

        return view('pegawai.penilaian-berjenjang.index', [
            'type_menu' => 'realisasi-kinerja',
            // 'realisasiDinilai' => $realisasiDinilai,
            'tugasCount' => $tugasCount,
            'unitkerja' => $this->unitkerja
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $rule = ['nilai' => 'required|integer|between:0,100'];

        // $validateData = request()->validate($rule);
        // $validateData['penilai'] = auth()->user()->id;

        // RealisasiKinerja::create($validateData);

        // return redirect(route('pegawai.penilaian-berjenjang.show', $request->id_pegawai))
        //     ->with('status', 'Berhasil menambahkan nilai.')
        //     ->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pegawai_dinilai, $bulan)
    {
        $id_pegawai = auth()->user()->id;

        //tugas penilai
        $tugasSaya = PelaksanaTugas::where('id_pegawai', $id_pegawai)
            ->whereRelation('rencanaKerja.timKerja', function (Builder $query){
                $query->where('status', 6);
            })->select('id_rencanakerja', 'pt_jabatan');
        
        //tugas yang akan dinilai
        $tugasDinilai = PelaksanaTugas::joinSub($tugasSaya, 'penilai', function (JoinClause $join) {
                $join->on('pelaksana_tugas.id_rencanakerja', '=', 'penilai.id_rencanakerja');
            })
            ->where('penilai.pt_jabatan', '<', 4) //penilai bukan anggota
            ->where('pelaksana_tugas.id_pegawai', $pegawai_dinilai)
            ->whereRaw(
                    '(
                        CASE
                            when penilai.pt_jabatan = 1 then pelaksana_tugas.pt_jabatan between 2 and 3
                            else pelaksana_tugas.pt_jabatan = 4 
                        end
                    )'
                )
            ->select('id_pelaksana');
        
        //realisasi untuk dinilai
        if ($bulan == 'all') {
            $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugasDinilai)
                                                ->where('status', 1)->get();
            $realisasiDinilaiAll = RealisasiKinerja::whereIn('id_pelaksana', $tugasDinilai)->get();
        } else {
            $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugasDinilai)->where('status', 1)
                                                ->whereMonth('tgl', $bulan)->get();
            $realisasiDinilaiAll = RealisasiKinerja::whereIn('id_pelaksana', $tugasDinilai)
                                                ->whereMonth('tgl', $bulan)->get();
        } 

        $jamRealisasi = $realisasiDinilaiAll->groupBy('id_pelaksana')
                            ->map(function ($items) {
                                    $realisasi_jam = 0;
                                    foreach ($items as $realisasi) {
                                        $start = $realisasi->start;
                                        $end = $realisasi->end;
                                        $realisasi_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                                    }
                                    return $realisasi_jam;
                            });

        $events = Event::whereRelation('pelaksana', function (Builder $query) use ($pegawai_dinilai) {
                     $query->where('id_pegawai', $pegawai_dinilai);
                  })->get();

        foreach ($events as $event) {
            $realisasi = RealisasiKinerja::where('id_pelaksana', $event->id_pelaksana)
                        ->where('tgl', date_format(date_create($event->start), 'Y-m-d'))
                        ->where('start', date_format(date_create($event->start), 'H:i:s'))
                        ->where('end', date_format(date_create($event->end), 'H:i:s'))->first();
            $event->tim = $event->pelaksana->rencanaKerja->proyek->timkerja->nama;
            $event->proyek = $event->pelaksana->rencanaKerja->proyek->nama_proyek;
            $event->status = $realisasi->status;
            $event->title = $event->pelaksana->rencanaKerja->tugas;
            if ($bulan != 'all')  $event->initialDate = $realisasiDinilai->first()->tgl;
        }

        return view('pegawai.penilaian-berjenjang.show', [
            'type_menu' => 'realisasi-kinerja',
            'jabatan' => $this->jabatan,
            'id_pegawai'=> $pegawai_dinilai,
            'events'    => $events,
            'jamRealisasi' => $jamRealisasi
        ])
        ->with('realisasiDinilai',$realisasiDinilai);
    }

    public function detail($id)
    {
        $realisasi = RealisasiKinerja::findOrfail($id);

        return view('components.realisasi-kinerja.show', [
            'type_menu'     => 'realisasi-kinerja',
            'jabatan'       => $this->jabatan,
            'status'        => $this->status,
            'colorText'     => $this->colorText,
            'hasilKerja'    => $this->hasilKerja,
            'kembali'       => 'nilai'
            ])
            ->with('realisasi', $realisasi);
    }    

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rule = ['nilai' => 'decimal:0,2|between:0,100'];

        $validateData = request()->validate($rule);
        $validateData['penilai'] = auth()->user()->id;
        $validateData['catatan_penilai'] = $request->catatan;

        RealisasiKinerja::where('id', $id)->update($validateData);

        $request->session()->put('status', 'Berhasil memberi nilai.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui'
        ]);
    }

    public function getNilai($id){
        $nilai = RealisasiKinerja::where('id', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Realisasi by id',
            'data'      => $nilai
        ]);
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     RencanaKerja::where('id_rencanakerja', $id)->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data Berhasil Dihapus!',
    //     ]);
    // }

    // public function sendToAnalis($id){
    //     TimKerja::where('id_timkerja', $id)
    //     ->update(['status' => 2]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Berhasil Mengirim Rencana Kerja!',
    //     ]);

    // }
}
