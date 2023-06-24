<?php

namespace App\Http\Controllers;

use App\Models\Kirim;
use App\Http\Requests\StoreKirimRequest;
use App\Http\Requests\UpdateKirimRequest;

class KirimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usulan = Kirim::all()->where('user_id', auth()->user()->id);
        return view('pegawai.kirim-dokumen.index', [
            ])->with('usulan', $usulan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pegawai.kirim-dokumen.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKirimRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKirimRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kirim  $kirim
     * @return \Illuminate\Http\Response
     */
    public function show(Kirim $kirim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kirim  $kirim
     * @return \Illuminate\Http\Response
     */
    public function edit(Kirim $kirim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKirimRequest  $request
     * @param  \App\Models\Kirim  $kirim
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKirimRequest $request, Kirim $kirim)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kirim  $kirim
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kirim $kirim)
    {
        //
    }

    public function form_kirim()
    {
        return view('pegawai.kirim.kirim_form', [
            "title" => "Kirim Dokumen"
        ]);
    }
}
