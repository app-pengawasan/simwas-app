<?php

namespace App\Http\Controllers;

use App\Models\MasterObjek;
use App\Models\PaguAnggaran;
use Illuminate\Http\Request;
use App\Models\MasterUnitKerja;
use App\Imports\UnitKerjaImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
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
        $this->authorize('admin');
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
            'kode_wilayah'      => 'required|size:2',
            'kode_unitkerja'    => 'required|unique:master_objeks,kode_unitkerja|size:4',
            'nama'              => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);



        $validateData['kategori'] = 1;
        MasterObjek::create($validateData);

        $request->session()->put('status', 'Berhasil menambahkan data Unit Kerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah data Unit Kerja',
        ]);
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
        $unitKerja = MasterObjek::where('id_objek', $id)->first();

        $rules = [
            'nama'              => 'required',
            'kode_wilayah'      => 'required|size:2'
        ];

        if($request->kode_unitkerja != $unitKerja->kode_unitkerja){
            $rules['kode_unitkerja'] = 'required|unique:master_objeks,kode_unitkerja|size:4';
        }else{
            $rules['kode_unitkerja'] = 'required|size:4';
        }

        $validator = Validator::make($request->all(),$rules);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $masterUnitKerja = MasterObjek::where('id_objek', $id)
        ->update([
            'kode_wilayah'      => $request->kode_wilayah,
            'kode_unitkerja'    => $request->kode_unitkerja,
            'nama'              => $request->nama
        ]);

        $request->session()->put('status', 'Berhasil memperbarui data Unit Kerja.');
        $request->session()->put('alert-type', 'success');

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
    public function destroy(Request $request, $id)
    {
        try {
            MasterObjek::destroy($id);
            $request->session()->put('status', 'Berhasil menghapus data Unit Kerja.');
            $request->session()->put('alert-type', 'success');

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data Unit Kerja',
            ]);
        } catch (\Throwable $th) {
            if($th->errorInfo[1] == 1451){
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data Unit Kerja, data masih digunakan pada data lain.',
                ], 409);
            }
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data Unit Kerja',
            ], 500);
        }
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
        $file->move(storage_path('/document/upload/'), $file_name);

        $header = (new HeadingRowImport)->toArray(storage_path('/document/upload/').$file_name);
        $rules = [
            'kode_wilayah',
            'kode_unitkerja',
            'nama'
        ];

        foreach($rules as $rule){
            if(!in_array($rule, $header[0][0])){
               return back()
               ->with('status', 'Gagal mengimpor data, format file tidak sesuai. Silahkan unduh format yang telah disediakan.')
               ->with('alert-type', 'danger');
            }
        }

        Excel::import(new UnitKerjaImport, storage_path('/document/upload/').$file_name);
        return back()->with('status', 'Berhasil mengimpor data Unit Kerja.')->with('alert-type', 'success');
    }
}
