<?php

namespace App\Http\Controllers;

use App\Models\MasterObjek;
use App\Models\WilayahKerja;
use Illuminate\Http\Request;
use App\Imports\WilayahKerjaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class WilayahKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterWilayahkerja = WilayahKerja::where('kategori', 3)->get();

        return view('admin.master-objek.wilayah-kerja', [
            'type_menu'         => 'objek',
            'title_modal'       => 'Import Data Wilayah Kerja BPS',
            'url_modal_import'  => '/admin/master-wilayah-kerja/import',
            'master_wilayahkerja'  => $masterWilayahkerja
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
            'kode_wilayah'      => 'required|max:4',
            'nama'              => 'required',
        ];

        $validateData = $request->validate($rules);
        $validateData['kategori'] = 3;
        MasterObjek::create($validateData);
        return redirect(route('master-wilayah-kerja.index'))->with('success', 'Berhasil Menambah Data Wilayah Kerja.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WilayahKerja  $wilayahKerja
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wilayahKerja = MasterObjek::where('id_objek', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Detail Data Wilayah Kerja',
            'data'      => $wilayahKerja
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WilayahKerja  $wilayahKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(WilayahKerja $wilayahKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WilayahKerja  $wilayahKerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $wilayahKerja = MasterObjek::where('id_objek', $id);

        $rules = [
            'kode_wilayah'      => 'required|max:4',
            'nama'              => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        MasterObjek::where('id_objek', $id)
        ->update([
            'kode_wilayah'      => $request->kode_wilayah,
            'nama'              => $request->nama
        ]);

        $wilayahKerja = MasterObjek::where('id_objek', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $wilayahKerja
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WilayahKerja  $wilayahKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MasterObjek::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Wilayah Kerja Berhasil Dihapus!.',
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

        Excel::import(new WilayahKerjaImport, public_path('/document/upload/'.$file_name));
        return back()->with('success', 'Berhasil Mengimpor Data Wilayah Kerja.');
    }
}
