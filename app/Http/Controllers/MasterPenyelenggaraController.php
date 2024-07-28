<?php

namespace App\Http\Controllers;

use App\Models\MasterPenyelenggara;
use App\Models\MasterPimpinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Http\Request;

class MasterPenyelenggaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('analis_sdm'); 
        $masters = MasterPenyelenggara::all();

        return view('analis-sdm.master-penyelenggara.index', [
            'masters' => $masters,
            "type_menu" => 'kompetensi'
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
        $this->authorize('analis_sdm');

        $validatedData = $request->validate([
            'penyelenggara' => 'required|unique:master_penyelenggaras|string|max:255'
        ],[
            'required' => 'Wajib diisi.',
            'unique' => 'Penyelenggara diklat yang dimasukkan sudah ada.'
        ]);

        MasterPenyelenggara::create($validatedData);

        return back()->with('status', 'Berhasil menambahkan penyelenggara diklat!')->with('alert-type', 'success');
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

        $rule = ['penyelenggara' => 'required|unique:master_penyelenggaras|string|max:255'];

        $validateData = request()->validate($rule, [
            'required' => 'Wajib diisi.',
            'unique' => 'Penyelenggara diklat yang dimasukkan sudah ada.'
        ]);

        MasterPenyelenggara::where('id', $id)->update($validateData);

        $request->session()->put('status', 'Berhasil mengedit penyelenggara diklat.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui'
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
    }
}
