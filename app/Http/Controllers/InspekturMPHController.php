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
use App\Models\PelaksanaTugas;
use App\Models\OperatorRencanaKinerja;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class InspekturMPHController extends Controller
{
    protected $unitkerja = [
        '8000'    => 'Inspektorat Utama',
        '8010'    => 'Bagian Umum Inspektorat Utama',
        '8100'    => 'Inspektorat Wilayah I',
        '8200'    => 'Inspektorat Wilayah II',
        '8300'    => 'Inspektorat Wilayah III',
    ];

    protected $jabatanPelaksana = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim', 'PJ Kegiatan'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('inspektur');

        $unit = $request->unit;
        if ($unit == null || $unit == "undefined") {
            $unit = auth()->user()->unit_kerja;
        } else {
            $unit = $unit;
        }

        $year = $request->year;
        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        } 

        if ($unit == '8000') {
            $pelaksanaTugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($unit, $year) {
                                    $query->where('tahun', $year);
                                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as jam_pengawasan')
                                  ->get();
        } else {
            $pelaksanaTugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($unit, $year) {
                                    $query->where('unitkerja', $unit);
                                    $query->where('tahun', $year);
                                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as jam_pengawasan')
                                  ->get();
        }

        $year = TimKerja::select('tahun')->distinct()->orderBy('tahun', 'desc')->get();

        $currentYear = date('Y');

        $yearValues = $year->pluck('tahun')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['tahun' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('tahun');
        $unit = auth()->user()->unit_kerja;

        return view('inspektur.matriks-peran-hasil.index', [
            'pelaksanaTugas' => $pelaksanaTugas,
            'year' => $year,
            'unitkerja' => $this->unitkerja,
            'jabatanPelaksana' => $this->jabatanPelaksana,
            'unit' => $unit
        ]);
    }

    public function indexHari(Request $request)
    {
        $this->authorize('inspektur');

        $unit = $request->unit;
        if ($unit == null || $unit == "undefined") {
            $unit = auth()->user()->unit_kerja;
        } else {
            $unit = $unit;
        }

        $year = $request->year;
        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        } 

        if ($unit == '8000') {
            $pelaksanaTugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($unit, $year) {
                                    $query->where('tahun', $year);
                                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as jam_pengawasan')
                                  ->get();
        } else {
            $pelaksanaTugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($unit, $year) {
                                    $query->where('unitkerja', $unit);
                                    $query->where('tahun', $year);
                                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as jam_pengawasan')
                                  ->get();
        }

        $year = TimKerja::select('tahun')->distinct()->orderBy('tahun', 'desc')->get();

        $currentYear = date('Y');

        $yearValues = $year->pluck('tahun')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['tahun' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('tahun');
        $unit = auth()->user()->unit_kerja;

        return view('inspektur.matriks-peran-hasil.hari', [
            'pelaksanaTugas' => $pelaksanaTugas,
            'year' => $year,
            'unitkerja' => $this->unitkerja,
            'jabatanPelaksana' => $this->jabatanPelaksana,
            'unit' => $unit
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
        
    }

    public function export($unit, $year)
    {
        $this->authorize('inspektur');
        
        if ($unit == 'undefined') $unit = auth()->user()->unit_kerja;

        if ($unit == '8000') {
            $pelaksanaTugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($unit, $year) {
                                    $query->where('tahun', $year);
                                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as jam_pengawasan')
                                  ->get();
        } else {
            $pelaksanaTugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($unit, $year) {
                                    $query->where('unitkerja', $unit);
                                    $query->where('tahun', $year);
                                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as jam_pengawasan')
                                  ->get();
        }

        $mySpreadsheet = new Spreadsheet();
        $sheet = $mySpreadsheet->getSheet(0);
        $sheet->setTitle('MPH (Jam)');
        $data = [
            ['Unit Kerja', 'Tim PJK', 'Proyek', 'Tugas', 'Hasil Kerja Tim', 'Nama Pelaksana', 'Peran',
             'Rencana Kinerja', 'Indikator Kinerja Individu', 'Kegiatan', 'Hasil Kerja Pegawai',
             'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des', 
             'Jam Pengawasan (Jam)', 'Target Laporan/Dokumen']
        ];

        $mySpreadsheet->createSheet();
        $sheet2 = $mySpreadsheet->getSheet(1);
        $sheet2->setTitle('MPH (Hari)');
        $data2 = [
            ['Unit Kerja', 'Tim PJK', 'Proyek', 'Tugas', 'Hasil Kerja Tim', 'Nama Pelaksana', 'Peran',
             'Rencana Kinerja', 'Indikator Kinerja Individu', 'Kegiatan', 'Hasil Kerja Pegawai',
             'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des', 
             'Jam Pengawasan (Hari)', 'Target Laporan/Dokumen']
        ];

        foreach ($pelaksanaTugas as $pelaksana) {
            //ambil rk, iki, kegiatan, dan hasil kerja pegawai
            $tugas = $pelaksana->rencanaKerja->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $pelaksana->pt_jabatan )->first(); 

            //hitung jumlah laporan/dokumen norma hasil
            $jml_laporan = 0;
            foreach ($pelaksana->rencanaKerja->objekPengawasan as $op) {
                $jml_laporan += $op->laporanObjekPengawasan->where('status', 1)->count();
            }

            //push data ke sheet 1
            array_push($data, [
                                $this->unitkerja[$pelaksana->rencanaKerja->proyek->timKerja->unitkerja],
                                $pelaksana->rencanaKerja->proyek->timKerja->nama,
                                $pelaksana->rencanaKerja->proyek->nama_proyek,
                                $pelaksana->rencanaKerja->tugas,
                                $pelaksana->rencanaKerja->hasilKerja->nama_hasil_kerja,
                                $pelaksana->user->name,
                                $this->jabatanPelaksana[$pelaksana->pt_jabatan],
                                $tugas->rencana_kinerja, $tugas->iki, $tugas->kegiatan, $tugas->hasil_kerja,
                                $pelaksana->jan, $pelaksana->feb, $pelaksana->mar, $pelaksana->apr, $pelaksana->mei,
                                $pelaksana->jun, $pelaksana->jul, $pelaksana->agu, $pelaksana->sep, $pelaksana->okt,
                                $pelaksana->nov, $pelaksana->des, $pelaksana->jam_pengawasan, $jml_laporan
                              ]);

            //push data ke sheet 2
            array_push($data2, [
                                $this->unitkerja[$pelaksana->rencanaKerja->proyek->timKerja->unitkerja],
                                $pelaksana->rencanaKerja->proyek->timKerja->nama,
                                $pelaksana->rencanaKerja->proyek->nama_proyek,
                                $pelaksana->rencanaKerja->tugas,
                                $pelaksana->rencanaKerja->hasilKerja->nama_hasil_kerja,
                                $pelaksana->user->name,
                                $this->jabatanPelaksana[$pelaksana->pt_jabatan],
                                $tugas->rencana_kinerja, $tugas->iki, $tugas->kegiatan, $tugas->hasil_kerja,
                                round($pelaksana->jan / 7.5, 2), round($pelaksana->feb / 7.5, 2), round($pelaksana->mar / 7.5, 2), round($pelaksana->apr / 7.5, 2), round($pelaksana->mei / 7.5, 2),
                                round($pelaksana->jun / 7.5, 2), round($pelaksana->jul / 7.5, 2), round($pelaksana->agu / 7.5, 2), round($pelaksana->sep / 7.5, 2), round($pelaksana->okt / 7.5, 2),
                                round($pelaksana->nov / 7.5, 2), round($pelaksana->des / 7.5, 2), round($pelaksana->jam_pengawasan / 7.5, 2), $jml_laporan
                              ]);
        }

        $sheet->fromArray($data);
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true); //resize kolom
        }

        $sheet2->fromArray($data2);
        foreach ($sheet2->getColumnIterator() as $column) {
            $sheet2->getColumnDimension($column->getColumnIndex())->setAutoSize(true); //resize kolom
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Matriks Peran Hasil.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($mySpreadsheet, 'Xlsx');
        $writer->save('php://output');
        die;
    }

}

