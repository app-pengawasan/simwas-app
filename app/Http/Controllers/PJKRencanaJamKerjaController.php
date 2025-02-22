<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class PJKRencanaJamKerjaController extends Controller
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
        $bulans = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];

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
            $tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                        $query->where('tahun', $year);
                    })->groupBy('id_pegawai')->select('id_pegawai as id')
                    ->selectRaw('sum('.implode('+', $bulans).') as total');
        } else {
            $pegawai = User::where('status', 1)->where('unit_kerja', $unit)->get();
            $tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                        $query->where('tahun', $year);
                    })->whereRelation('user', function (Builder $query) use ($unit) {
                        $query->where('unit_kerja', $unit);
                    })->groupBy('id_pegawai')->select('id_pegawai as id')
                    ->selectRaw('sum('.implode('+', $bulans).') as total');  
        } 

        foreach ($bulans as $bulan) {
            $tugas = $tugas->selectRaw("SUM(".$bulan.") as ".$bulan);
        }
        $tugas = $tugas->get();

        $jam_kerja = $pegawai->toBase()->merge($tugas)->groupBy('id');

        $unituser = auth()->user()->unit_kerja;

        return view('pjk.rencana-jam-kerja.rekap',[
            'type_menu'     => 'rencana-jam-kerja',
            'unituser'      => $unituser
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

        $unit = auth()->user()->unit_kerja;
        if ($unit == '8000' || $unit == '8010') $unit = $request->unit;
        else if ($request->unit != null && $request->unit != $unit) return redirect()->to('/');

        if ($unit == null || $unit == '8000') {
            $pegawai = User::where('status', 1)->get();
            $tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                            $query->where('tahun', $year);
                        })->get();
        } else {
            $pegawai = User::where('status', 1)->where('unit_kerja', $unit)->get();
            $tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                            $query->where('tahun', $year);
                        })->whereRelation('user', function (Builder $query) use ($unit) {
                            $query->where('unit_kerja', $unit);
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

        $unituser = auth()->user()->unit_kerja;

        return view('pjk.rencana-jam-kerja.pool',[
            'type_menu'     => 'rencana-jam-kerja',
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
        $this->authorize('pjk');

        $tugas = PelaksanaTugas::where('id_pegawai', $id)
                ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                    $query->where('tahun', $year);
                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as total')
                  ->get();

        $pegawai = User::findOrFail($id)->name;

        return view('pjk.rencana-jam-kerja.show',[
            'type_menu'     => 'rencana-jam-kerja',
            'jabatan'       => $this->jabatan,
            'pegawai'       => $pegawai
        ])->with('tugas', $tugas);
    }

    public function detailTugas($id)
    {
        $this->authorize('pjk');

        $tugas = PelaksanaTugas::where('id_pelaksana', $id)->first();
        $pegawai = User::all();

        return view('pjk.rencana-jam-kerja.detail-tugas', [
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
            'rencanaKerja'  => $tugas->rencanaKerja,
            'pegawai'       => $pegawai
        ]);
    }

    public function export($mode, $year, $unit)
    {
        $this->authorize('admin');
        $bulans = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        if ($unit == null || $unit == '8000') {
            $pegawai = User::where('status', 1)->get();
            $tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                        $query->where('tahun', $year);
                    })->groupBy('id_pegawai')->select('id_pegawai as id')
                    ->selectRaw('sum('.implode('+', $bulans).') as total');
        } else {
            $pegawai = User::where('status', 1)->where('unit_kerja', $unit)->get();
            $tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                        $query->where('tahun', $year);
                    })->whereRelation('user', function (Builder $query) use ($unit) {
                        $query->where('unit_kerja', $unit);
                    })->groupBy('id_pegawai')->select('id_pegawai as id')
                    ->selectRaw('sum('.implode('+', $bulans).') as total');  
        } 

        foreach ($bulans as $bulan) {
            $tugas = $tugas->selectRaw("SUM(".$bulan.") as ".$bulan);
        }
        $tugas = $tugas->get();

        $jam_kerja = $pegawai->toBase()->merge($tugas)->groupBy('id');

        $mySpreadsheet = new Spreadsheet();
        $sheet = $mySpreadsheet->getSheet(0);
        $sheet->setTitle('REKAP');
        $data = [
            ['No.', 'Pegawai', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu',
             'Sep', 'Okt', 'Nov', 'Des', 'Total']
        ];

        $i = 1;
        foreach ($jam_kerja as $jam) {
            if (isset($jam[1])) {
                if ($mode == 'jam')
                    array_push($data, [$i, $jam[0]->name, $jam[1]->jan, $jam[1]->feb, $jam[1]->mar,
                                        $jam[1]->apr, $jam[1]->mei, $jam[1]->jun, $jam[1]->jul,
                                        $jam[1]->agu, $jam[1]->sep, $jam[1]->okt, $jam[1]->nov,
                                        $jam[1]->des, $jam[1]->total]);
                else
                    array_push($data, [$i, $jam[0]->name, round($jam[1]->jan / 7.5, 2), 
                                        round($jam[1]->feb / 7.5, 2), round($jam[1]->mar / 7.5, 2),
                                        round($jam[1]->apr / 7.5, 2), round($jam[1]->mei / 7.5, 2), 
                                        round($jam[1]->jun / 7.5, 2), round($jam[1]->jul / 7.5, 2),
                                        round($jam[1]->agu / 7.5, 2), round($jam[1]->sep / 7.5, 2), 
                                        round($jam[1]->okt / 7.5, 2), round($jam[1]->nov / 7.5, 2),
                                        round($jam[1]->des / 7.5, 2), round($jam[1]->total / 7.5, 2)]);
            }
            else 
                array_push($data, [$i, $jam[0]->name, '0', '0', '0', '0', '0', '0', '0',
                                    '0', '0', '0', '0', '0', '0']);
            $i++;
        } 

        $sheet->fromArray($data);
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
        foreach ($pegawai as $user) {
            $rencana_kerja = PelaksanaTugas::where('id_pegawai', $user->id)
                                ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                                    $query->where('tahun', $year);
                                })->selectRaw('*, ('.implode('+', $bulans).') as total')->get();
            
            if ($rencana_kerja->isEmpty()) {
                array_push($data2, [$i, $user->name, '', '', '', '', '', '', '', '', 
                                    '', '', '', '', '', '', '', '']);
                $i++;
            }
            else
                foreach ($rencana_kerja as $tugas) {
                    if ($mode == 'jam')
                        array_push($data2, [$i, $user->name, $tugas->rencanaKerja->proyek->timkerja->nama,
                                            $tugas->rencanaKerja->proyek->nama_proyek,
                                            $tugas->rencanaKerja->tugas, $tugas->jan, $tugas->feb,
                                            $tugas->mar, $tugas->apr, $tugas->mei, $tugas->jun, $tugas->jul,
                                            $tugas->agu, $tugas->sep, $tugas->okt, $tugas->nov, $tugas->des, $tugas->total]);
                    else
                        array_push($data2, [$i, $user->name, $tugas->rencanaKerja->proyek->timkerja->nama,
                                            $tugas->rencanaKerja->proyek->nama_proyek,
                                            $tugas->rencanaKerja->tugas, round($tugas->jan / 7.5, 2), 
                                            round($tugas->feb / 7.5, 2), round($tugas->mar / 7.5, 2), 
                                            round($tugas->apr / 7.5, 2), round($tugas->mei / 7.5, 2), 
                                            round($tugas->jun / 7.5, 2), round($tugas->jul / 7.5, 2),
                                            round($tugas->agu / 7.5, 2), round($tugas->sep / 7.5, 2), 
                                            round($tugas->okt / 7.5, 2), round($tugas->nov / 7.5, 2), 
                                            round($tugas->des / 7.5, 2), round($tugas->total / 7.5, 2)]);
                    $i++;
                }
        }

        $sheet2->fromArray($data2);
        foreach ($sheet2->getColumnIterator() as $column) {
            $sheet2->getColumnDimension($column->getColumnIndex())->setAutoSize(true); //resize kolom
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rencana Jam Kerja Pegawai.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($mySpreadsheet, 'Xlsx');
        $writer->save('php://output');
        die;
    }
}
