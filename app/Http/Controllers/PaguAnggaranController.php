<?php

namespace App\Http\Controllers;

use App\Models\PaguAnggaran;
use Illuminate\Http\Request;
use App\Models\MasterAnggaran;
use Illuminate\Support\Facades\DB;

class PaguAnggaranController extends Controller
{
    protected $program_manggaran = '054.01.WA Program Dukungan Manajemen dan Pelaksanaan Tugas Teknis Lainnya BPS';

    protected $kegiatan_manggaran = [
        '4203'  => '4203 Pengawasan dan Peningkatan Akuntabilitas Inspektorat I',
        '4204'  => '4204 Pengawasan dan Peningkatan Akuntabilitas Inspektorat II',
        '4205'  => '4205 Pengawasan dan Peningkatan Akuntabilitas Inspektorat III',
    ];

    protected $komponen = [
        '051'   => 'Persiapan',
        '052'   => 'Pelaksanaan'
    ];

    protected $akun = [
        '521111'    => 'Belanja Keperluan Perkantoran',
        '522151'    => 'Belanja Jasa Profesi',
        '524111'    => 'Belanja Perjalanan Dinas Biasa',
        '524113'    => 'Belanja Perjalanan Dinas Dalam Kota'
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
    public function index()
    {
        $this->authorize('admin');
        $paguAnggaran = PaguAnggaran::with('masterAnggaran')->get();

        return view('admin.pagu-anggaran.index', [
            'type_menu'     => 'anggaran',
            'paguAnggaran'  => $paguAnggaran,
            'satuan'        => $this->satuan,
            'akun'          => $this->akun,
            'komponen'      => $this->komponen,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pagu-anggaran.create', [
            'type_menu'     => 'anggaran',
            'program_manggaran' => $this->program_manggaran,
            'kegiatan'          => DB::select('select id_kegiatan, kegiatan from master_anggarans where ?', [1]),
            'komponen'          => $this->komponen,
            'akun'              => $this->akun,
            'satuan'            => $this->satuan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pattern = '/[^,\d]/';
        $rules = [
            'tahun'         =>'required',
            'kegiatan'      =>'required',
            'komponen'      =>'required',
            'akun'          =>'required',
            'uraian'        =>'required',
            'volume'        =>'required',
            'satuan'        =>'required',
            'harga_satuan'  =>'required',
            'pagu'          =>'required'
        ];
        $id_manggaran = DB::select('select id_manggaran from master_anggarans where id_kegiatan=?', [$request->kegiatan]);
        $validateData = $request->validate($rules);
        $validateData["id_manggaran"] = $id_manggaran[0]->id_manggaran;
        $validateData["harga"] = preg_replace($pattern, "" ,$request->harga_satuan);
        $validateData["pagu"] = preg_replace($pattern, "" ,$request->pagu);

        PaguAnggaran::create($validateData);

        // return redirect(route('pagu-anggaran.index'))->with('success', 'Berhasil menambah data pagu anggaran.');
        return redirect(route('pagu-anggaran.index'))
            ->with('status', 'Berhasil menambahkan pagu anggaran.')
            ->with('alert-type', 'success');
        // return $validateData;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PaguAnggaran $paguAnggaran)
    {
        // dd($paguAnggaran);
        return view('admin.pagu-anggaran.show',[
            'type_menu'         => 'anggaran',
            'kegiatan'          => $this->kegiatan_manggaran,
            'komponen'          => $this->komponen,
            'akun'              => $this->akun,
            'satuan'            => $this->satuan
        ])->with('pagu_anggaran', $paguAnggaran);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PaguAnggaran $paguAnggaran)
    {
        return view('admin.pagu-anggaran.edit', [
            'type_menu'         => 'anggaran',
            'kegiatan'          => DB::select('select id_kegiatan, kegiatan from master_anggarans where ?', [1]),
            'komponen'          => $this->komponen,
            'akun'              => $this->akun,
            'satuan'            => $this->satuan
        ])->with('paguAnggaran', $paguAnggaran);

        // return $paguAnggaran;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaguAnggaran $paguAnggaran)
    {
        $pattern = '/[^,\d]/';
        $rules = [
            'tahun'         =>'required',
            // 'kegiatan'      =>'required',
            'komponen'      =>'required',
            'akun'          =>'required',
            'uraian'        =>'required',
            'volume'        =>'required',
            'satuan'        =>'required',
            // 'harga_satuan'  =>'required',
            'pagu'          =>'required'
        ];
        $id_manggaran = DB::select('select id_manggaran from master_anggarans where id_kegiatan=?', [$request->kegiatan]);
        $validateData = $request->validate($rules);
        $validateData["id_manggaran"] = $id_manggaran[0]->id_manggaran;
        $validateData["harga"] = preg_replace($pattern, "" ,$request->harga_satuan);
        $validateData["pagu"] = preg_replace($pattern, "" ,$request->pagu);

        PaguAnggaran::where('id_panggaran', $paguAnggaran->id_panggaran)->update($validateData);
        // return redirect(route('pagu-anggaran.index'))->with('success', 'Berhasil update data pagu anggaran.');
        return redirect(route('pagu-anggaran.index'))
            ->with('status', 'Berhasil memperbarui pagu anggaran.')
            ->with('alert-type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaguAnggaran $paguAnggaran)
    {
        PaguAnggaran::destroy($paguAnggaran->id_panggaran);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!',
        ]);
    }
}
