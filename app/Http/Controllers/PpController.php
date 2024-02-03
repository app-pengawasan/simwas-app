<?php

namespace App\Http\Controllers;

use App\Models\NamaPp;
use App\Models\Pp;
use Illuminate\Http\Request;

class PpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('analis_sdm');
        $pps = Pp::all()->where('is_aktif', true);
        return view('analis-sdm.master-pp.index', [
            "pps" => $pps,
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
            'is_aktif' => 'required',
            'jenis' => 'required|unique:pps'
        ],[
            'required' => 'Wajib diisi.',
            'unique' => 'Jenis PP yang dimasukkan sudah ada.'
        ]);

        Pp::create($validatedData);

        return redirect('/analis-sdm/pp')->with('success', 'Berhasil menambahkan jenis pengembangan profesi!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pp  $pp
     * @return \Illuminate\Http\Response
     */
    public function show(Pp $pp)
    {
        $this->authorize('analis_sdm');
        $namaPps = NamaPp::where('pp_id', $pp->id)->get();
        return view('analis-sdm.master-pp.show', [
            "pp" => $pp,
            "namaPps" => $namaPps
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pp  $pp
     * @return \Illuminate\Http\Response
     */
    public function edit(Pp $pp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pp  $pp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pp $pp)
    {
        $this->authorize('analis_sdm');
        if ($request->has('nonaktifkan')) {
            $validatedData = $request->validate([
                'is_aktif' => 'required'
            ]);
            Pp::where('id', $request->input('id'))->update($validatedData);
            return redirect('analis-sdm/pp')->with('success', 'Berhasil menonaktifkan pengembangan profesi!');
        } elseif ($request->has('aktifkan')) {
            $validatedData = $request->validate([
                'is_aktif' => 'required'
            ]);
            Pp::where('id', $request->input('id'))->update($validatedData);
            return redirect('analis-sdm/pp')->with('success', 'Berhasil mengaktifkan pengembangan profesi!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pp  $pp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pp $pp)
    {
        //
    }

    function ppNonaktif() {
        $this->authorize('analis_sdm');
        $pps = Pp::all()->where('is_aktif', false);
        return view('analis-sdm.master-pp.pp-nonaktif', [
            "pps" => $pps,
            "type_menu" => 'kompetensi'
        ]);
    }
}
