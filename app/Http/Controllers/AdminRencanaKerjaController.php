<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TimKerja;
use App\Models\MasterIKU;
use App\Models\MasterHasil;
use App\Models\MasterTujuan;
use App\Models\RencanaKerja;
use Illuminate\Http\Request;
use App\Models\MasterSasaran;

class AdminRencanaKerjaController extends Controller
{
    protected $unitkerja = [
        '8000'    => 'Inspektorat Utama',
        '8010'    => 'Bagian Umum Inspektorat Utama',
        '8100'    => 'Inspektorat Wilayah I',
        '8200'    => 'Inspektorat Wilayah II',
        '8300'    => 'Inspektorat Wilayah III',
    ];

    protected $statusTim = [
        0   => 'Belum Disusun',
        1   => 'Proses Penyusunan',
        2   => 'Perlu Reviu',
        3   => 'Perlu Perbaikan',
        4   => 'Dalam Perbaikan',
        5   => 'Diajukan',
        6   => 'Disetujui',
    ];

    protected $colorText = [
        0   => 'dark',
        1   => 'warning',
        2   => 'primary',
        3   => 'warning',
        4   => 'warning',
        5   => 'primary',
        6   => 'success',
    ];

    protected $unsur = [
        'msu001'    => 'Perencanaan, pengorganisasian, dan pengendalian Pengawasan Intern',
        'msu002'    => 'Pelaksanaan teknis pengawasan internal',
        'msu003'    => 'Evaluasi Pengawasan Intern'
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

    protected $pelaksanaTugas = [
        'ngt'   => 'Bukan Gugus Tugas',
        'gt'    => 'Gugus Tugas'
    ];

    protected $satuan = [
        's001'      => 'O-J',
        's002'      => 'O-P',
        's003'      => 'O-H',
        's004'      => 'PAKET'
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

        $masterTujuan = MasterTujuan::all();
        $masterSasaran = MasterSasaran::all();
        $masterIku = MasterIKU::all();
        $pegawai = User::all();
        //

        $timKerja = TimKerja::with('ketua', 'iku')->where('tahun', $year)->get();
        $year = TimKerja::select('tahun')->distinct()->orderBy('tahun', 'desc')->get();

        $currentYear = date('Y');

        $yearValues = $year->pluck('tahun')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['tahun' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('tahun');

        // get tahun in timkerja distinct
        return view('admin.rencana-kinerja.index', [
            'type_menu' => 'rencana-kinerja',
            'unitKerja' => $this->unitkerja,
            'masterTujuan' => $masterTujuan,
            'masterSasaran' => $masterSasaran,
            'masterIku' => $masterIku,
            'pegawai'   => $pegawai,
            'timKerja'  => $timKerja,
            'statusTim'  => $this->statusTim,
            'colorText'  => $this->colorText,
            'unit_kerja' => $this->unitkerja,
            'year'     => $year,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $timKerja = TimKerja::where('id_timkerja', $id)->get();
        $proyek = $timKerja[0]->proyek;
        // dd($proyek
        // $rencanaKerja2 = $timKerja[0]->proyek[0]->rencanaKerja;
        // dd($rencanaKerja2);

        $masterTujuan = MasterTujuan::all();
        $masterSasaran = MasterSasaran::all();
        $masterIku = MasterIKU::all();
        $masterHasil = MasterHasil::all();

        $rencanaKerja = RencanaKerja::where('id_timkerja',$timKerja[0]->id_timkerja)->get();

        return view('admin.rencana-kinerja.show', [
            'type_menu'     => 'rencana-kinerja',
            'unitKerja'     => $this->unitkerja,
            'masterTujuan'  => $masterTujuan,
            'masterSasaran' => $masterSasaran,
            'masterIku'     => $masterIku,
            'masterHasil'   => $masterHasil,
            'hasilKerja'    => $this->hasilKerja,
            'unsur'         => $this->unsur,
            'satuan'        => $this->satuan,
            'pelaksanaTugas'=> $this->pelaksanaTugas,
            'timKerja'      => $timKerja[0],
            'statusTim'     => $this->statusTim,
            'colorText'     => $this->colorText,
            'rencanaKerja'  => $rencanaKerja,
            'proyeks'        => $proyek
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

    }

    public function sendToInspektur(Request $request, $id){
        TimKerja::where('id_timkerja', $id)
        ->update(['status' => 5]);

        $request->session()->put('status', 'Berhasil mengirim rencana kinerja ke Pimpinan.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengirim rencana kinerja ke Pimpinan',
        ]);
    }

    public function sendBackToKetuaTim(Request $request, $id){
        TimKerja::where('id_timkerja', $id)
        ->update(['status' => 3]);

        $request->session()->put('status', 'Berhasil mengembalikan rencana kinerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengembalikan rencana kinerja',
        ]);
    }
}
