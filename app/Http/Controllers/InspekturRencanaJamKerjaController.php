<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use Illuminate\Database\Eloquent\Builder;

class InspekturRencanaJamKerjaController extends Controller
{
    protected $jabatan = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim', 'PJK'];

    protected $unitkerja = [
        '8000'    => 'Inspektorat Utama',
        '8010'    => 'Bagian Umum Inspektorat Utama',
        '8100'    => 'Inspektorat Wilayah I',
        '8200'    => 'Inspektorat Wilayah II',
        '8300'    => 'Inspektorat Wilayah III',
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function rekap(Request $request)
    {
        $this->authorize('inspektur');
        $bulans = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];

        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        if ((auth()->user()->is_aktif) && (auth()->user()->unit_kerja == '8000') ) {
            $pegawai = User::get();
            $tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                            $query->whereIn('status', [1,2])->where('tahun', $year);
                        })->groupBy('id_pegawai')->select('id_pegawai as id')
                        ->selectRaw('sum('.implode('+', $bulans).') as total');
        } else {
            $pegawai = User::where('unit_kerja', auth()->user()->unit_kerja)->get();
            $tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                            $query->whereIn('status', [1,2])->where('tahun', $year);
                        })->whereRelation('user', function (Builder $query){
                            $query->where('unit_kerja', auth()->user()->unit_kerja);
                        })->groupBy('id_pegawai')->select('id_pegawai as id')
                        ->selectRaw('sum('.implode('+', $bulans).') as total');
        }

        foreach ($bulans as $bulan) {
            $tugas = $tugas->selectRaw("SUM(".$bulan.") as ".$bulan);
        }
        $tugas = $tugas->get();

        $jam_kerja = $pegawai->toBase()->merge($tugas)->groupBy('id');

        return view('inspektur.rencana-jam-kerja.rekap',[
            'type_menu'     => 'rencana-jam-kerja'
        ])->with('jam_kerja', $jam_kerja);
    }

    public function pool(Request $request)
    {
        $this->authorize('inspektur');

        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        if ((auth()->user()->is_aktif) && (auth()->user()->unit_kerja == '8000') ) {
            $pegawai = User::get();
            $tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                            $query->whereIn('status', [1,2])->where('tahun', $year);
                        })->get();
        } else {
            $pegawai = User::where('unit_kerja', auth()->user()->unit_kerja)->get();
            $tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                            $query->whereIn('status', [1,2])->where('tahun', $year);
                        })
                        ->whereRelation('user', function (Builder $query){
                            $query->where('unit_kerja', auth()->user()->unit_kerja);
                        })->get();
        }

        $count = $tugas
                ->groupBy('id_pegawai')
                ->map(function ($items) {
                        $bulans = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
                        $jam_kerja = 0;
                        foreach ($bulans as $bulan) {
                            $jam_kerja += $items->sum($bulan);
                        }
                        return [
                            'id' => $items[0]->id_pegawai,
                            'jumlah_tim' => $items->unique('rencanaKerja.proyek.timkerja')->count(),
                            'jumlah_proyek' => $items->unique('rencanaKerja.proyek')->count(),
                            'jumlah_tugas' => $items->count(),
                            'jam_kerja'   => $jam_kerja,
                            'hari_kerja'  => round($jam_kerja / 7.5, 2)
                        ];
                  });

        $countall = $pegawai->toBase()->merge($count)->groupBy('id');

        return view('inspektur.rencana-jam-kerja.pool',[
            'type_menu'     => 'rencana-jam-kerja'
        ])->with('countall', $countall);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $year)
    {
        $this->authorize('inspektur');

        $tugas = PelaksanaTugas::where('id_pegawai', $id)
                ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                    $query->whereIn('status', [1,2])->where('tahun', $year);
                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as total')
                  ->get();

        $pegawai = User::findOrFail($id)->name;

        return view('inspektur.rencana-jam-kerja.show',[
            'type_menu'     => 'rencana-jam-kerja',
            'jabatan'       => $this->jabatan,
            'pegawai'       => $pegawai
        ])->with('tugas', $tugas);
    }

    public function detailTugas($id)
    {
        $this->authorize('inspektur');

        $tugas = PelaksanaTugas::where('id_pelaksana', $id)->first();

        return view('inspektur.rencana-jam-kerja.detail-tugas', [
            'type_menu'     => 'rencana-jam-kerja',
            'unitKerja'     => $this->unitkerja,
            'hasilKerja'    => $this->hasilKerja,
            'unsur'         => $this->unsur,
            'satuan'        => $this->satuan,
            'pelaksanaTugas'=> $this->pelaksanaTugas,
            'statusTugas'   => $this->statusTugas,
            'statusTim'     => $this->statusTim,
            'colorText'     => $this->colorText,
            'tugas'         => $tugas,
            'rencanaKerja'  => $tugas->rencanaKerja
        ]);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $start = $request->tgl.' '.$request->start;
    //     $end = $request->tgl.' '.$request->end;
    //     $duplicateStart = Event::where('start', '<=', $start)->where('end', '>', $start)->count();
    //     $duplicateEnd = Event::where('start', '<=', $end)->where('end', '>', $end)->count();

    //     $rules = [
    //         'id_pelaksana'   => 'required',
    //         'start'             => [
    //                                     'required',
    //                                     'date_format:H:i',
    //                                     'before:end',
    //                                     Rule::when($duplicateStart != 0 , ['boolean'])
    //                                ],
    //         'end'               => [
    //                                     'required',
    //                                     'date_format:H:i',
    //                                     'after:start',
    //                                     Rule::when($duplicateStart != 0 && $duplicateEnd != 0, ['boolean'])
    //                                 ],
    //         'aktivitas'         => 'required',
    //     ];

    //     $customMessages = [
    //         'boolean' => 'Sudah ada aktivitas pada jam ini',
    //         'required' => ':attribute harus diisi',
    //         'date_format' => 'Format jam harus JJ:MM',
    //         'before' => 'Jam mulai harus sebelum jam selesai',
    //         'after' => 'Jam selesai harus setelah jam mulai',
    //     ];

    //     $validator = Validator::make($request->all(), $rules, $customMessages)
    //                 ->setAttributeNames(
    //                     [
    //                         'id_pelaksana' => 'Tugas',
    //                         'aktivitas' => 'Aktivitas',
    //                     ], // Your field name and alias
    //                 );

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $validateData = $request->validate($rules);
    //     $validateData['start'] = $start;
    //     $validateData['end'] = $end;

    //     Event::create($validateData);
    //     $request->session()->put('status', 'Berhasil menambahkan aktivitas.');
    //     $request->session()->put('alert-type', 'success');

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Berhasil menambah aktivitas.',
    //     ]);
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $event = Event::where('id', $id)->get();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Detail Data Event',
    //         'data'    => $event
    //     ]);
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

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $rules = [
    //         'start'             => 'required|date_format:H:i|before:end',
    //         'end'               => 'required|date_format:H:i|after:start',
    //         'aktivitas'         => 'required',
    //         'tgl'               => 'required|date_format:Y-m-d',
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $validateData = $request->validate($rules);
    //     $validateData['start'] = $request->tgl.' '.$request->start;
    //     $validateData['end'] = $request->tgl.' '.$request->end;

    //     $eventEdit = Event::where('id', $id)->update(Arr::except($validateData, ['tgl']));

    //     $request->session()->put('status', 'Berhasil memperbarui data aktivitas.');
    //     $request->session()->put('alert-type', 'success');

    //     return response()->json([
    //         'success'   => true,
    //         'message'   => 'Data Berhasil Diperbarui',
    //         'data'      => $eventEdit
    //     ]);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Request $request, $id)
    // {
    //     Event::destroy($id);
    //     $request->session()->put('status', 'Berhasil menghapus data aktivitas.');
    //     $request->session()->put('alert-type', 'success');

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Berhasil menghapus data aktivitas',
    //     ]);
    // }
}
