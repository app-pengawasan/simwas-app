<?php

namespace App\Http\Controllers;

use App\Models\Stp;
use App\Http\Requests\StoreStpRequest;
use App\Http\Requests\UpdateStpRequest;

class StpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = '';

        return view('pegawai.st-pp.index', [
            "title" => "Surat Tugas Pengembangan Profesi" . $title,
            "type_menu" => "surat-saya",
            "usulan" => Stp::latest()->where('user_id', auth()->user()->id)->filter(request(['search']))->paginate(5)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pegawai.st-pp.create', [
            "title" => "Form Surat Tugas Pengembangan Profesi",
            "type_menu" => "surat-saya"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStpRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStpRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function show(Stp $st_pp)
    {
        return view('pegawai.st-pp.show', [
            "title" => "Detail Usulan Surat Tugas Pengembangan Profesi",
            "type_menu" => "surat-saya",
            "usulan" => $st_pp
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function edit(Stp $stp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStpRequest  $request
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStpRequest $request, Stp $stp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stp $stp)
    {
        //
    }
}
