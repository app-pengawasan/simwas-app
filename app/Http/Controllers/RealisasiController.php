<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\RealisasiKinerja;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class RealisasiController extends Controller
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
        '2'      => 'Kertas Kerja'
    ];

    protected $jabatan = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim'];

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
                    })->get();

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
                    ->whereRelation('rencanaKerja.timKerja', function (Builder $query){
                        $query->where('status', 6);
                    })->get();
        
        //mengambil tim unik
        $tim = [];
        foreach ($tugasSaya as $ts) {
            $tim[$ts->rencanaKerja->timkerja->id_timkerja] = $ts->rencanaKerja->timkerja->nama;
        }

        return view('pegawai.realisasi.create',
            [
                'type_menu'     => 'realisasi-kinerja',
                'tugasSaya'     => $tugasSaya,
                'status'        => $this->status,
                'hasilKerja'    => $this->hasilKerja,
                'timkerja'      => $tim
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
            'tgl'           => 'required|date_format:Y-m-d',
            'start'         => 'required|date_format:H:i|before:end',
            'end'           => 'required|date_format:H:i|after:start',
            'status'        => 'required',
            'kegiatan'      => 'required',
            'capaian'       => 'required',
            'link'          => 'required_if:file,0|url',
            'file'          => 'required_if:link,0|mimes:pdf|max:500',
            'catatan'       => 'required_if:status,2'
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        if (array_key_exists("link", $validateData)) 
            $validateData['hasil_kerja'] = $validateData['link'];
        else {
            $validateData['hasil_kerja'] =  'Realisasi_'.time().'.'.$validateData['file']->getClientOriginalExtension();
            $validateData['file']->move(public_path()."/document/realisasi/", $validateData['hasil_kerja']);
        }

        $validateData['id_pelaksana'] = $validateData['tugas'];
        $validateData['catatan'] = $request->catatan;

        RealisasiKinerja::create($validateData);

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

        return view('components.realisasi-kinerja.show', [
            'type_menu' => 'realisasi-kinerja',
            'jabatan'   => $this->jabatan,
            'status'        => $this->status,
            'colorText'     => $this->colorText,
            'hasilKerja'    => $this->hasilKerja,
            'kembali'       => 'realisasi'
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

        return view('pegawai.realisasi.edit', [
            'type_menu' => 'realisasi-kinerja',
            'status'        => $this->status,
            'colorText'     => $this->colorText
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
        $realisasi = RealisasiKinerja::findOrfail($id);

        $rules = [
            'tgl'           => 'required|date_format:Y-m-d',
            'start'         => 'required|date_format:H:i|before:end',
            'end'           => 'required|date_format:H:i|after:start',
            'status'        => 'required',
            'kegiatan'      => 'required',
            'capaian'       => 'required',
            'edit-link'     => 'nullable|url',
            'edit-file'     => 'nullable|mimes:pdf|max:500',
            'catatan'       => 'required_if:status,2'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        if (array_key_exists("edit-link", $validateData) && $validateData['edit-link'] != '') 
            $validateData['hasil_kerja'] = $validateData['edit-link'];

        if (array_key_exists("edit-file", $validateData) && $validateData['edit-file'] != '') {
            File::delete(public_path()."/document/realisasi/".$realisasi->hasil_kerja);
            $validateData['hasil_kerja'] =  'Realisasi_'.time().'.'.$validateData['edit-file']->getClientOriginalExtension();
            $validateData['edit-file']->move(public_path()."/document/realisasi/", $validateData['hasil_kerja']);
        }

        $validateData['catatan'] = $request->catatan;
        
        $realisasiEdit = RealisasiKinerja::where('id', $id)->update(Arr::except($validateData, ['edit-link', 'edit-file']));

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
        File::delete(public_path()."/document/realisasi/".$realisasi->hasil_kerja);
        $realisasi->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!',
        ]);
    }
}
