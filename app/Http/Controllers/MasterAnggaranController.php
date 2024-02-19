<?php

namespace App\Http\Controllers;

use App\Models\MasterAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterAnggaranController extends Controller
{
    protected $program_manggaran = '054.01.WA Program Dukungan Manajemen dan Pelaksanaan Tugas Teknis Lainnya BPS';

    protected $kegiatan_manggaran = [
        '4203'  => '4203 Pengawasan dan Peningkatan Akuntabilitas Inspektorat I',
        '4204'  => '4204 Pengawasan dan Peningkatan Akuntabilitas Inspektorat II',
        '4205'  => '4205 Pengawasan dan Peningkatan Akuntabilitas Inspektorat III',
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin');
        $masterAnggaran = MasterAnggaran::all();
        return view('admin.master-anggaran.index', [
            'type_menu'     => 'anggaran',
            'masterAnggaran'=> $masterAnggaran
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.master-anggaran.create', [
            'type_menu'         => 'anggaran',
            'program_manggaran' => $this->program_manggaran,
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
        $rules = [
            'id_kegiatan'   => 'unique:master_anggarans|required|size:4',
            'kegiatan'      => 'required|min:8'
        ];

        $validateData = $request->validate($rules);
        $validateData["program"] = $this->program_manggaran;
        MasterAnggaran::create($validateData);

        return redirect(route('master-anggaran.index'))
            ->with('status', 'Berhasil menambahkan master anggaran.')
            ->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterAnggaran  $masterAnggaran
     * @return \Illuminate\Http\Response
     */
    public function show(MasterAnggaran $masterAnggaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterAnggaran  $masterAnggaran
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterAnggaran $masterAnggaran)
    {

        return view('admin.master-anggaran.edit', [
            'type_menu' => 'anggaran',
        ])->with('masterAnggaran', $masterAnggaran);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterAnggaran  $masterAnggaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterAnggaran $masterAnggaran)
    {
        $rules = [
            'kegiatan'      => 'required|min:8'
        ];

        if($request->id_kegiatan != $masterAnggaran->id_kegiatan){
            $rules["id_kegiatan"] = 'unique:master_anggarans|required|size:4';
        }

        $validateData = $request->validate($rules);

        MasterAnggaran::where('id_manggaran', $masterAnggaran->id_manggaran)->update($validateData);

        return redirect(route('master-anggaran.index'))->with('success', 'Berhasil mengubah data master anggaran.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterAnggaran  $masterAnggaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MasterAnggaran::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!',
        ]);
    }
}
