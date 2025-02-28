<?php

namespace App\Http\Controllers;

use App\Models\StKinerja;
use App\Models\NormaHasil;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\ObjekPengawasan;
use App\Models\NormaHasilAccepted;
use Illuminate\Support\Facades\File;
use App\Models\LaporanObjekPengawasan;
use App\Models\NormaHasilDokumen;
use App\Models\NormaHasilTim;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class TimNormaHasilController extends Controller
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
            0 => '',
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

        $draf = NormaHasil::with('masterLaporan')->latest()->whereIn('tugas_id', $tugasSaya->pluck('id_rencanakerja'))
                ->where('status_norma_hasil', 'disetujui')
                ->whereRelation('normaHasilAccepted', function (Builder $query){
                    $query->where('status_verifikasi_arsiparis', 'belum unggah');
                })->get();

        $laporan = NormaHasilTim::
                    with('rencanaKerja','normaHasilAccepted.normaHasil.masterLaporan')->
                    latest()
                    ->whereIn('tugas_id', $tugasSaya->pluck('id_rencanakerja'))
                    ->whereRelation('normaHasilAccepted', function (Builder $query){
                        $query->whereNot('status_verifikasi_arsiparis', 'belum unggah');
                    })->orWhereRelation('normaHasilDokumen', function (Builder $query){
                        $query->whereNot('status_verifikasi_arsiparis', 'belum unggah');
                    })->get();

        $oPengawasan = ObjekPengawasan::whereRelation('rencanaKerja.pelaksana.user', function (Builder $query) use ($id_pegawai){
            $query->where('id', $id_pegawai);
        })->get();

        $bulanPelaporan = LaporanObjekPengawasan::whereIn('id_objek_pengawasan', $oPengawasan->pluck('id_opengawasan'))
                    ->where('status', 1)->get();

        //menghapus bulan yang sudah terisi norma hasilnya
        foreach ($bulanPelaporan as $key => $bulan) {
            $cekBulan = NormaHasilTim::
                        whereRelation('normaHasilAccepted.normaHasil', function (Builder $query) use ($bulan) {
                            $query->where('laporan_pengawasan_id', $bulan->id);
                        })->orWhereRelation('normaHasilDokumen', function (Builder $query) use ($bulan) {
                            $query->where('laporan_pengawasan_id', $bulan->id);
                        })->get()->isNotEmpty();
            if ($cekBulan) $bulanPelaporan->forget($key);
        }

        //menghapus objek yang sudah terisi semua norma hasilnya
        foreach ($oPengawasan as $key => $objek) {
            if (!$bulanPelaporan->pluck('id_objek_pengawasan')->contains($objek->id_opengawasan))
                $oPengawasan->forget($key);
        }

        //menghapus tugas yang sudah terisi semua norma hasilnya
        foreach ($tugasSaya as $key => $ts) {
            if (!$oPengawasan->pluck('id_rencanakerja')->contains($ts->id_rencanakerja))
                $tugasSaya->forget($key);
        }

        //menghapus nomor yang sudah terisi norma hasilnya
        foreach ($draf as $key => $un) {
            $cekBulan = NormaHasilTim::
                        whereRelation('normaHasilDokumen', function (Builder $query) use ($un) {
                            $query->where('laporan_pengawasan_id', $un->laporan_pengawasan_id);
                        })->get()->isNotEmpty();
            if ($cekBulan) $draf->forget($key);
        }

        return view('pegawai.tugas-tim.norma-hasil.index', [
            'draf' => $draf,
            'kodeHasilPengawasan' => $this->kodeHasilPengawasan,
            'type_menu' => 'tugas-tim',
            'laporan' => $laporan,
            'tugasSaya' => $tugasSaya,
            'months' => $months,
            'oPengawasan' => $oPengawasan,
            'bulanPelaporan' => $bulanPelaporan
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
            'tugas' => 'required',
            'jenis' => 'required',
            'bulan' => 'required',
            'objek' => 'required_if:jenis,2',
            'nomor' => ['required_if:jenis,1', 'string', 'max:26'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ];

        $messages = [
            'required' => ':attribute harus diisi',
            'required_if' => ':attribute harus diisi',
            'max' => 'Jumlah karakter maksimal 26',
            'file.max' => 'Ukuran file maksimal 1MB',
            'mimes' => 'Format file harus pdf'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        $file = $request->file('file');
        $fileName = time() . '-laporan-norma-hasil.' . $file->getClientOriginalExtension();
        $path = public_path('storage/tim/norma-hasil');
        $file->move($path, $fileName);
        $laporan_path = 'storage/tim/norma-hasil/' . $fileName;

        if ($validateData['jenis'] == 1) {
            $norma_hasil_acc = NormaHasilAccepted::where('id_norma_hasil', $validateData['nomor'])->first();
            $norma_hasil_acc->update([
                'laporan_path' => $laporan_path,
                'status_verifikasi_arsiparis' => 'diperiksa'
            ]);
            NormaHasilTim::create([
                'jenis' => $validateData['jenis'],
                'tugas_id' => $validateData['tugas'],
                'laporan_id' => $norma_hasil_acc->id
            ]);
        } else {
            $dokumen = NormaHasilDokumen::create([
                'laporan_pengawasan_id' => $validateData['bulan'],
                'laporan_path' => $laporan_path,
                'status_verifikasi_arsiparis' => 'diperiksa'
            ]);
            NormaHasilTim::create([
                'jenis' => $validateData['jenis'],
                'tugas_id' => $validateData['tugas'],
                'dokumen_id' => $dokumen->id
            ]);
        }

        // return back with success message
        return redirect()->back()->with('success', 'Laporan Norma Hasil Berhasil Diunggah');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $norma_hasil = NormaHasilTim::findOrFail($id);
        return view('pegawai.tugas-tim.norma-hasil.show', [
            "usulan" => $norma_hasil,
            'kodeHasilPengawasan' => $this->kodeHasilPengawasan,
            'type_menu' => 'tugas-tim'
        ]);
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
            'nama' => ['required', 'file', 'mimes:pdf', 'max:1024'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->validate($rules);

        $laporan = NormaHasilTim::findOrFail($id);

        if ($request->jenis == 1) $laporan_path_old = $laporan->normaHasilAccepted->laporan_path;
        else $laporan_path_old = $laporan->normaHasilDokumen->laporan_path;

        File::delete(public_path().'/'.$laporan_path_old);

        $file = $request->file('nama');
        $fileName = time() . '-laporan-norma-hasil.' . $file->getClientOriginalExtension();
        $path = public_path('storage/tim/norma-hasil');
        $file->move($path, $fileName);
        $laporan_path = 'storage/tim/norma-hasil/' . $fileName;

        if ($request->jenis == 1) {
            $laporan->normaHasilAccepted->update([
                'laporan_path' => $laporan_path,
                'status_verifikasi_arsiparis' => 'diperiksa',
                'catatan_arsiparis' => NULL
            ]);
        } else {
            $laporan->normaHasilDokumen->update([
                'laporan_path' => $laporan_path,
                'status_verifikasi_arsiparis' => 'diperiksa',
                'catatan_arsiparis' => NULL
            ]);
        }

        return redirect()->back()->with('success', 'Laporan Norma Hasil Berhasil Diedit');
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

    public function downloadUsulan($id)
    {
        $norma_hasil = NormaHasil::findOrFail($id);
        $file = public_path($norma_hasil->document_path);
        return response()->download($file);
    }

    public function viewLaporan($id, $jenis)
    {
        if ($jenis == 1) $norma_hasil = NormaHasilAccepted::findOrFail($id);
        else $norma_hasil = NormaHasilDokumen::findOrFail($id);
        $file = public_path($norma_hasil->laporan_path);
        if ($file == public_path('')) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        } else {
            return response()->file($file);
        }
    }
}
