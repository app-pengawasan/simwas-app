<?php

namespace App\Http\Controllers;

use App\Models\TimKerja;
use Illuminate\Http\Request;

class TimKerjaController extends Controller
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
        $rules = [
            'nama'      => 'required',
            'unitkerja' => 'required',
            'id_iku'    => 'required',
            'id_ketua'  => 'required',
            'tahun'     => 'required',
        ];

        // return $request;

        $validateData = $request->validate($rules);

        TimKerja::create($validateData);

        return redirect('/admin/rencana-kinerja')->with('success', 'Berhasil menambah Tim Kerja.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimKerja  $timKerja
     * @return \Illuminate\Http\Response
     */
    public function show(TimKerja $timKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimKerja  $timKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(TimKerja $timKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimKerja  $timKerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimKerja $timKerja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimKerja  $timKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimKerja $timKerja)
    {
        //
    }
}
