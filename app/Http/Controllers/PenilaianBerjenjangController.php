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

        $tugasCount = [];
        
        foreach ($realisasiDinilai as $realisasi) {
            $pegawai_dinilai = $realisasi->pelaksana->id_pegawai;
            $bulan = date("m",strtotime($realisasi->tgl));

            //data per bulan
            if (array_key_exists($pegawai_dinilai, $tugasCount) && array_key_exists($bulan, $tugasCount[$pegawai_dinilai]))
                $tugasCount[$pegawai_dinilai][$bulan]['count'] = ++$tugasCount[$pegawai_dinilai][$bulan]['count'];
            else 
                $tugasCount[$pegawai_dinilai][$bulan] = [
                    'nama' => $realisasi->pelaksana->user->name,
                    'unit_kerja' => $realisasi->pelaksana->user->unit_kerja,
                    'count' => 1,
                    'dinilai' => 0,
                    'nilai' => 0,
                    'avg' => 0,
                ];

            //data semua bulan kumulatif
            if (array_key_exists($pegawai_dinilai, $tugasCount) && array_key_exists('all', $tugasCount[$pegawai_dinilai]))
                $tugasCount[$pegawai_dinilai]['all']['count'] = ++$tugasCount[$pegawai_dinilai]['all']['count'];
            else 
                $tugasCount[$pegawai_dinilai]['all'] = [
                    'nama' => $realisasi->pelaksana->user->name,
                    'unit_kerja' => $realisasi->pelaksana->user->unit_kerja,
                    'count' => 1,
                    'dinilai' => 0,
                    'nilai' => 0,
                    'avg' => 0,
                ];
            
            if ($realisasi->nilai != null) {
                ++$tugasCount[$pegawai_dinilai][$bulan]['dinilai'];
                ++$tugasCount[$pegawai_dinilai]['all']['dinilai'];
            } 

            $tugasCount[$pegawai_dinilai][$bulan]['nilai'] += $realisasi->nilai;
            $tugasCount[$pegawai_dinilai]['all']['nilai'] += $realisasi->nilai;

            if ($tugasCount[$pegawai_dinilai][$bulan]['dinilai'] != 0) 
                $tugasCount[$pegawai_dinilai][$bulan]['avg'] = $tugasCount[$pegawai_dinilai][$bulan]['nilai'] 
                                                               / $tugasCount[$pegawai_dinilai][$bulan]['dinilai'];
            
            if ($tugasCount[$pegawai_dinilai]['all']['dinilai'] != 0) 
                $tugasCount[$pegawai_dinilai]['all']['avg'] = $tugasCount[$pegawai_dinilai]['all']['nilai'] 
                                                                / $tugasCount[$pegawai_dinilai]['all']['dinilai'];
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
        if ($bulan == 'all') $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugasDinilai)->get();
        else $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugasDinilai)
                                 ->whereMonth('tgl', $bulan)->get();

        $events = Event::whereRelation('pelaksana', function (Builder $query) use ($pegawai_dinilai) {
                     $query->where('id_pegawai', $pegawai_dinilai);
                  })->get();

        foreach ($events as $event) {
            $event->title = $event->pelaksana->rencanaKerja->tugas;
            if ($bulan != 'all')  $event->initialDate = $realisasiDinilai->first()->tgl;
        }

        return view('pegawai.penilaian-berjenjang.show', [
            'type_menu' => 'realisasi-kinerja',
            'status'    => $this->status,
            'colorText' => $this->colorText,
            'id_pegawai'=> $pegawai_dinilai,
            'events'    => $events
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
