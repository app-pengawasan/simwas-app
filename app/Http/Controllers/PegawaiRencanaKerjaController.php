<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TimKerja;
use App\Models\MasterIKU;
use App\Models\MasterTujuan;
use Illuminate\Http\Request;
use App\Models\MasterSasaran;
use App\Http\Controllers\Controller;
use App\Models\MasterHasil;
use App\Models\PelaksanaTugas;
use App\Models\RencanaKerja;
use Illuminate\Database\Eloquent\Builder;

class PegawaiRencanaKerjaController extends Controller
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
        2   => 'Menunggu Reviu',
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

    protected $statusTugas = [
        0   => 'Belum dikerjakan',
        1   => 'Sedang dikerjakan',
        2   => 'Selesai',
        99  => 'Dibatalkan'
    ];

    protected $statusColor = [
        0   => 'dark',
        1   => 'primary',
        2   => 'success',
        99  => 'danger'
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

    protected $jabatan = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim'];
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterTujuan = MasterTujuan::all();
        $masterSasaran = MasterSasaran::all();
        $masterIku = MasterIKU::all();
        $pegawai = User::all();
        $bulans = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];

        $id_pegawai = auth()->user()->id;
        $timKerja = TimKerja::where('id_ketua', $id_pegawai)->get();

        $tugasSaya = PelaksanaTugas::where('id_pegawai', $id_pegawai)
            ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query){
                $query->where('status', 6);
            })->selectRaw('*, '.implode('+', $bulans).' as total')->get();

        // return [$tugasSaya, $id_pegawai];
        return view('pegawai.rencana-kinerja.saya.index', [
            'type_menu' => 'rencana-kinerja',
            'unitKerja' => $this->unitkerja,
            'masterTujuan' => $masterTujuan,
            'masterSasaran' => $masterSasaran,
            'masterIku' => $masterIku,
            'hasilKerja'    => $this->hasilKerja,
            'pegawai'   => $pegawai,
            'timKerja'  => $timKerja,
            'tugasSaya' => $tugasSaya,
            'statusTim'  => $this->statusTim,
            'colorText'  => $this->colorText,
            'statusTugas'   => $this->statusTugas,
            'statusColor'   => $this->statusColor,
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
            'id_hasilkerja' => 'required',
            'tugas' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
        ];

        $validateData = request()->validate($rules);
        $hasil = MasterHasil::where('id_master_hasil', $request->id_hasilkerja)->get();

        $validateData['kategori_pelaksanatugas'] = $hasil[0]->kategori_pelaksana;


        RencanaKerja::create($validateData);
        TimKerja::where('id_timkerja', $request->id_timkerja)
        ->update(['status' => 1]);

        return redirect('/pegawai/rencana-kinerja/'.$request->id_timkerja)->with('success', 'Berhasil menambah Tugas.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $timKerja = TimKerja::where('id_timkerja', $id)->get();

        // $masterTujuan = MasterTujuan::all();
        // $masterSasaran = MasterSasaran::all();
        // $masterIku = MasterIKU::all();
        // $masterHasil = MasterHasil::all();

        $rencanaKerja = RencanaKerja::where('id_rencanakerja', $id)->first();


        return view('pegawai.rencana-kinerja.saya.show', [
            'type_menu'     => 'rencana-kinerja',
            'unitKerja'     => $this->unitkerja,
            // 'masterTujuan'  => $masterTujuan,
            // 'masterSasaran' => $masterSasaran,
            // 'masterIku'     => $masterIku,
            // 'masterHasil'   => $masterHasil,
            'hasilKerja'    => $this->hasilKerja,
            'unsur'         => $this->unsur,
            'satuan'        => $this->satuan,
            'pelaksanaTugas'=> $this->pelaksanaTugas,
            'statusTugas'   => $this->statusTugas,
            // 'timKerja'      => $timKerja,
            'statusTim'     => $this->statusTim,
            'colorText'     => $this->colorText,
            'rencanaKerja'  => $rencanaKerja
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
    public function destroy($id)
    {
        RencanaKerja::where('id_rencanakerja', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!',
        ]);
    }

    public function sendToAnalis($id){
        TimKerja::where('id_timkerja', $id)
        ->update(['status' => 2]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Mengirim Rencana Kerja!',
        ]);
    }

    public function rencanaJamKerja() {
        $tugas = PelaksanaTugas::where('id_pegawai', auth()->user()->id)
                ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query){
                    $query->where('status', 6);
                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as total')
                  ->get();

        return view('pegawai.rencana-kinerja.jam-kerja.index',[
            'type_menu'     => 'rencana-kinerja',
            'jabatan'       => $this->jabatan,
        ])->with('tugas', $tugas);
    }
}
