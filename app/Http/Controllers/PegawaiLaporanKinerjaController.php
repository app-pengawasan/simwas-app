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

class PegawaiLaporanKinerjaController extends Controller
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
        $realisasiDone = RealisasiKinerja::whereRelation('pelaksana', function (Builder $query){
                                $query->where('id_pegawai', auth()->user()->id);
                            })->where('status', 1)->get()->groupBy(function ($realisasi) {
                                return date("Y",strtotime($realisasi->updated_at));
                            });

        $realisasiAll = RealisasiKinerja::whereRelation('pelaksana', function (Builder $query){
                            $query->where('id_pegawai', auth()->user()->id);
                        })->join('events', 'realisasi_kinerjas.id_pelaksana', '=', 'events.id_pelaksana')
                        ->get();

        $jamRealisasi = $realisasiAll->groupBy('id_pelaksana')
                            ->map(function ($items) {
                                    $realisasi_jam = 0;
                                    foreach ($items as $realisasi) {
                                        $start = $realisasi->start;
                                        $end = $realisasi->end;
                                        $realisasi_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                                    }
                                    return $realisasi_jam;
                            });

        $realisasiDone = $realisasiDone->map->groupBy(function ($realisasi) {
                            return date("m",strtotime($realisasi->updated_at));
                        });

        $nilai_ins = NilaiInspektur::where('id_pegawai', auth()->user()->id)->get(); 
        return view('pegawai.laporan-kinerja.index', [
            'jabatan' => $this->jabatan,
            'jamRealisasi' => $jamRealisasi,
            'nilai_ins' => $nilai_ins
        ])->with('realisasiDone', $realisasiDone);
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pegawai_dinilai, $bulan, $tahun)
    {
        // //tugas yang akan dinilai
        // $tugas = PelaksanaTugas::where('id_pegawai', $pegawai_dinilai)
        //     ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query){
        //         $query->where('status', 6);
        //     })->select('id_pelaksana');

        // //realisasi untuk dinilai
        // if ($bulan == 'all') {
        //     $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugas)
        //                         ->whereYear('tgl', $tahun)->where('status', 1)->get();
        //     $realisasiDinilaiAll = RealisasiKinerja::whereIn('id_pelaksana', $tugas)->get();
        // } else {
        //     $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugas)->where('status', 1)
        //                         ->whereYear('tgl', $tahun)->whereMonth('tgl', $bulan)->get();
        //     $realisasiDinilaiAll = RealisasiKinerja::whereIn('id_pelaksana', $tugas)->get();
        // }

        // $jamRealisasi = $realisasiDinilaiAll->groupBy('id_pelaksana')
        //                     ->map(function ($items) {
        //                             $realisasi_jam = 0;
        //                             foreach ($items as $realisasi) {
        //                                 $start = $realisasi->start;
        //                                 $end = $realisasi->end;
        //                                 $realisasi_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
        //                             }
        //                             return $realisasi_jam;
        //                     });

        // $events = Event::whereIn('id_pelaksana', $realisasiDinilai->pluck('id_pelaksana'))->get();

        // foreach ($events as $event) {
        //     $realisasi = RealisasiKinerja::where('id_pelaksana', $event->id_pelaksana)
        //                 ->where('tgl', date_format(date_create($event->start), 'Y-m-d'))
        //                 ->where('start', date_format(date_create($event->start), 'H:i:s'))
        //                 ->where('end', date_format(date_create($event->end), 'H:i:s'))->first();
        //     $event->tim = $event->pelaksana->rencanaKerja->proyek->timkerja->nama;
        //     $event->proyek = $event->pelaksana->rencanaKerja->proyek->nama_proyek;
        //     $event->status = $realisasi->status;
        //     $event->title = $event->pelaksana->rencanaKerja->tugas;
        //     if ($bulan != 'all')  $event->initialDate = $realisasiDinilai->first()->tgl;
        //     $event->hasil_kerja = $realisasi->hasil_kerja;
        //     $event->catatan = $realisasi->catatan;
        // }

        // return view('inspektur.penilaian-kinerja.show', [
        //     'type_menu' => 'realisasi-kinerja',
        //     'jabatan'   => $this->jabatan,
        //     'id_pegawai'=> $pegawai_dinilai,
        //     'events'    => $events,
        //     'jamRealisasi' => $jamRealisasi
        // ])
        // ->with('realisasiDinilai',$realisasiDinilai);
    }

    // public function detail($id)
    // {
    //     $this->authorize('inspektur');

    //     $realisasi = RealisasiKinerja::findOrfail($id);

    //     return view('components.realisasi-kinerja.show', [
    //         'type_menu'     => 'realisasi-kinerja',
    //         'jabatan'       => $this->jabatan,
    //         'status'        => $this->status,
    //         'colorText'     => $this->colorText,
    //         'hasilKerja'    => $this->hasilKerja,
    //         'kembali'       => 'nilai-inspektur'
    //         ])
    //         ->with('realisasi', $realisasi);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
