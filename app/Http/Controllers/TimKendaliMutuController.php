<?php

namespace App\Http\Controllers;

use App\Models\StKinerja;
use App\Models\NormaHasil;
use Illuminate\Http\Request;
use App\Models\SuratTugasTim;
use App\Models\KendaliMutuTim;
use App\Models\PelaksanaTugas;
use App\Models\ObjekPengawasan;
use Illuminate\Validation\Rule;
use App\Models\NormaHasilAccepted;
use Illuminate\Support\Facades\File;
use App\Models\LaporanObjekPengawasan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class TimKendaliMutuController extends Controller
{
    private $kodeHasilPengawasan = [
    "110" => 'LHA',
    "120" => 'LHK',
    "130" => 'LHT',
    "140" => 'LHI',
    "150" => 'LHR',
    "160" => 'LHE',
    "170" => 'LHP',
    "180" => 'LHN',
    "190" => 'LTA',
    "200" => 'LTR',
    "210" => 'LTE',
    "220" => 'LKP',
    "230" => 'LKS',
    "240" => 'LKB',
    "500" => 'EHP',
    "510" => 'LTS',
    "520" => 'PHP',
    "530" => 'QAP'
];
    private $hasilPengawasan = [
    "110" => "Laporan Hasil Audit Kepatuhan",
    "120" => "Laporan Hasil Audit Kinerja",
    "130" => "Laporan Hasil Audit ADTT",
    "140" => "Laporan Hasil Audit Investigasi",
    "150" => "Laporan Hasil Reviu",
    "160" => "Laporan Hasil Evaluasi",
    "170" => "Laporan Hasil Pemantauan",
    "180" => "Laporan Hasil Penelaahan",
    "190" => "Laporan Hasil Monitoring Tindak Lanjut Hasil Audit",
    "200" => "Laporan Hasil Monitoring Tindak Lanjut Hasil Reviu",
    "210" => "Laporan Hasil Monitoring Tindak Lanjut Hasil Evaluasi",
    "220" => "Laporan Pendampingan",
    "230" => "Laporan Sosialisasi",
    "240" => "Laporan Bimbingan Teknis",
    "500" => "Evaluasi Hasil Pengawasan",
    "510" => "Telaah Sejawat",
    "520" => "Pengolahan Hasil Pengawasan",
    "530" => "Penjaminan Kualitas Pengawasan"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_pegawai = auth()->user()->id;

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

        $tugasSaya = PelaksanaTugas::where('id_pegawai', $id_pegawai)->get();

        // $dokumen = KendaliMutuTim::whereIn('tugas_id', $tugasSaya->pluck('id_rencanakerja'))->get();
        $dokumen = KendaliMutuTim::whereRelation('laporanObjekPengawasan.objekPengawasan', function (Builder $query) use ($tugasSaya) {
                        $query->whereIn('id_rencanakerja', $tugasSaya->pluck('id_rencanakerja'));
                    })->get();

        $oPengawasan = ObjekPengawasan::whereRelation('rencanaKerja.pelaksana.user', function (Builder $query) use ($id_pegawai) {
                            $query->where('id', $id_pegawai);
                        })->get();
    
        $bulanPelaporan = LaporanObjekPengawasan::whereIn('id_objek_pengawasan', $oPengawasan->pluck('id_opengawasan'))
                            ->where('status', 1)->get();
        
        //menghapus bulan yang sudah terisi realisasinya
        foreach ($bulanPelaporan as $key => $bulan) {
            if (KendaliMutuTim::where('laporan_pengawasan_id', $bulan->id)->get()->isNotEmpty())
                $bulanPelaporan->forget($key);
        }
        
        //menghapus objek yang sudah terisi semua realisasinya
        foreach ($oPengawasan as $key => $objek) {
            if (!$bulanPelaporan->pluck('id_objek_pengawasan')->contains($objek->id_opengawasan)) 
                $oPengawasan->forget($key);
        }

        // //menghapus tugas yang sudah terisi realisasinya
        foreach ($tugasSaya as $key => $ts) {
            if (!$oPengawasan->pluck('id_rencanakerja')->contains($ts->id_rencanakerja)) 
                $tugasSaya->forget($key);
        }
                    
        return view('pegawai.tugas-tim.km.index', [
            // 'draf' => $draf,
            'type_menu' => 'tugas-tim',
            'tugasSaya' => $tugasSaya,
            'dokumen'     => $dokumen,
            'oPengawasan' => $oPengawasan,
            'bulanPelaporan' => $bulanPelaporan,
            'months'    => $months
            // 'laporan' => $laporan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'is_ada' => 'required',
            'tugas' => ['required', 'string'],
            'objek' => ['required'],
            'bulan' => ['required'],
            'catatan' => ['required_if:is_ada,0'],
            'file' => [Rule::requiredIf(!isset($request->link) && $request->is_ada == 1), 'file', 'mimes:rar,zip', 'max:5120'],
            'link' => [Rule::requiredIf(!isset($request->file) && $request->is_ada == 1), 'nullable', 'url']
        ];

        $messages = [
            'required' => ':attribute harus diisi',
            'required_if' => ':attribute harus diisi',
            'max' => 'Ukuran file maksimal 5MB',
            'url' => 'Isi berupa url/link valid atau pilih file rar/zip',
            'mimes' => 'Format file harus rar/zip'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        if (isset($validateData['file'])) {
            $file = $request->file('file');
            $fileName = time() . '-kendali-mutu.' . $file->getClientOriginalExtension();
            $path = public_path('storage/tim/km');
            $file->move($path, $fileName);
            $path = 'storage/tim/km/' . $fileName;
        } else $path = $validateData['link'];

        if ($request->is_ada == 0) $status = 'tidak ada';
        else $status = 'diperiksa';

        KendaliMutuTim::create([
            'laporan_pengawasan_id' => $validateData['bulan'],
            'path' => $path,
            'status' => $status,
            'catatan' => $validateData['catatan'],
        ]);

        // return back with success message
        return redirect()->back()->with('success', 'Kendali Mutu Berhasil Diunggah');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $surat = KendaliMutuTim::findOrfail($id);

        // return view('pegawai.tugas-tim.km.show', [
        //     'type_menu' => 'tugas-tim',
        //     'surat'     => $surat
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function edit(NormaHasil $norma_hasil)
    {

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
            'edit-file' => ['required_if:edit-link,0', 'file', 'mimes:rar,zip', 'max:5120'],
            'edit-link' => ['required_if:edit-file,0', 'url']
        ];

        $messages = [
            'require_if' => ':attribute harus diisi',
            'max' => 'Ukuran file maksimal 5MB',
            'url' => 'Isi berupa url/link valid atau pilih file rar/zip',
            'mimes' => 'Format file harus rar/zip'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        $surat = KendaliMutuTim::findOrFail($id);
        $path_old = $surat->path;
        File::delete(public_path().'/'.$path_old);

        if (isset($validateData['edit-file'])) {
            $file = $request->file('edit-file');
            $fileName = time() . '-kendali-mutu.' . $file->getClientOriginalExtension();
            $path = public_path('storage/tim/km');
            $file->move($path, $fileName);
            $path_new = 'storage/tim/km/' . $fileName;
        } else $path_new = $validateData['edit-link'];

        $surat->update([
            'path' => $path_new,
            'status' => 'diperiksa',
            'catatan' => NULL
        ]);

        return redirect()->back()->with('success', 'Surat Tugas Berhasil Diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function destroy(NormaHasil $normaHasil)
    {
        //
    }

    public function download($id)
    {
        $surat = KendaliMutuTim::findOrfail($id);
        $file = public_path($surat->path);
        return response()->download($file);
    }
}
