<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisKompetensi;
use App\Models\TeknisKompetensi;

class JenisKompetensiController extends Controller
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
            'kategori_id' => 'required',
            'nama' => 'required|unique:jenis_kompetensis',
        ],[
            'required' => 'Wajib diisi.',
            'unique' => 'Nama PP yang dimasukkan sudah ada.'
        ]);

        JenisKompetensi::create($validatedData);

        return redirect('/analis-sdm/kategori/'.$request->input('kategori_id'))->with('success', 'Berhasil menambahkan jenis kompetensi!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisKompetensi  $JenisKompetensi
     * @return \Illuminate\Http\Response
     */
    public function show(JenisKompetensi $jeni)
    {
        $this->authorize('analis_sdm');
        $teknis = TeknisKompetensi::where('jenis_id', $jeni->id)->get();
        return view('analis-sdm.master-pp.teknis', [
            "jenis" => $jeni,
            "teknis" => $teknis,
            "type_menu" => 'kompetensi'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisKompetensi  $JenisKompetensi
     * @return \Illuminate\Http\Response
     */
    public function edit(JenisKompetensi $JenisKompetensi)
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

        JenisKompetensi::where('id', $id)->update([
            'nama' => $request->nama
        ]);

        $request->session()->put('status', 'Berhasil mengedit jenis kompetensi.');
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
    public function destroy(JenisKompetensi $jeni)
    {
        $this->authorize('analis_sdm');
        $jeni->delete();
        return redirect('/analis-sdm/kategori/'.$jeni->kategori_id)
                ->with('success', 'Berhasil menghapus jenis kompetensi!');
    }
}
