<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\RealisasiKinerja;
use Illuminate\Database\Eloquent\Builder;

class PJKRealisasiJamKerjaController extends Controller
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
        $this->authorize('pjk');

        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $unit = $request->unit;

        if ($unit == '8000' || $unit == null) {
            $pegawai = User::get();
            $realisasiDone = RealisasiKinerja::where('status', 1)
                            ->whereYear('updated_at', $year)->select('id_laporan_objek');
        } else {
            $pegawai = User::where('unit_kerja', $unit)->get();
            $realisasiDone = RealisasiKinerja::whereRelation('pelaksana.user', function (Builder $query) use ($unit) {
                                $query->where('unit_kerja', $unit);
                            })->where('status', 1)->whereYear('updated_at', $year)
                            ->select('id_laporan_objek');
        } 
        
        $realisasi = Event::whereIn('laporan_opengawasan', $realisasiDone)
                     ->get()->groupBy('id_pegawai'); 

        $jam_kerja = $realisasi->map(function ($items) {
                                    $total_jam = 0;
                                    foreach ($items as $realisasi) {
                                        $start = $realisasi->start;
                                        $end = $realisasi->end;
                                        $total_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                                    }
                                    return [
                                        'id' => $items[0]->id_pegawai,
                                        'realisasi_jam' => $items->groupBy(function ($item) {
                                                                        return date("m",strtotime($item->updated_at));
                                                                    })->map(function ($item) {
                                                                        $realisasi_jam = 0;
                                                                        foreach ($item as $realisasi) {
                                                                            $start = $realisasi->start;
                                                                            $end = $realisasi->end;
                                                                            $realisasi_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                                                                        }
                                                                        return $realisasi_jam;
                                                                    }), //realisasi jam kerja per bulan
                                        'total' => $total_jam //realisasi jam kerja total
                                    ];
                                }); 
        
        $jam_kerja = $pegawai->toBase()->merge($jam_kerja)->groupBy('id'); 

        return view('pjk.realisasi-jam-kerja.rekap',[
            'type_menu'     => 'realisasi-jam-kerja'
        ])->with('jam_kerja', $jam_kerja);
    }

    public function pool(Request $request)
    {
        $this->authorize('pjk');

        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $unit = $request->unit;

        if ($unit == null || $unit == '8000') {
            $pegawai = User::get();
            $realisasiDone = RealisasiKinerja::where('status', 1)
                            ->whereYear('updated_at', $year)->select('id_laporan_objek');
        } else {
            $pegawai = User::where('unit_kerja', $unit)->get();
            $realisasiDone = RealisasiKinerja::whereRelation('pelaksana.user', function (Builder $query) use ($unit) {
                                $query->where('unit_kerja', $unit);
                            })->where('status', 1)->whereYear('updated_at', $year)
                            ->select('id_laporan_objek');
        } 
        
        $realisasi = RealisasiKinerja::whereIn('id_laporan_objek', $realisasiDone)
                                        ->get()->groupBy('pelaksana.id_pegawai');
        
        $count = $realisasi
                ->map(function ($items) {
                        $total_jam = 0;
                        foreach ($items as $realisasi) { 
                            $events = Event::where('laporan_opengawasan', $realisasi->id_laporan_objek)
                                        ->where('id_pegawai', $realisasi->pelaksana->id_pegawai)->get();
                            foreach ($events as $event) {
                                $start = $event->start;
                                $end = $event->end;
                                $total_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                            }
                        } 
                        return [
                            'id' => $items[0]->pelaksana->id_pegawai,
                            'jumlah_tim' => $items->unique('pelaksana.rencanaKerja.proyek.timkerja')->count(),
                            'jumlah_proyek' => $items->unique('pelaksana.rencanaKerja.proyek')->count(),
                            'jumlah_tugas' => $items->unique('pelaksana')->count(),
                            'jam_kerja'   => $total_jam,
                            'hari_kerja'  => round($total_jam / 7.5, 2)
                        ];
                  });

        $countall = $pegawai->toBase()->merge($count)->groupBy('id');
        
        return view('pjk.realisasi-jam-kerja.pool',[
            'type_menu'     => 'realisasi-jam-kerja'
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
        $this->authorize('pjk');

        $realisasiDone = RealisasiKinerja::whereRelation('pelaksana', function (Builder $query) use ($id) {
                            $query->where('id_pegawai', $id);
                        })->where('status', 1)->whereYear('updated_at', $year)->select('id_laporan_objek');

        $realisasi = Event::whereIn('laporan_opengawasan', $realisasiDone)->where('id_pegawai', $id)
                        ->get()->groupBy('laporanOPengawasan.objekPengawasan.rencanaKerja'); 

        $count = $realisasi
                ->map(function ($items) {
                        $total_jam = 0;
                        foreach ($items as $realisasi) {
                            $start = $realisasi->start;
                            $end = $realisasi->end;
                            $total_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                        }
                        $pelaksana = PelaksanaTugas::where('id_rencanakerja', $items[0]->laporanOPengawasan->objekPengawasan->id_rencanakerja)
                                        ->where('id_pegawai', $items[0]->id_pegawai)->first();
                        return [
                            'pegawai' => $pelaksana->user->name,
                            'tim' => $pelaksana->rencanaKerja->proyek->timkerja->nama,
                            'proyek' => $pelaksana->rencanaKerja->proyek->nama_proyek,
                            'tugas' => $pelaksana->rencanaKerja->tugas,
                            'id_pelaksana' => $pelaksana->id_pelaksana,
                            'jabatan' => $pelaksana->pt_jabatan,
                            'realisasi_jam' => $items->groupBy(function ($item) {
                                                            return date("m",strtotime($item->updated_at));
                                                        })->map(function ($item) {
                                                            $realisasi_jam = 0;
                                                            foreach ($item as $realisasi) {
                                                                $start = $realisasi->start;
                                                                $end = $realisasi->end;
                                                                $realisasi_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                                                            }
                                                            return $realisasi_jam;
                                                        }), //realisasi jam kerja per bulan
                            'total' => $total_jam //realisasi jam kerja total
                        ];
                    }); 
        
        $pegawai = User::findOrFail($id)->name; 

        return view('pjk.realisasi-jam-kerja.show',[
            'type_menu'     => 'realisasi-jam-kerja',
            'jabatan'       => $this->jabatan,
            'pegawai'       => $pegawai
        ])->with('count', $count);
    }
    
    public function detailTugas($id)
    {
        $this->authorize('pjk');
        
        $tugas = PelaksanaTugas::where('id_pelaksana', $id)->first();

        return view('pjk.realisasi-jam-kerja.detail-tugas', [
            'type_menu'     => 'realisasi-jam-kerja',
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
