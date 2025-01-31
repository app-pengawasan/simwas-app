<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\NilaiInspektur;
use App\Models\PelaksanaTugas;
use App\Models\RealisasiKinerja;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class InspekturPenilaianKinerjaController extends Controller
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

    protected $jabatan = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim', 'PJ Kegiatan'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('inspektur');

        $events = Event::all();
        foreach ($events as $event) {
            $event->id_pelaksana = PelaksanaTugas::where('id_pegawai', $event->id_pegawai)
                                    ->where('id_rencanakerja', $event->laporanOPengawasan->objekPengawasan->id_rencanakerja)
                                    ->get()->first()->id_pelaksana;
        }
        
        //realisasi untuk dinilai
        if ((auth()->user()->is_aktif) && (auth()->user()->unit_kerja == '8000') ) {
            $realisasiDinilai = RealisasiKinerja::where('status', 1)->get();
        } else {
            $realisasiDinilai = RealisasiKinerja::whereRelation('pelaksana.user', function (Builder $query){
                                    $query->where('unit_kerja', auth()->user()->unit_kerja);
                                })->where('status', 1)->get();
        }

        foreach ($realisasiDinilai as $realisasi) { 
            $realisasi->events = $events->where('id_pegawai', $realisasi->pelaksana->id_pegawai)
                                        ->where('laporan_opengawasan', $realisasi->id_laporan_objek);
        } 

        //realisasi berstatus selesai group by bulan dan tahun realisasi
        $realisasiDinilaiGroup = $realisasiDinilai
                            ->groupBy([function ($items){
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
                                'count' => $items->countBy(function ($item) {
                                                        return date("m",strtotime($item->created_at));
                                                    })->toArray(), //jumlah tugas per bulan
                                'count_all' => $items->count(),
                                'avg' => $items->groupBy(function ($item) { //rata rata nilai per bulan
                                                    return date("m",strtotime($item->created_at));
                                                })->map->avg->map->nilai->toArray(),
                                'avg_all' => $items->avg->nilai,
                                // 'rencana_jam' => $items->groupBy(function ($item) {
                                //                             return date("m",strtotime($item->created_at));
                                //                         })->map(function ($item)  use ($bulans) {
                                //                             $rencana_jam = 0;
                                //                             foreach ($bulans as $bulan) {
                                //                                 $rencana_jam += $item->sum('pelaksana.'.$bulan);
                                //                             }
                                //                             return $rencana_jam;
                                //                         })->toArray(), //rencana jam kerja per bulan
                                // 'rencana_jam_all' => $rencana_jam,
                            ];
                        })->toArray();

        if (!empty($tugasCount)) {
            $tugasCount = array_replace_recursive($tugasCount, $realisasiCount);
            foreach ($tugasCount as $id_pegawai => &$count) {
                foreach ($count as $tahun => $values) {
                    foreach ($values['count'] as $bulan => $jumlah_tugas) {
                        $nilai_ins = NilaiInspektur::where('id_pegawai', $id_pegawai)
                                    ->where('bulan', $bulan)->where('tahun', $tahun)->first();
                        if ($nilai_ins) {
                            $count[$tahun]['nilai_ins'][$bulan] = optional($nilai_ins)->nilai;
                            $count[$tahun]['catatan'][$bulan] = $nilai_ins->catatan;
                        }
                    }
                    $count[$tahun]['count']['all'] = $count[$tahun]['count_all'];
                    $count[$tahun]['avg']['all'] = $count[$tahun]['avg_all'];
                    // $count[$tahun]['rencana_jam']['all'] = $count[$tahun]['rencana_jam_all'];
                    $count[$tahun]['nilai_ins']['all'] = NilaiInspektur::where('id_pegawai', $id_pegawai)
                                                        ->where('tahun', $tahun)->avg('nilai');
                }
            }
        }

        return view('inspektur.penilaian-kinerja.index', [
            'tugasCount' => $tugasCount
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
        $this->authorize('inspektur');

        $rule = ['nilai' => 'decimal:0,2|between:0,100'];
        $message = [
            'decimal' => 'Nilai maksimal memiliki 2 angka desimal. Contoh: 98.67',
            'between' => 'Nilai harus antara 0-100'
        ];

        $validateData = request()->validate($rule, $message);
        $validateData['id_pegawai'] = $request->id_pegawai;
        $validateData['bulan'] = $request->bulan;
        $validateData['tahun'] = $request->tahun;
        $validateData['catatan'] = $request->catatan;

        NilaiInspektur::create($validateData);

        $request->session()->put('status', 'Berhasil memberi nilai.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil menambahkan nilai'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pegawai_dinilai, $bulan, $tahun)
    {
        $this->authorize('inspektur');

        //tugas yang akan dinilai
        $tugas = PelaksanaTugas::where('id_pegawai', $pegawai_dinilai);

        //realisasi untuk dinilai
        if ($bulan == 'all') {
            $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugas->select('id_pelaksana'))
                                ->whereYear('created_at', $tahun)->where('status', 1)->get();
        } else {
            $realisasiDinilai = RealisasiKinerja::whereIn('id_pelaksana', $tugas->select('id_pelaksana'))
                                ->where('status', 1)->whereYear('created_at', $tahun)
                                ->whereMonth('created_at', $bulan)->get();
        }
        $events = Event::where('id_pegawai', $pegawai_dinilai)
                    ->whereRelation('laporanOPengawasan.objekPengawasan', function (Builder $query) use ($tugas) {
                        $query->whereIn('id_rencanakerja', $tugas->select('id_rencanakerja'));
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

        return view('inspektur.penilaian-kinerja.show', [
            'type_menu' => 'realisasi-kinerja',
            'jabatan'   => $this->jabatan,
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
        $this->authorize('inspektur');

        $realisasi = RealisasiKinerja::findOrfail($id);
        $events = Event::where('laporan_opengawasan', $realisasi->id_laporan_objek)
                        ->where('id_pegawai', $realisasi->pelaksana->id_pegawai)->get();

        return view('components.realisasi-kinerja.show', [
            'type_menu'     => 'realisasi-kinerja',
            'jabatan'       => $this->jabatan,
            'status'        => $this->status,
            'colorText'     => $this->colorText,
            'hasilKerja'    => $this->hasilKerja,
            'kembali'       => 'nilai-inspektur',
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
        $this->authorize('inspektur');

        $rule = ['nilai' => 'decimal:0,2|between:0,100'];
        $message = [
            'decimal' => 'Nilai maksimal memiliki 2 angka desimal. Contoh: 98.67',
            'between' => 'Nilai harus antara 0-100'
        ];

        $validateData = request()->validate($rule, $message);
        $validateData['catatan'] = $request->catatan;

        NilaiInspektur::where('id', $id)->update($validateData);

        $request->session()->put('status', 'Berhasil memberi nilai.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui'
        ]);
    }

    public function getNilai($id_pegawai, $bulan, $tahun){
        $this->authorize('inspektur');

        $nilai = NilaiInspektur::where('id_pegawai', $id_pegawai)
                ->where('bulan', $bulan)->where('tahun', $tahun)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Get Nilai',
            'data'      => $nilai
        ]);
    }

    public function export($pegawai, $bulan, $tahun) 
    {
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                  'Oktober', 'November', 'Desember'];
        $events = Event::whereMonth('start', $bulan)->whereYear('start', $tahun)
                    ->where('id_pegawai', $pegawai)
                    ->orderBy('start')->get();
        
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
