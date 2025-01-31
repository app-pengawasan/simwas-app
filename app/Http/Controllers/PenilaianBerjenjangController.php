<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\RealisasiKinerja;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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

    protected $jabatan = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim', 'PJK'];

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

        $events = Event::all();
        foreach ($events as $event) {
            $event->id_pelaksana = PelaksanaTugas::where('id_pegawai', $event->id_pegawai)
                                    ->where('id_rencanakerja', $event->laporanOPengawasan->objekPengawasan->id_rencanakerja)
                                    ->get()->first()->id_pelaksana;
        }

        //tugas penilai
        $tugasSaya = PelaksanaTugas::where('id_pegawai', $id_pegawai)->select('id_rencanakerja', 'pt_jabatan');

        //tugas jenjang di bawahnya
        $tugasDinilai = PelaksanaTugas::joinSub($tugasSaya, 'penilai', function (JoinClause $join) {
                $join->on('pelaksana_tugas.id_rencanakerja', '=', 'penilai.id_rencanakerja');
            })
            ->whereNot('penilai.pt_jabatan', 4) //penilai bukan anggota
            ->whereRaw(
                    '(
                        CASE
                            when penilai.pt_jabatan = 1 then pelaksana_tugas.pt_jabatan = 2
                            when penilai.pt_jabatan = 5 then pelaksana_tugas.pt_jabatan = 3
                            else pelaksana_tugas.pt_jabatan = 4
                        end
                    )'
                )
            ->select('id_pelaksana');

        //realisasi untuk dinilai
        $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugasDinilai)->where('status', 1)->get();
        foreach ($realisasiDinilai as $realisasi) { 
            $realisasi->events = $events->where('id_pegawai', $realisasi->pelaksana->id_pegawai)
                                        ->where('laporan_opengawasan', $realisasi->id_laporan_objek);
        } 

        //realisasi berstatus selesai group by bulan dan tahun realisasi
        $realisasiDinilaiGroup = $realisasiDinilai->groupBy([function ($items){
                                    return date("Y",strtotime($items->created_at));
                                }, function ($items){
                                    return date("m",strtotime($items->created_at));
                                }]); 

        $realisasiCount = []; 

        foreach ($realisasiDinilaiGroup as $tahun => $bulanitems) {
            foreach ($bulanitems as $bulan => $items) {
                foreach ($items as $realisasi) { 
                    $id_pegawai = $realisasi->pelaksana->id_pegawai;
                    foreach ($realisasi['events'] as $event) {
                        $start = $event['start'];
                        $end = $event['end'];
                        $realisasi_jam = (strtotime($end) - strtotime($start)) / 60 / 60;
                        //jam realisasi pegawai per bulan
                        isset($realisasiCount[$id_pegawai][$tahun]['realisasi_jam'][$bulan]) ?
                            $realisasiCount[$id_pegawai][$tahun]['realisasi_jam'][$bulan] += $realisasi_jam :
                            $realisasiCount[$id_pegawai][$tahun]['realisasi_jam'][$bulan] = $realisasi_jam;
                        //jam realisasi pegawai per tahun
                        isset($realisasiCount[$id_pegawai][$tahun]['realisasi_jam']['all']) ?
                            $realisasiCount[$id_pegawai][$tahun]['realisasi_jam']['all'] += $realisasi_jam :
                            $realisasiCount[$id_pegawai][$tahun]['realisasi_jam']['all'] = $realisasi_jam;
                    }
                }
            }
        }  

        $bulans = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $tugasCount = $realisasiDinilai
                        ->groupBy(['pelaksana.id_pegawai', function ($items){
                            return date("Y",strtotime($items->created_at));
                        }])
                        ->map->map(function ($items) use ($bulans) {
                            $rencana_jam = 0;
                            foreach ($bulans as $bulan) {
                                $rencana_jam += $items->sum('pelaksana.'.$bulan);
                            }
                            return [
                                'nama' => $items[0]->pelaksana->user->name,
                                'unit_kerja' => $items[0]->pelaksana->user->unit_kerja,
                                'count' => $items->countBy(function ($realisasi) {
                                                            return date("m",strtotime($realisasi->created_at));
                                                        })->toArray(), //jumlah tugas per bulan
                                'count_all' => $items->count(),
                                'avg' => $items->groupBy(function ($item) { //rata rata nilai per bulan
                                                            return date("m",strtotime($item->created_at));
                                                        })->map->avg->map->nilai->toArray(),
                                'avg_all' => $items->avg->nilai,
                                // 'rencana_jam' => $items->groupBy(function ($item) {
                                //                                 return date("m",strtotime($item->updated_at));
                                //                             })->map(function ($item) use ($bulans) {
                                //                                     $rencana_jam = 0;
                                //                                     foreach ($bulans as $bulan) {
                                //                                         $rencana_jam += $item->sum('pelaksana.'.$bulan);
                                //                                 }
                                //                                 return $rencana_jam;
                                //                             })->toArray(), //rencana jam kerja per bulan
                                // 'rencana_jam_all' => $rencana_jam,
                            ];
                        })->toArray();

        if (!empty($tugasCount)) {
            $tugasCount = array_replace_recursive($tugasCount, $realisasiCount);
            foreach ($tugasCount as &$count) {
                foreach ($count as $tahun => $values) {
                    $count[$tahun]['count']['all'] = $count[$tahun]['count_all'];
                    $count[$tahun]['avg']['all'] = $count[$tahun]['avg_all'];
                    // $count[$tahun]['rencana_jam']['all'] = $count[$tahun]['rencana_jam_all'];
                }
            }
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
    public function show($pegawai_dinilai, $bulan, $tahun)
    {
        $id_pegawai = auth()->user()->id;

        //tugas penilai
        $tugasSaya = PelaksanaTugas::where('id_pegawai', $id_pegawai)->select('id_rencanakerja', 'pt_jabatan');

        //tugas yang akan dinilai
        $tugasDinilai = PelaksanaTugas::joinSub($tugasSaya, 'penilai', function (JoinClause $join) {
                $join->on('pelaksana_tugas.id_rencanakerja', '=', 'penilai.id_rencanakerja');
            })
            ->whereNot('penilai.pt_jabatan', 4) //penilai bukan anggota
            ->where('pelaksana_tugas.id_pegawai', $pegawai_dinilai)
            ->whereRaw(
                    '(
                        CASE
                            when penilai.pt_jabatan = 1 then pelaksana_tugas.pt_jabatan = 2
                            when penilai.pt_jabatan = 5 then pelaksana_tugas.pt_jabatan = 3
                            else pelaksana_tugas.pt_jabatan = 4
                        end
                    )'
                );

        //realisasi untuk dinilai
        if ($bulan == 'all') {
            $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugasDinilai->select('id_pelaksana'))
                               ->where('status', 1)->whereYear('created_at', $tahun)->get();
        } else {
            $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugasDinilai->select('id_pelaksana'))
                                ->where('status', 1)->whereYear('created_at', $tahun)
                                ->whereMonth('created_at', $bulan)->get();
        }
        $events = Event::where('id_pegawai', $pegawai_dinilai)
                    ->whereRelation('laporanOPengawasan.objekPengawasan', function (Builder $query) use ($tugasDinilai) {
                        $query->whereIn('id_rencanakerja', $tugasDinilai->select('pelaksana_tugas.id_rencanakerja'));
                    })->get(); 

        $jamRealisasi = $events->groupBy('laporan_opengawasan')
                            ->map(function ($items) {
                                    $realisasi_jam = 0;
                                    foreach ($items as $realisasi) {
                                        $start = $realisasi->start;
                                        $end = $realisasi->end;
                                        $realisasi_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                                    }
                                    return $realisasi_jam;
                            });

        foreach ($events as $event) {
            $realisasi = RealisasiKinerja::where('id_laporan_objek', $event->laporan_opengawasan)
                            ->whereRelation('pelaksana', function (Builder $query) use ($pegawai_dinilai) {
                                $query->where('id_pegawai', $pegawai_dinilai);
                            })->get();

            if ($realisasi->isEmpty()) $event->color = 'orange';
            else {
                if ($realisasi->contains('status', 1)) $event->color = 'green';
                elseif ($realisasi->contains('status', 2)) $event->color = 'red';
                else $event->color = 'black';
            }
            $event->title = $event->laporanOPengawasan->objekPengawasan->rencanaKerja->tugas;
            if ($bulan != 'all')  $event->initialDate = $realisasiDinilai->first()->created_at;
        }

        return view('pegawai.penilaian-berjenjang.show', [
            'type_menu' => 'realisasi-kinerja',
            'jabatan' => $this->jabatan,
            'id_pegawai'=> $pegawai_dinilai,
            'events'    => $events,
            'jamRealisasi' => $jamRealisasi,
            'bulan' => $bulan,
            'tahun' => $tahun
        ])
        ->with('realisasiDinilai',$realisasiDinilai);
    }

    public function detail($id)
    {
        $realisasi = RealisasiKinerja::findOrfail($id);
        $events = Event::where('laporan_opengawasan', $realisasi->id_laporan_objek)
                        ->where('id_pegawai', $realisasi->pelaksana->id_pegawai)->get();

        return view('components.realisasi-kinerja.show', [
            'type_menu'     => 'realisasi-kinerja',
            'jabatan'       => $this->jabatan,
            'status'        => $this->status,
            'colorText'     => $this->colorText,
            'hasilKerja'    => $this->hasilKerja,
            'kembali'       => 'nilai',
            'events'        => $events
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
        $message = [
            'decimal' => 'Nilai maksimal memiliki 2 angka desimal. Contoh: 98.67',
            'between' => 'Nilai harus antara 0-100'
        ];

        $validateData = request()->validate($rule, $message);
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

    public function export($pegawai, $bulan, $tahun) 
    {
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                  'Oktober', 'November', 'Desember'];
        $events = Event::whereMonth('start', $bulan)->whereYear('start', $tahun)
                    ->where('id_pegawai', $pegawai)->orderBy('start')->get();
        
        $mySpreadsheet = new Spreadsheet();
        $sheet = $mySpreadsheet->getSheet(0);
        $sheet1Data = [
            ["No.", "Hari", "Tanggal", "Waktu", "Tugas", 'Objek Pengawasan', 'Bulan Pelaporan', "Aktivitas"]
        ];

        foreach ($events as $key => $event) {
            $start = date_create($event->start);
            $end = date_create($event->end);

            array_push($sheet1Data, [
                                        $key + 1, 
                                        $hari[date_format($start, 'N') - 1],
                                        date_format($start, 'd-m-Y'), 
                                        date_format($start, 'H:i').' - '.date_format($end, 'H:i'),
                                        $event->laporanOPengawasan->objekPengawasan->rencanakerja->tugas,
                                        $event->laporanOPengawasan->objekPengawasan->nama,
                                        $months[$event->laporanOPengawasan->month - 1],
                                        preg_replace("/\r|\n/", "; ", $event->aktivitas)
                                    ]
            );
        }

        $sheet->fromArray($sheet1Data);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true); //resize kolom
        }

        $nama_pegawai = $events[0]->pelaksana->user->name ?? '';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Aktivitas Harian '
                .$nama_pegawai.' '.$bulan.'-'.$tahun.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($mySpreadsheet, 'Xlsx');
        $writer->save('php://output');
        die;
    }
}
