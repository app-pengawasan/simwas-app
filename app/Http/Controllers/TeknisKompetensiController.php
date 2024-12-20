<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeknisKompetensi;

class TeknisKompetensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'jenis_id' => 'required',
            'nama' => 'required|unique:teknis_kompetensis',
        ],[
            'required' => 'Wajib diisi.',
            'unique' => 'Nama PP yang dimasukkan sudah ada.'
        ]);

        TeknisKompetensi::create($validatedData);

        return redirect('/analis-sdm/jenis/'.$request->input('jenis_id'))->with('success', 'Berhasil menambahkan teknis kompetensi!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisKompetensi  $JenisKompetensi
     * @return \Illuminate\Http\Response
     */
    public function show(TeknisKompetensi $jenis)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisKompetensi  $JenisKompetensi
     * @return \Illuminate\Http\Response
     */
    public function edit(TeknisKompetensi $JenisKompetensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JenisKompetensi  $JenisKompetensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('analis_sdm');

        TeknisKompetensi::where('id', $id)->update([
            'nama' => $request->nama
        ]);

        $request->session()->put('status', 'Berhasil mengedit teknis kompetensi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisKompetensi  $JenisKompetensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeknisKompetensi $tekni)
    {
        $this->authorize('analis_sdm');
        $tekni->delete();
        return redirect('/analis-sdm/jenis/'.$tekni->jenis_id)
                ->with('success', 'Berhasil menghapus teknis kompetensi!');
    }
}
