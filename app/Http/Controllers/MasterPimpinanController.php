<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MasterPimpinan;
use Illuminate\Http\Request;
// use Illuminate\Http\Request;

class MasterPimpinanController extends Controller
{
    protected $pangkat = [
        'II/a' =>	'Pengatur Muda',
        'II/b' =>	'Pengatur Muda Tingkat I',
        'II/c' => 	'Pengatur',
        'II/d' => 	'Pengatur Tingkat I',
        'III/a' =>	'Penata Muda',
        'III/b' =>	'Penata Muda Tingkat I',
        'III/c' =>	'Penata',
        'III/d' =>	'Penata Tingkat I',
        'IV/a' =>	'Pembina',
        'IV/b' =>	'Pembina Tingkat I',
        'IV/c' =>	'Pembina Muda',
        'IV/d' =>	'Pembina Madya',
        'IV/e' =>	'Pembina Utama'
    ];

    protected $unit_kerja = [
        '8000' => 'Inspektorat Utama',
        '8010' => 'Bagian Umum Inspektorat Utama',
        '8100' => 'Inspektorat Wilayah I',
        '8200' => 'Inspektorat Wilayah II',
        '8300' => 'Inspektorat Wilayah III'
    ];

    protected $jabatan = [
        '21' =>	'Auditor Utama',
        '22' =>	'Auditor Madya',
        '23' =>	'Auditor Muda',
        '24' =>	'Auditor Pertama',
        '25' =>	'Auditor Penyelia',
        '26' =>	'Auditor Pelaksana Lanjutan',
        '27' =>	'Auditor Pelaksana',
        '31' =>	'Perencana Madya',
        '32' =>	'Perencana Muda',
        '33' =>	'Perencana Pertama',
        '41' =>	'Analis Kepegawaian Madya',
        '42' =>	'Analis Kepegawaian Muda',
        '43' =>	'Analis Kepegawaian Pertama',
        '51' =>	'Analis Pengelolaan Keuangan APBN Madya',
        '52' =>	'Analis Pengelolaan Keuangan APBN Muda',
        '53' =>	'Analis Pengelolaan Keuangan APBN Pertama',
        '61' =>	'Pranata Komputer Madya',
        '62' =>	'Pranata Komputer Muda',
        '63' =>	'Pranata Komputer Pratama',
        '71' =>	'Arsiparis Madya',
        '72' =>	'Arsiparis Muda',
        '73' =>	'Arsiparis Pertama',
        '81' =>	'Analis Hukum Madya',
        '82' =>	'Analis Hukum Muda',
        '83' =>	'Analis Hukum Pertama',
        '91' =>	'Penatalaksana Barang',
        '90' =>	'Fungsional Umum'
    ];

    protected $role = [
        'is_admin'      => 'Admin',
        'is_sekma'      => 'Sekretaris Utama',
        'is_sekwil'     => 'Sekretaris Wilayah',
        'is_perencana'  => 'Perencana',
        'is_apkapbn'    => 'APK-APBN',
        'is_opwil'      => 'Operator Wilayah',
        'is_analissdm'  => 'Analis SDM'
    ];

    protected $jabatan_pimpinan = [
        'jpm000'      => 'Inspektur Utama',
        'jpm001'      => 'Inspektur Wilayah I',
        'jpm002'      => 'Inspektur Wilayah II',
        'jpm003'      => 'Inspektur Wilayah III',
        'jpm004'      => 'Kepala Bagian Umum'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pimpinan = MasterPimpinan::all();

        return view('admin.master-pimpinan.index',[
            'type_menu'     => 'master-pimpinan',
            'pangkat'       => $this->pangkat,
            'unit_kerja'    => $this->unit_kerja,
            'jabatan'       => $this->jabatan,
            'role'          => $this->role,
            'jabatan_pimpinan' =>$this->jabatan_pimpinan
        ])->with('pimpinan', $pimpinan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();

        return view('admin.master-pimpinan.create',[
            'type_menu'     => 'master-pimpinan',
            'pangkat'       => $this->pangkat,
            'unit_kerja'    => $this->unit_kerja,
            'jabatan'       => $this->jabatan,
            'role'          => $this->role,
            'jabatan_pimpinan' =>$this->jabatan_pimpinan
        ])->with('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMasterPimpinanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'id_user'   => 'required',
            'jabatan'   => 'required',
            'mulai'     => 'required|date',
            'selesai'   => 'required|date|after:mulai',
        ];

        $validateData = $request->validate($rules);
        // $validateData = $request->validate($rules);

        MasterPimpinan::create($validateData);
        return redirect(route('master-pimpinan.index'))->with('status', 'Berhasil Menambah Pimpinan.')->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterPimpinan  $masterPimpinan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pimpinan = MasterPimpinan::find($id);
        return view('admin.master-pimpinan.show',[
            'type_menu'     => 'master-pimpinan',
            'pangkat'       => $this->pangkat,
            'unit_kerja'    => $this->unit_kerja,
            'jabatan'       => $this->jabatan,
            'role'          => $this->role,
            'jabatan_pimpinan' =>$this->jabatan_pimpinan
        ])->with('pimpinan', $pimpinan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterPimpinan  $masterPimpinan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::all();
        $pimpinan = MasterPimpinan::find($id);
        return view('admin.master-pimpinan.edit', [
            'type_menu'     => 'master-pimpinan',
            'pangkat'       => $this->pangkat,
            'unit_kerja'    => $this->unit_kerja,
            'jabatan'       => $this->jabatan,
            'role'          => $this->role,
            'jabatan_pimpinan' =>$this->jabatan_pimpinan,
            'users'         => $users
        ])->with('pimpinan', $pimpinan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterPimpinanRequest  $request
     * @param  \App\Models\MasterPimpinan  $masterPimpinan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pimpinan = MasterPimpinan::find($id);

        $rules = [
            // 'id_user'   => 'required',
            'jabatan'   => 'required',
            'mulai'     => 'required|date',
            'selesai'   => 'required|date|after:mulai',
        ];

        $validateData = $request->validate($rules);

        MasterPimpinan::where('id_pimpinan', $id)->update($validateData);
        return redirect(route('master-pimpinan.index'))->with('status', 'Berhasil Memperbarui Pimpinan.')->with('alert-type', 'success');
        // return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterPimpinan  $masterPimpinan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MasterPimpinan::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!',
        ]);
    }
}
