<?php

namespace App\Http\Controllers;

use App\Models\NamaPp;
use Illuminate\Http\Request;

class NamaPpController extends Controller
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
            'pp_id' => 'required',
            'is_aktif' => 'required',
            'nama' => 'required|unique:nama_pps,nama,NULL,id,pp_id,' . $request->input('pp_id'),
        ],[
            'required' => 'Wajib diisi.',
            'unique' => 'Nama PP yang dimasukkan sudah ada.'
        ]);

        NamaPp::create($validatedData);

        return redirect('/analis-sdm/pp/'.$request->input('pp_id'))->with('success', 'Berhasil menambahkan nama pengembangan profesi!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NamaPp  $namaPp
     * @return \Illuminate\Http\Response
     */
    public function show(NamaPp $namaPp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NamaPp  $namaPp
     * @return \Illuminate\Http\Response
     */
    public function edit(NamaPp $namaPp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NamaPp  $namaPp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NamaPp $namaPp)
    {
        $this->authorize('analis_sdm');
        if ($request->has('nonaktifkan')) {
            $validatedData = $request->validate([
                'is_aktif' => 'required'
            ]);
            NamaPp::where('id', $request->input('id'))->update($validatedData);
            return redirect('analis-sdm/pp/'.$request->input('pp_id'))->with('success', 'Berhasil menonaktifkan nama pengembangan profesi!');
        } elseif ($request->has('aktifkan')) {
            $validatedData = $request->validate([
                'is_aktif' => 'required'
            ]);
            NamaPp::where('id', $request->input('id'))->update($validatedData);
            return redirect('analis-sdm/pp/'.$request->input('pp_id'))->with('success', 'Berhasil mengaktifkan nama pengembangan profesi!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NamaPp  $namaPp
     * @return \Illuminate\Http\Response
     */
    public function destroy(NamaPp $namaPp)
    {
        //
    }
}
