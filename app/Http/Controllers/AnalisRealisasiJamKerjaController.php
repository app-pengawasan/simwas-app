<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\RealisasiKinerja;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class AnalisRealisasiJamKerjaController extends Controller
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
        $this->authorize('analis_sdm');

        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $unit = auth()->user()->unit_kerja;
        if ($unit == '8000' || $unit == '8010') $unit = $request->unit;
        else if ($request->unit != null && $request->unit != $unit) return redirect()->to('/');

        if ($unit == '8000' || $unit == null) {
            $pegawai = User::where('status', 1)->get();
            $realisasiDone = RealisasiKinerja::where('status', 1)
                            ->whereYear('updated_at', $year)->select('id_laporan_objek');
        } else {
            $pegawai = User::where('status', 1)->where('unit_kerja', $unit)->get();
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

        $unituser = auth()->user()->unit_kerja;

        return view('analis-sdm.realisasi-jam-kerja.rekap',[
            'type_menu'     => 'realisasi-jam-kerja',
            'unituser'      => $unituser
        ])->with('jam_kerja', $jam_kerja);
    }

    public function pool(Request $request)
    {
        $this->authorize('admin');

        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $unit = auth()->user()->unit_kerja;
        if ($unit == '8000' || $unit == '8010') $unit = $request->unit;
        else if ($request->unit != null && $request->unit != $unit) return redirect()->to('/');

        if ($unit == null || $unit == '8000') {
            $pegawai = User::where('status', 1)->get();
            $realisasiDone = RealisasiKinerja::where('status', 1)
                            ->whereYear('updated_at', $year)->select('id_laporan_objek');
        } else {
            $pegawai = User::where('status', 1)->where('unit_kerja', $unit)->get();
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

        $unituser = auth()->user()->unit_kerja;
        
        return view('analis-sdm.realisasi-jam-kerja.pool',[
            'type_menu'     => 'realisasi-jam-kerja',
            'unituser'      => $unituser
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
        $this->authorize('analis_sdm');

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

        return view('analis-sdm.realisasi-jam-kerja.show',[
            'type_menu'     => 'realisasi-jam-kerja',
            'jabatan'       => $this->jabatan,
            'pegawai'       => $pegawai
        ])->with('count', $count);
    }
    
    public function detailTugas($id)
    {
        $this->authorize('analis_sdm');
        
        $tugas = PelaksanaTugas::where('id_pelaksana', $id)->first();
        $pegawai = User ::all();

        return view('analis-sdm.realisasi-jam-kerja.detail-tugas', [
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
            'rencanaKerja'  => $tugas->rencanaKerja,
            'pegawai'       => $pegawai
        ]);
    }

    public function export($mode, $year, $unit)
    {
        $this->authorize('analis_sdm');

        if ($unit == '8000' || $unit == null) {
            $pegawai = User::where('status', 1)->get();
            $realisasiDone = RealisasiKinerja::where('status', 1)
                            ->whereYear('updated_at', $year)->select('id_laporan_objek');
        } else {
            $pegawai = User::where('status', 1)->where('unit_kerja', $unit)->get();
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
        
        $jam_kerja = $pegawai->toBase()->merge($jam_kerja)->groupBy('id')->toArray(); 

        $mySpreadsheet = new Spreadsheet();
        $sheet = $mySpreadsheet->getSheet(0);
        $sheet->setTitle('REKAP');
        $data = [
            ['No.', 'Pegawai', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu',
             'Sep', 'Okt', 'Nov', 'Des', 'Total']
        ];

        foreach ($jam_kerja as &$jam) {
            if (isset($jam[1])) {
                $jam[1]['realisasi_jam'] = $jam[1]['realisasi_jam']->toArray();
                for ($i = 1; $i <= 12; $i++) {
                    if (!isset($jam[1]['realisasi_jam'][$i])) $jam[1]['realisasi_jam'][$i] = 0;
                }
            }
        } 

        $i = 1;
        foreach ($jam_kerja as &$jam) {
            if (isset($jam[1])) {
                if ($mode == 'jam') 
                    array_push($data, [$i, $jam[0]['name'], $jam[1]['realisasi_jam'][1], 
                                        $jam[1]['realisasi_jam'][2], $jam[1]['realisasi_jam'][3],
                                        $jam[1]['realisasi_jam'][4], $jam[1]['realisasi_jam'][5], 
                                        $jam[1]['realisasi_jam'][6], $jam[1]['realisasi_jam'][7],
                                        $jam[1]['realisasi_jam'][8], $jam[1]['realisasi_jam'][9],
                                        $jam[1]['realisasi_jam'][10], $jam[1]['realisasi_jam'][11],
                                        $jam[1]['realisasi_jam'][12], $jam[1]['total']]);
                else
                    array_push($data, [$i, $jam[0]['name'], round($jam[1]['realisasi_jam'][1] / 7.5, 2), 
                                        round($jam[1]['realisasi_jam'][2] / 7.5, 2), round($jam[1]['realisasi_jam'][3] / 7.5, 2),
                                        round($jam[1]['realisasi_jam'][4] / 7.5, 2), round($jam[1]['realisasi_jam'][5] / 7.5, 2), 
                                        round($jam[1]['realisasi_jam'][6] / 7.5, 2), round($jam[1]['realisasi_jam'][7] / 7.5, 2),
                                        round($jam[1]['realisasi_jam'][8] / 7.5, 2), round($jam[1]['realisasi_jam'][9] / 7.5, 2), 
                                        round($jam[1]['realisasi_jam'][10] / 7.5, 2), round($jam[1]['realisasi_jam'][11] / 7.5, 2),
                                        round($jam[1]['realisasi_jam'][12] / 7.5, 2), round($jam[1]['total'] / 7.5, 2)]);
            }
            else 
                array_push($data, [$i, $jam[0]['name'], '0', '0', '0', '0', '0', '0', '0',
                                    '0', '0', '0', '0', '0', '0']);
            $i++;
        } 

        $sheet->fromArray($data, null, 'A1', true);
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true); //resize kolom
        }

        $mySpreadsheet->createSheet();
        $sheet2 = $mySpreadsheet->getSheet(1);
        $sheet2->setTitle('DETAIL');

        $data2 = [
            ['No.', 'Pegawai', 'Tim', 'Proyek', 'Tugas', 'Jan', 'Feb', 'Mar', 
            'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des', 'Total']
        ];

        $i = 1;
        $count_data = [];
        foreach ($pegawai as $user) {
            $realisasiDone = RealisasiKinerja::whereRelation('pelaksana', function (Builder $query) use ($user) {
                $query->where('id_pegawai', $user->id);
            })->where('status', 1)->whereYear('updated_at', $year)->select('id_laporan_objek');
    
            $realisasi = Event::whereIn('laporan_opengawasan', $realisasiDone)->where('id_pegawai', $user->id)
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
                        })->toArray(); 
            $count_data[$user->id] = array_values($count);
        } 

        foreach ($pegawai as $user) {
            if (!$count_data[$user->id]) {
                array_push($data2, [$i, $user->name, '', '', '', '', '', '', '', '', 
                                    '', '', '', '', '', '', '', '']);
                $i++;
            } else {
                foreach ($count_data[$user->id] as &$data_jam) {
                    for ($j = 1; $j <= 12; $j++) {
                        if (!isset($data_jam['realisasi_jam'][$j])) $data_jam['realisasi_jam'][$j] = 0;
                    } 
                    if ($mode == 'jam') {
                        array_push($data2, [$i, $user->name, $data_jam['tim'], $data_jam['proyek'],
                                            $data_jam['tugas'], $data_jam['realisasi_jam'][1],
                                            $data_jam['realisasi_jam'][2], $data_jam['realisasi_jam'][3],
                                            $data_jam['realisasi_jam'][4], $data_jam['realisasi_jam'][5],
                                            $data_jam['realisasi_jam'][6], $data_jam['realisasi_jam'][7],
                                            $data_jam['realisasi_jam'][8], $data_jam['realisasi_jam'][9],
                                            $data_jam['realisasi_jam'][10], $data_jam['realisasi_jam'][11],
                                            $data_jam['realisasi_jam'][12], $data_jam['total']]);
                    }
                    else 
                        array_push($data2, [$i, $user->name, $data_jam['tim'], $data_jam['proyek'],
                            $data_jam['tugas'], round($data_jam['realisasi_jam'][1] / 7.5, 2),
                            round($data_jam['realisasi_jam'][2] / 7.5, 2), round($data_jam['realisasi_jam'][3] / 7.5, 2),
                            round($data_jam['realisasi_jam'][4] / 7.5, 2), round($data_jam['realisasi_jam'][5] / 7.5, 2),
                            round($data_jam['realisasi_jam'][6] / 7.5, 2), round($data_jam['realisasi_jam'][7] / 7.5, 2),
                            round($data_jam['realisasi_jam'][8] / 7.5, 2), round($data_jam['realisasi_jam'][9] / 7.5, 2),
                            round($data_jam['realisasi_jam'][10] / 7.5, 2), round($data_jam['realisasi_jam'][11] / 7.5, 2),
                            round($data_jam['realisasi_jam'][12] / 7.5, 2), round($data_jam['total'] / 7.5, 2)]);
                    $i++;
                }
            }
        }

        $sheet2->fromArray($data2);
        foreach ($sheet2->getColumnIterator() as $column) {
            $sheet2->getColumnDimension($column->getColumnIndex())->setAutoSize(true); //resize kolom
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Realisasi Jam Kerja Pegawai.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($mySpreadsheet, 'Xlsx');
        $writer->save('php://output');
        die;
    }
}
