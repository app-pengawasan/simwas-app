<?php

namespace App\Http\Controllers;

use App\Models\Sl;
use Illuminate\Http\Request;

class NomorSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = '';

        return view('sekretaris.nomor-surat.nomor-surat', [
            "title" => "Usulan Nomor Surat" . $title,
            // "usulan" => UsulanNomor::all()
            "usulan" => Sl::latest()->filter(request(['search']))->paginate(5)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function show(Sl $sl)
    {
        return view('sekretaris.nomor-surat.nomor-surat-detail', [
            "title" => "Detail Usulan Nomor Surat",
            "usulan" => $sl
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function edit(Sl $sl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sl $sl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sl $sl)
    {
        //
    }
}
