<?php

namespace App\Http\Controllers;

use App\Models\MasterObjek;
use App\Models\SatuanKerja;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use App\Imports\SatuanKerjaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class SatuanKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterSatuanKerja = SatuanKerja::where('kategori', 2)->get();

        // return $masterSatuanKerja;
        return view('admin.master-objek.satuan-kerja', [
            'type_menu'         => 'objek',
            'title_modal'       => 'Import Data Satuan Kerja BPS',
            'url_modal_import'  => '/admin/master-satuan-kerja/import',
            'master_satuankerja'  => $masterSatuanKerja
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
        $rules = [
            'kode_wilayah'      => 'required|max:2',
            'kode_satuankerja'  => 'required|unique:master_objeks,kode_satuankerja|max:4',
            'nama'              => 'required',
        ];

        $validateData = $request->validate($rules);
        $validateData['kategori'] = 2;
        MasterObjek::create($validateData);
        return redirect(route('master-satuan-kerja.index'))->with('success', 'Berhasil Menambah Data Satuan Kerja.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $satuanKerja = MasterObjek::where('id_objek', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Detail Data Satuan Kerja',
            'data'      => $satuanKerja
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(SatuanKerja $satuanKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $satuanKerja = MasterObjek::where('id_objek', $id)->get();

        $rules = [
            'kode_wilayah'      => 'required|max:2',
            'kode_satuankerja'  => 'required|max:4',
            'nama'              => 'required',
        ];

        // if($request->kode_satuankerja != $satuanKerja->kode_satuankerja){
        //     $rules['kode_satuankerja'] = 'required|unique:master_objeks,kode_satuankerja|max:4';
        // }

        $validator = Validator::make($request->all(), $rules);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $satuanKerja = MasterObjek::where('id_objek', $id)
        ->update([
            'kode_wilayah'      => $request->kode_wilayah,
            'kode_satuankerja'  => $request->kode_satuankerja,
            'nama'              => $request->nama
        ]);

        $satuanKerja = MasterObjek::where('id_objek', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $satuanKerja
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MasterObjek::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Satuan Kerja Berhasil Dihapus!.',
        ]);
    }

    public function import(Request $request)
    {
        $validateFile = $request->validate([
            'file' => 'required|mimes::xls,xlsx'
        ]);

        $file = $request->file('file');
        $file_name = rand().$file->getClientOriginalName();
        $file->move('document/upload', $file_name);

        Excel::import(new SatuanKerjaImport, public_path('/document/upload/'.$file_name));
        return back()->with('success', 'Berhasil Mengimpor Data Satuan Kerja.');
    }
}
