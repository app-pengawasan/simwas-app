<?php

namespace App\Http\Controllers;

use App\Models\Stpd;
use App\Http\Requests\StoreStpdRequest;
use App\Http\Requests\UpdateStpdRequest;

class StpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = '';

        return view('pegawai.stpd.stpd', [
            "title" => "Surat Tugas Perjalanan Dinas" . $title,
            "role" => "pegawai",
            // "usulan" => UsulanNomor::all()
            "usulan" => Stpd::latest()->filter(request(['search']))->paginate(5)->withQueryString()
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
     * @param  \App\Http\Requests\StoreStpdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStpdRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stpd  $stpd
     * @return \Illuminate\Http\Response
     */
    public function show(Stpd $stpd)
    {
        return view('pegawai.stpd.stpd_detail', [
            "title" => "Detail Usulan Surat Tugas Perjalanan Dinas",
            "usulan" => $stpd
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stpd  $stpd
     * @return \Illuminate\Http\Response
     */
    public function edit(Stpd $stpd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStpdRequest  $request
     * @param  \App\Models\Stpd  $stpd
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStpdRequest $request, Stpd $stpd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stpd  $stpd
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stpd $stpd)
    {
        //
    }

    public function form_stpd()
    {
        return view('pegawai.stpd.stpd_form', [
            "title" => "Form Surat Tugas Perjalanan Dinas"
        ]);
    }
}
