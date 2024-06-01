<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TimKerja;
use App\Models\MasterIKU;
use App\Models\MasterHasil;
use App\Models\MasterTujuan;
use App\Models\RencanaKerja;
use App\Models\Proyek;
use Illuminate\Http\Request;
use App\Models\MasterSasaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KetuaTimRencanaKerjaController extends Controller
{
    protected $unitkerja = [
        '8000'    => 'Inspektorat Utama',
        '8010'    => 'Bagian Umum Inspektorat Utama',
        '8100'    => 'Inspektorat Wilayah I',
        '8200'    => 'Inspektorat Wilayah II',
        '8300'    => 'Inspektorat Wilayah III',
    ];

    protected $statusTim = [
        // Pegawai Buat Tim
        0   => 'Belum Disusun',
        // Ketua Tim Isi Rencana Kinerja
        1   => 'Proses Penyusunan',
        // Ketua Tim Kirim Rencana Kinerja ke Admin
        2   => 'Menunggu Reviu',
        // Ditolak Admin
        3   => 'Perlu Perbaikan',
        // Diperbaiki Ketua Tim
        4   => 'Disetujui',
        // Disetujui Admin Sudah di Lock
        5   => 'Disetujui',
    ];

    protected $colorText = [
        0   => 'dark',
        1   => 'info',
        2   => 'primary',
        3   => 'warning',
        4   => 'success',
        5   => 'success',
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
        'mhk013a' => 'Hasil Telaah (Pengaduan Masyarakat)',
        'mhk013b' => 'Hasil Telaah (Permintaan Aparat)',
        'mhk013c' => 'Hasil Telaah (Pengawasan Lainnya)',
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
        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }
        $id_pegawai = auth()->user()->id;
        $timKerja = TimKerja::with('ketua', 'iku')->where('id_ketua', $id_pegawai)->where('tahun', $year)->get();
        // select raw distinct year from created_at

        $year = TimKerja::select('tahun')->distinct()->orderBy('tahun', 'desc')->get();

        $currentYear = date('Y');

        $yearValues = $year->pluck('tahun')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['tahun' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('tahun');

        return view('pegawai.rencana-kinerja.ketua-tim.index', [
            'type_menu' => 'rencana-kinerja',
            'unitKerja' => $this->unitkerja,
            'timKerja'  => $timKerja,
            'statusTim'  => $this->statusTim,
            'colorText'  => $this->colorText,
            'year'      => $year,
            'unit_kerja'  => $this->unitkerja,
        ]);

        // return $id_pegawai;
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
        $rules = [
            'id_timkerja' => 'required',
            'hasilkerja' => 'required',
            'tugas' => 'required',
            'id_proyek' => 'required',
            'melaksanakan' => 'required',
            'capaian' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = request()->validate($rules);


        RencanaKerja::create([
            'id_timkerja'   => $validateData['id_timkerja'],
            'id_hasilkerja'  => $validateData['hasilkerja'],
            'kategori_pelaksanatugas'   => $request->kategori_pelaksana,
            'tugas'         => $validateData['tugas'],
            'id_proyek'     => $validateData['id_proyek'],
            'melaksanakan'  => $validateData['melaksanakan'],
            'capaian'       => $validateData['capaian'],
        ]);

        TimKerja::where('id_timkerja', $validateData['id_timkerja'])
        ->update(['status' => 1]);

        $request->session()->put('status', 'Berhasil menambahkan Tugas Tim Kerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah Tugas Tim Kerja',
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
        $timKerja = TimKerja::where('id_timkerja', $id)->get();

        $masterTujuan = MasterTujuan::all();
        $masterSasaran = MasterSasaran::all();
        $masterIku = MasterIKU::all();
        $masterHasil = MasterHasil::all();
        $rencanaKerja = RencanaKerja::where('id_timkerja',$timKerja[0]->id_timkerja)->get();
        $proyeks = Proyek::where('id_tim_kerja', $timKerja[0]->id_timkerja)->get();

        return view('pegawai.rencana-kinerja.ketua-tim.show', [
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
            'proyeks'       => $proyeks
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
        RencanaKerja::where('id_rencanakerja', $id)->delete();

        $request->session()->put('status', 'Berhasil menghapus Tugas Tim Kerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus Tugas Tim Kerja',
        ]);
    }

    public function sendToAnalis(Request $request, $id){
        TimKerja::where('id_timkerja', $id)
        ->update(['status' => 2]);

        $request->session()->put('status', 'Berhasil mengirim Rencana Kinerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengirim Rencana Kinerja',
        ]);
    }

    public function disableRencanaKerja(Request $request, $id){
        RencanaKerja::where('id_rencanakerja', $id)
            ->update(['status_realisasi' => 99]);

            $request->session()->put('status', 'Berhasil membatalkan tugas.');
            $request->session()->put('alert-type', 'success');

            return response()->json([
                'success' => true,
                'message' => 'Berhasil membatalkan tugas',
            ]);
    }
}
