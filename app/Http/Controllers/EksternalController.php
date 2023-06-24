<?php

namespace App\Http\Controllers;

use App\Models\Eksternal;
use App\Http\Requests\StoreEksternalRequest;
use App\Http\Requests\UpdateEksternalRequest;

class EksternalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = '';

        return view('pegawai.eksternal.eksternal', [
            "title" => "Surat Lain" . $title,
            "role" => "pegawai",
            // "usulan" => UsulanNomor::all()
            "usulan" => Eksternal::latest()->filter(request(['search']))->paginate(5)->withQueryString()
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
     * @param  \App\Http\Requests\StoreEksternalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEksternalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Eksternal  $eksternal
     * @return \Illuminate\Http\Response
     */
    public function show(Eksternal $eksternal)
    {
        return view('pegawai.eksternal.eksternal_detail', [
            "title" => "Detail Usulan Surat Lain",
            "usulan" => $eksternal
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Eksternal  $eksternal
     * @return \Illuminate\Http\Response
     */
    public function edit(Eksternal $eksternal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEksternalRequest  $request
     * @param  \App\Models\Eksternal  $eksternal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEksternalRequest $request, Eksternal $eksternal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Eksternal  $eksternal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Eksternal $eksternal)
    {
        //
    }

    public function form_eksternal()
    {
        return view('pegawai.eksternal.eksternal_form', [
            "title" => "Form Surat Eksternal"
        ]);
    }
}
