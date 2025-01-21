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
use App\Models\OperatorRencanaKinerja;
use App\Models\PelaksanaTugas;
use Illuminate\Database\Eloquent\Builder;

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
        if ($unit == null) {
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

}

