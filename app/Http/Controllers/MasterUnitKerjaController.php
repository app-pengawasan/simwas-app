<?php

namespace App\Http\Controllers;

use App\Imports\UnitKerjaImport;
use App\Models\MasterObjek;
use App\Models\PaguAnggaran;
use Illuminate\Http\Request;
use App\Models\MasterUnitKerja;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class MasterUnitKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterUnitKerja = MasterUnitKerja::where('kategori', 1)->get();

        return view('admin.master-objek.unit-kerja', [
            'type_menu'         => 'objek',
            'title_modal'       => 'Import Data Unit Kerja BPS',
            'url_modal_import'  => '/admin/master-unit-kerja/import',
            'master_unitkerja'  => $masterUnitKerja
        ])->with([

        ]);
        // return $masterUnitKerja;
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
            'kode_unitkerja'    => 'required|unique:master_objeks,kode_unitkerja|max:4',
            'nama'              => 'required',
        ];

        $validateData = $request->validate($rules);
        $validateData['kategori'] = 1;
        MasterObjek::create($validateData);
        return redirect(route('master-unit-kerja.index'))->with('success', 'Berhasil menambah data unit kerja.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterUnitKerja  $masterUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $masterUnitKerja = MasterObjek::where('id_objek', $id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Unit kerja',
            'data'    => $masterUnitKerja
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterUnitKerja  $masterUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterUnitKerja $masterUnitKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterUnitKerja  $masterUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'kode_wilayah'      => 'required|max:2',
            'kode_unitkerja'    => 'required|unique:master_objeks,kode_unitkerja|max:4',
            'nama'              => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $masterUnitKerja = MasterObjek::where('id_objek', $id)
        ->update([
            'kode_wilayah'      => $request->kode_wilayah,
            'kode_unitkerja'    => $request->kode_unitkerja,
            'nama'              => $request->nama
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $masterUnitKerja
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterUnitKerja  $masterUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MasterObjek::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Unit Kerja Berhasil Dihapus!.',
        ]);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request)
    {
        $validateFile = $request->validate([
            'file' => 'required|mimes::xls,xlsx'
        ]);

        $file = $request->file('file');
        $file_name = rand().$file->getClientOriginalName();
        $file->move('document/upload', $file_name);

        Excel::import(new UnitKerjaImport, public_path('/document/upload/'.$file_name));
        return back()->with('success', 'Berhasil mengimpor data Unit Kerja.');
    }
}