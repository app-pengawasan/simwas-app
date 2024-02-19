<?php

namespace App\Http\Controllers;

use App\Models\MasterObjek;
use App\Models\WilayahKerja;
use Illuminate\Http\Request;
use App\Imports\WilayahKerjaImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
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
        $this->authorize('admin');

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
            'kode_wilayah'      => 'required|unique:master_objeks,kode_wilayah|size:4',
            'nama'              => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);
        $validateData['kategori'] = 3;
        MasterObjek::create($validateData);

        $request->session()->put('status', 'Berhasil menambahkan data Wilayah Kerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah data Wilayah Kerja',
        ]);
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
        $wilayahKerja = MasterObjek::where('id_objek', $id)->first();

        $rules = [
            'kode_wilayah'      => 'required|max:4',
            'nama'              => 'required',
        ];

        if($request->kode_wilayah != $wilayahKerja->kode_wilayah){
            $rules['kode_wilayah'] = 'required|unique:master_objeks,kode_wilayah|size:4';
        }else{
            $rules['kode_wilayah'] = 'required|size:4';
        }

        $validator = Validator::make($request->all(), $rules);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        MasterObjek::where('id_objek', $id)
        ->update([
            'kode_wilayah'      => $request->kode_wilayah,
            'nama'              => $request->nama
        ]);

        $request->session()->put('status', 'Berhasil memperbarui data Wilayah Kerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WilayahKerja  $wilayahKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        MasterObjek::destroy($id);
        $request->session()->put('status', 'Berhasil menghapus data Wilayah Kerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data Wilayah Kerja',
        ]);
    }

    public function import(Request $request)
    {
        $validateFile = $request->validate([
            'file' => 'required|mimes::xls,xlsx'
        ]);

        $file = $request->file('file');
        $file_name = rand().$file->getClientOriginalName();
        $file->move(storage_path('/document/upload/'), $file_name);

        $header = (new HeadingRowImport)->toArray(storage_path('/document/upload/').$file_name);

        $rules = [
            'kode_wilayah',
            'nama'
        ];

        foreach($rules as $rule){
            if(!in_array($rule, $header[0][0])){
               return back()
               ->with('status', 'Gagal mengimpor data, format file tidak sesuai. Silahkan unduh format yang telah disediakan.')
               ->with('alert-type', 'danger');
            }
        }

        Excel::import(new WilayahKerjaImport, storage_path('/document/upload/').$file_name);
        return back()->with('status', 'Berhasil mengimpor data Wilayah Kerja.')->with('alert-type', 'success');
    }
}
