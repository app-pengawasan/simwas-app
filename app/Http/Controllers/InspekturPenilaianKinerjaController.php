<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\NilaiInspektur;
use App\Models\PelaksanaTugas;
use App\Models\RealisasiKinerja;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class InspekturPenilaianKinerjaController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('inspektur');

        //realisasi untuk dinilai
        if ((auth()->user()->is_aktif) && (auth()->user()->unit_kerja == '8000') ) {
            $realisasiDinilai = RealisasiKinerja::where('status', 1)->get();
            $realisasiWithEvents = RealisasiKinerja::where('status', 1)
                                   ->join('events', 'realisasi_kinerjas.id_pelaksana', '=', 'events.id_pelaksana')
                                   ->get();
        } else {
            $realisasiDinilai = RealisasiKinerja::whereRelation('pelaksana.user', function (Builder $query){
                                    $query->where('unit_kerja', auth()->user()->unit_kerja);
                                })->where('status', 1)->get();
            $realisasiWithEvents = RealisasiKinerja::whereRelation('pelaksana.user', function (Builder $query){
                                    $query->where('unit_kerja', auth()->user()->unit_kerja);
                                })->where('status', 1)
                                  ->join('events', 'realisasi_kinerjas.id_pelaksana', '=', 'events.id_pelaksana')
                                  ->get();
        }

        //realisasi berstatus selesai group by bulan dan tahun realisasi, diambil id_pelaksana nya
        $pelaksanaDinilai = $realisasiDinilai
                            ->groupBy([function ($items){
                                return date("Y",strtotime($items->updated_at));
                            }, function ($items){
                                return date("m",strtotime($items->updated_at));
                            }])->map->map->map->map->map->map->map->id_pelaksana->toArray();

        $realisasiCount = [];

        foreach ($pelaksanaDinilai as $tahun => $bulanitems) {
            foreach ($bulanitems as $bulan => $items) {
                foreach ($items as $id_pelaksana) {
                    $realisasi = $realisasiWithEvents->where('id_pelaksana', $id_pelaksana);
                    foreach ($realisasi as $item) {
                        $id_pegawai = $item->pelaksana->id_pegawai;
                        $start = $item->start;
                        $end = $item->end;
                        $realisasi_jam = (strtotime($end) - strtotime($start)) / 60 / 60;
                        //jam realisasi pegawai per bulan
                        isset($realisasiCount[$id_pegawai][$tahun]['realisasi_jam'][$bulan]) ?
                            $realisasiCount[$id_pegawai][$tahun]['realisasi_jam'][$bulan] += $realisasi_jam :
                            $realisasiCount[$id_pegawai][$tahun]['realisasi_jam'][$bulan] = $realisasi_jam;
                        //jam realisasi pegawai per tahun
                        isset($realisasiCount[$id_pegawai][$tahun]['realisasi_jam']['all']) ?
                            $realisasiCount[$id_pegawai][$tahun]['realisasi_jam']['all'] += $realisasi_jam :
                            $realisasiCount[$id_pegawai][$tahun]['realisasi_jam']['all'] = $realisasi_jam;
                    }
                }
            }
        }

        $bulans = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $tugasCount = $realisasiDinilai
                        ->groupBy(['pelaksana.id_pegawai', function ($items){
                                        return date("Y",strtotime($items->updated_at));
                                    }])
                        ->map->map(function ($items) use ($bulans) {
                            $rencana_jam = 0;
                            foreach ($bulans as $bulan) {
                                $rencana_jam += $items->sum('pelaksana.'.$bulan);
                            }
                            return [
                                'nama' => $items[0]->pelaksana->user->name,
                                'count' => $items->countBy(function ($item) {
                                                        return date("m",strtotime($item->updated_at));
                                                    })->toArray(), //jumlah tugas per bulan
                                'count_all' => $items->count(),
                                'avg' => $items->groupBy(function ($item) { //rata rata nilai per bulan
                                                    return date("m",strtotime($item->updated_at));
                                                })->map->avg->map->nilai->toArray(),
                                'avg_all' => $items->avg->nilai,
                                'rencana_jam' => $items->groupBy(function ($item) {
                                                            return date("m",strtotime($item->updated_at));
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

        if (!empty($tugasCount)) {
            $tugasCount = array_replace_recursive($tugasCount, $realisasiCount);
            foreach ($tugasCount as $id_pegawai => &$count) {
                foreach ($count as $tahun => $values) {
                    foreach ($values['count'] as $bulan => $jumlah_tugas) {
                        $nilai_ins = NilaiInspektur::where('id_pegawai', $id_pegawai)
                                    ->where('bulan', $bulan)->where('tahun', $tahun)->first();
                        if ($nilai_ins) {
                            $count[$tahun]['nilai_ins'][$bulan] = optional($nilai_ins)->nilai;
                            $count[$tahun]['catatan'][$bulan] = $nilai_ins->catatan;
                        }
                    }
                    $count[$tahun]['count']['all'] = $count[$tahun]['count_all'];
                    $count[$tahun]['avg']['all'] = $count[$tahun]['avg_all'];
                    $count[$tahun]['rencana_jam']['all'] = $count[$tahun]['rencana_jam_all'];
                    $count[$tahun]['nilai_ins']['all'] = NilaiInspektur::where('id_pegawai', $id_pegawai)
                                                        ->where('tahun', $tahun)->avg('nilai');
                }
            }
        }

        return view('inspektur.penilaian-kinerja.index', [
            'tugasCount' => $tugasCount
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
        $this->authorize('inspektur');

        $rule = ['nilai' => 'decimal:0,2|between:0,100'];
        $message = [
            'decimal' => 'Nilai maksimal memiliki 2 angka desimal. Contoh: 98.67',
            'between' => 'Nilai harus antara 0-100'
        ];

        $validateData = request()->validate($rule, $message);
        $validateData['id_pegawai'] = $request->id_pegawai;
        $validateData['bulan'] = $request->bulan;
        $validateData['tahun'] = $request->tahun;
        $validateData['catatan'] = $request->catatan;

        NilaiInspektur::create($validateData);

        $request->session()->put('status', 'Berhasil memberi nilai.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil menambahkan nilai'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pegawai_dinilai, $bulan, $tahun)
    {
        $this->authorize('inspektur');

        //tugas yang akan dinilai
        $tugas = PelaksanaTugas::where('id_pegawai', $pegawai_dinilai)
            ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query){
                $query->whereIn('status', [1,2]);
            })->select('id_pelaksana');

        //realisasi untuk dinilai
        if ($bulan == 'all') {
            $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugas)
                                ->whereYear('updated_at', $tahun)->where('status', 1)->get();
        } else {
            $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugas)->where('status', 1)
                                ->whereYear('updated_at', $tahun)->whereMonth('updated_at', $bulan)->get();
        }
        $realisasiDinilaiAll = Event::whereIn('id_pelaksana', $tugas)->get();

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

        // $events = Event::get();
        $events = Event::whereIn('id_pelaksana', $tugas)->get();

        foreach ($events as $event) {
            $realisasi = RealisasiKinerja::where('id_pelaksana', $event->id_pelaksana)->get();
            if ($realisasi->isEmpty()) $event->color = 'orange';
            else {
                if ($realisasi->contains('status', 1)) $event->color = 'green';
                else $event->color = 'red';
            }
            // $realisasi = RealisasiKinerja::where('id_pelaksana', $event->id_pelaksana)
            //             ->where('tgl', date_format(date_create($event->start), 'Y-m-d'))
            //             ->where('start', date_format(date_create($event->start), 'H:i:s'))
            //             ->where('end', date_format(date_create($event->end), 'H:i:s'))->first();
            // $event->tim = $event->pelaksana->rencanaKerja->proyek->timkerja->nama;
            // $event->proyek = $event->pelaksana->rencanaKerja->proyek->nama_proyek;
            // $event->status = $realisasi->status;
            $event->title = $event->pelaksana->rencanaKerja->tugas;
            if ($bulan != 'all')  $event->initialDate = $realisasiDinilai->first()->updated_at;
            // $event->hasil_kerja = $realisasi->hasil_kerja;
            // $event->catatan = $realisasi->catatan;
        }

        return view('inspektur.penilaian-kinerja.show', [
            'type_menu' => 'realisasi-kinerja',
            'jabatan'   => $this->jabatan,
            'id_pegawai'=> $pegawai_dinilai,
            'events'    => $events,
            'jamRealisasi' => $jamRealisasi,
            'bulan' => $bulan,
            'tahun' => $tahun
        ])
        ->with('realisasiDinilai',$realisasiDinilai);
    }

    public function detail($id)
    {
        $this->authorize('inspektur');

        $realisasi = RealisasiKinerja::findOrfail($id);
        $events = Event::where('id_pelaksana', $realisasi->id_pelaksana)->get();

        return view('components.realisasi-kinerja.show', [
            'type_menu'     => 'realisasi-kinerja',
            'jabatan'       => $this->jabatan,
            'status'        => $this->status,
            'colorText'     => $this->colorText,
            'hasilKerja'    => $this->hasilKerja,
            'kembali'       => 'nilai-inspektur',
            'events'        => $events
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
        $this->authorize('inspektur');

        $rule = ['nilai' => 'decimal:0,2|between:0,100'];
        $message = [
            'decimal' => 'Nilai maksimal memiliki 2 angka desimal. Contoh: 98.67',
            'between' => 'Nilai harus antara 0-100'
        ];

        $validateData = request()->validate($rule, $message);
        $validateData['catatan'] = $request->catatan;

        NilaiInspektur::where('id', $id)->update($validateData);

        $request->session()->put('status', 'Berhasil memberi nilai.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui'
        ]);
    }

    public function getNilai($id_pegawai, $bulan, $tahun){
        $this->authorize('inspektur');

        $nilai = NilaiInspektur::where('id_pegawai', $id_pegawai)
                ->where('bulan', $bulan)->where('tahun', $tahun)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Get Nilai',
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
