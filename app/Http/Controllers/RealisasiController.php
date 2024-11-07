<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\LaporanObjekPengawasan;
use App\Models\ObjekPengawasan;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use Illuminate\Validation\Rule;
use App\Models\RealisasiKinerja;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class RealisasiController extends Controller
{
    protected $colorText = [
        1   => 'success',
        2   => 'danger',
        3   => 'dark',
    ];

    protected $status = [
        1   => 'Selesai',
        2   => 'Dibatalkan',
        3   => 'Tidak Selesai'
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
        '2'      => 'Kertas Kerja'
    ];

    protected $jabatan = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim', 'PJ Kegiatan'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $realisasi = RealisasiKinerja::whereRelation(
                    'pelaksana', function (Builder $query){
                        $id_pegawai = auth()->user()->id;
                        $query->where('id_pegawai', $id_pegawai);
                    })->orderByDesc('created_at')->get();

        return view('pegawai.realisasi.index',[
            'type_menu'     => 'realisasi-kinerja',
            'realisasi'     => $realisasi,
            'status'        => $this->status,
            'colorText'     => $this->colorText
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_pegawai = auth()->user()->id;

        $tugasSaya = PelaksanaTugas::where('id_pegawai', $id_pegawai)
                    ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query){
                        $query->whereIn('status', [1,2]);
                    })->get();
        
        $oPengawasan = ObjekPengawasan::whereRelation('rencanaKerja.pelaksana.user', function (Builder $query) use ($id_pegawai){
            $query->where('id', $id_pegawai);
        })->get();
    
        $bulanPengawasan = LaporanObjekPengawasan::whereIn('id_objek_pengawasan', $oPengawasan->pluck('id_opengawasan'))
                    ->where('status', 1)->get(); 
        
        //menghapus bulan yang sudah terisi realisasinya
        foreach ($bulanPengawasan as $key => $bulan) {
            if (RealisasiKinerja::where('id_laporan_objek', $bulan->id)
                    ->whereRelation('pelaksana', function (Builder $query) use ($id_pegawai){
                        $query->where('id_pegawai', $id_pegawai);
                    })->get()->isNotEmpty()
                )
                $bulanPengawasan->forget($key);
        } 
        
        //menghapus objek yang sudah terisi semua realisasinya
        foreach ($oPengawasan as $key => $objek) {
            if (!$bulanPengawasan->pluck('id_objek_pengawasan')->contains($objek->id_opengawasan)) 
                $oPengawasan->forget($key);
        }

        // //menghapus tugas yang sudah terisi realisasinya
        foreach ($tugasSaya as $key => $ts) {
            if (!$oPengawasan->pluck('id_rencanakerja')->contains($ts->id_rencanakerja)) 
                $tugasSaya->forget($key);
        }

        //mengambil tim dan proyek unik
        $proyek = [];
        $tim = [];
        foreach ($tugasSaya as $ts) {
            $tim[$ts->rencanaKerja->proyek->timkerja->id_timkerja] = $ts->rencanaKerja->timkerja->nama;
            $proyek[$ts->rencanaKerja->proyek->id] = [
                'nama_proyek' => $ts->rencanaKerja->proyek->nama_proyek,
                'tim'    => $ts->rencanaKerja->proyek->timkerja->id_timkerja
            ];
        }

        $events = Event::where('id_pegawai', $id_pegawai)->orderBy('start')->get(); 

        return view('pegawai.realisasi.create',
            [
                'type_menu'     => 'realisasi-kinerja',
                'tugasSaya'     => $tugasSaya,
                'status'        => $this->status,
                'hasilKerja'    => $this->hasilKerja,
                'timkerja'      => $tim,
                'proyeks'       => $proyek,
                'events'        => $events,
                'oPengawasan'   => $oPengawasan,
                'bulanPengawasan' => $bulanPengawasan
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'tugas'         => 'required',
            'tim'           => 'required',
            'proyek'        => 'required',
            'status'        => 'required',
            'bulan'         => 'required',
            'rencana_kerja' => 'required',
            'iki'           => 'required',
            'kegiatan'      => 'required',
            'capaian'       => 'required',
            'hasil_kerja'   => 'required_if:status,1|nullable|url',
            'catatan'       => 'required_unless:status,1',
        ];

        $customMessages = [
            'required' => ':attribute harus diisi',
            'required_if' => ':attribute harus diisi jika status selesai',
            'required_unless' => ':attribute harus diisi jika status bukan selesai',
            'url' => ':attribute harus berupa url/link',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $realisasiData = $request->validate($rules);

        $realisasiData['id_pelaksana'] = $realisasiData['tugas'];
        $realisasiData['id_laporan_objek'] = $realisasiData['bulan'];

        RealisasiKinerja::create($realisasiData);

        $request->session()->put('status', 'Berhasil mengisi realisasi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil realisasi kinerja.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $realisasi = RealisasiKinerja::findOrfail($id);
        $events = Event::where('laporan_opengawasan', $realisasi->id_laporan_objek)
                        ->where('id_pegawai', $realisasi->pelaksana->id_pegawai)->get();

        return view('components.realisasi-kinerja.show', [
            'type_menu' => 'realisasi-kinerja',
            'jabatan'   => $this->jabatan,
            'status'        => $this->status,
            'colorText'     => $this->colorText,
            'hasilKerja'    => $this->hasilKerja,
            'kembali'       => 'realisasi',
            'events'        => $events
            ])
            ->with('realisasi', $realisasi);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $realisasi = RealisasiKinerja::findOrfail($id);

        $events = Event::where('id_pegawai', $realisasi->pelaksana->id_pegawai)
                    ->where('laporan_opengawasan', $realisasi->id_laporan_objek)->get();

        return view('pegawai.realisasi.edit', [
            'type_menu' => 'realisasi-kinerja',
            'status'        => $this->status,
            'colorText'     => $this->colorText,
            'events'        => $events
            ])
            ->with('realisasi', $realisasi);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [      
            'status'        => 'required',
            'rencana_kerja' => 'required',
            'iki'           => 'required',
            'kegiatan'      => 'required',
            'capaian'       => 'required',
            'edit-link'     => 'required_if:status,1|nullable|url',
            'catatan'       => 'required_unless:status,1',
            
        ];

        $customMessages = [
            'required' => ':attribute harus diisi',
            'required_if' => ':attribute harus diisi',
            'required_unless' => ':attribute harus diisi jika status bukan selesai',
            'url' => ':attribute harus berupa url/link',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages, ['edit-link' => 'hasil kerja']);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        $validateData['hasil_kerja'] = $validateData['edit-link'];
        $validateData['catatan'] = $request->catatan;

        $realisasiEdit = RealisasiKinerja::where('id', $id)->update(Arr::except($validateData, ['edit-link']));

        $request->session()->put('status', 'Berhasil memperbarui data realisasi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $realisasiEdit
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $realisasi = RealisasiKinerja::where('id', $id)->first();
        $realisasi->delete();

        // $event = Event::where('id_pelaksana', $realisasi->id_pelaksana)
        //                 ->where('start', $realisasi->tgl.' '.$realisasi->start)
        //                 ->where('end', $realisasi->tgl.' '.$realisasi->end)->first();
        // $event->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!',
        ]);
    }
}
