<?php

namespace App\Http\Controllers;

use App\Models\Pp;
use App\Models\User;
use App\Models\NamaPp;
use App\Models\Kompetensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Http\Request;

class AnalisKompetensiController extends Controller
{
    protected $status = [
        1   => 'Disetujui',
        2   => 'Ditolak',
        3   => 'Menunggu Persetujuan'
    ];

    protected $colorText = [
        1   => 'success',
        2   => 'danger',
        3   => 'primary'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('analis_sdm');
        
        $kompetensi = Kompetensi::all();
        $pegawai = User::all();
        $pp = Pp::all()->whereNotIn('is_aktif', [0]);
        $nama_pp = NamaPp::whereNot('id', '999')->get();

        return view('analis-sdm.kelola-kompetensi.index',[
            'type_menu'     => 'kompetensi',
            'colorText'     => $this->colorText,
            'status'        => $this->status,
            'pegawai'       => $pegawai,
            'pps'            => $pp,
            'nama_pps'       => $nama_pp,
            'role'          => 'analis sdm'
        ])->with('kompetensi', $kompetensi);
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
        $this->authorize('analis_sdm'); 
        // dd($request->all());

        $rules = [
            'pegawai_id'       => 'required',
            'pp_id'            => 'required',
            'pp_lain'       => 'required_if:pp_id,==,999',
            'nama_pp_id'        => 'required',
            'nama_pp_lain'   => 'required_if:nama_pp_id,==,999',
            'create-sertifikat'    => 'required|mimes:pdf|max:500'
        ];

        $messages = [
            'required' => 'Harus diisi',
            'required_if' => 'Harus diisi',
            'mimes' => 'Format file harus pdf',
            'max' => 'Ukuran file maksimal 500KB'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        $validateData['sertifikat'] =  time().'.'.$validateData['create-sertifikat']->getClientOriginalExtension();
        $validateData['create-sertifikat']->move(public_path()."/document/sertifikat/", $validateData['sertifikat']);

        $validateData['status'] = 1;
        $validateData['approved_by'] = auth()->user()->id;
        $validateData['catatan'] = $request->catatan;

        // $validateData = $request->validate($rules);

        Kompetensi::create($validateData);
        $request->session()->put('status', 'Berhasil menambahkan kompetensi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah kompetensi pegawai.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterPimpinan  $masterPimpinan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('analis_sdm');
        
        $kompetensi = Kompetensi::where('id', $id)->get();
        $peserta = $kompetensi->first()->namaPp->peserta;

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Kompetensi',
            'data'    => $kompetensi,
            'peserta' => $peserta
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterPimpinan  $masterPimpinan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 
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
        $this->authorize('analis_sdm');

        if($request->approval) {
            $kompetensiEdit = Kompetensi::where('id', $id)->update([
                'status' => $request->status,
                'approved_by' => auth()->user()->id
            ]);

            if ($request->status == "1") $str = "menyetujui";
            else $str = "menolak";
            $request->session()->put('status', 'Berhasil '.$str.' data kompetensi.');
            $request->session()->put('alert-type', 'success');

            return response()->json([
                'success'   => true,
                'message'   => 'Data Berhasil Diperbarui',
                'data'      => $kompetensiEdit
            ]);
        }

        $kompetensi = Kompetensi::find($id);

        $rules = [
            'edit-pp'            => 'required',
            'edit-pp_lain'       => 'required_if:edit-pp,==,999',
            'edit-nama_pp'        => 'required|not_in:null',
            'edit-nama_pp_lain'   => 'required_if:edit-nama_pp,==,999',
            'edit-sertifikat'     => 'nullable|mimes:pdf|max:500'
        ];

        $messages = [
            'required' => 'Harus diisi',
            'required_if' => 'Harus diisi',
            'mimes' => 'Format file harus pdf',
            'max' => 'Ukuran file maksimal 500KB'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);
        // dd(isset($validateData['edit-pp_lain']));
        $data = [
            'pp_id'     => $validateData['edit-pp'],
            'nama_pp_id'   => $validateData['edit-nama_pp'],
            'catatan'      => $request['edit-catatan']
        ];

        if (isset($validateData['edit-pp_lain'])) 
            $data['pp_lain'] = $validateData['edit-pp_lain'];
        if (isset($validateData['edit-nama_pp_lain'])) 
            $data['nama_pp_lain'] = $validateData['edit-nama_pp_lain'];

        if ($request['edit-sertifikat']) {
            $sertifikat = $request['edit-sertifikat'];
            File::delete(public_path()."/document/sertifikat/".$kompetensi->sertifikat);
            $data['sertifikat'] = time().'.'.$sertifikat->getClientOriginalExtension();
            $sertifikat->move(public_path()."/document/sertifikat/", $data['sertifikat']);
        }

        $kompetensiEdit = Kompetensi::where('id', $id)->update($data);

        $request->session()->put('status', 'Berhasil memperbarui data kompetensi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $kompetensiEdit
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterPimpinan  $masterPimpinan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('analis_sdm');

        $kompetensi = Kompetensi::find($id);
        File::delete(public_path()."/document/sertifikat/".$kompetensi->sertifikat);

        Kompetensi::destroy($id);
        $request->session()->put('status', 'Berhasil menghapus data kompetensi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data kompetensi',
        ]);
    }
}
