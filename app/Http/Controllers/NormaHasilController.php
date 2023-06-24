<?php

namespace App\Http\Controllers;

use App\Models\NormaHasil;
use App\Http\Requests\StoreNormaHasilRequest;
use App\Http\Requests\UpdateNormaHasilRequest;
use App\Models\StKinerja;
use Illuminate\Support\Facades\Storage;

class NormaHasilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usulan = NormaHasil::latest()->where('user_id', auth()->user()->id)->get();
        return view('pegawai.norma-hasil.index')->with('usulan', $usulan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stks = StKinerja::latest()->where('user_id', auth()->user()->id)->where('status', 5)->get();
        return view('pegawai.norma-hasil.create', [
            "stks" => $stks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNormaHasilRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNormaHasilRequest $request)
    {
        $validatedData = $request->validate([
            'is_backdate' => 'required',
            'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
            'st_kinerja_id' => 'required',
            'hal' => 'required',
            'draft' => 'required|mimes:doc,docx',
            'status' => 'required'
        ], [
            'required' => 'Wajib diisi',
            'mimes' => "File yang diupload harus bertipe .doc atau .docx"
        ]);
        $stk = StKinerja::find($validatedData['st_kinerja_id']);
        $validatedData['unit_kerja'] = $stk->unit_kerja;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['draft'] = $request->file('draft')->store('draft');
        NormaHasil::create($validatedData);

        return redirect('pegawai/norma-hasil')->with('success', 'Berhasil mengajukan usulan norma hasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function show(NormaHasil $norma_hasil)
    {
        return view('pegawai.norma-hasil.show', [
            "usulan" => $norma_hasil
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function edit(NormaHasil $norma_hasil)
    {
        $stks = StKinerja::latest()->where('user_id', auth()->user()->id)->where('status', 5)->get();
        return view('pegawai.norma-hasil.edit', [
            "usulan" => $norma_hasil,
            "stks" => $stks
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNormaHasilRequest  $request
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNormaHasilRequest $request, NormaHasil $norma_hasil)
    {
        if ($request->input('status') == '0') {
            $validatedData = $request->validate([
                'is_backdate' => 'required',
                'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
                'st_kinerja_id' => 'required',
                'hal' => 'required',
                'draft' => 'required|mimes:doc,docx',
                'status' => 'required'
            ], [
                'required' => 'Wajib diisi',
                'mimes' => "File yang diupload harus bertipe .doc atau .docx"
            ]);
            $stk = StKinerja::find($validatedData['st_kinerja_id']);
            $validatedData['unit_kerja'] = $stk->unit_kerja;
            $validatedData['draft'] = $request->file('draft')->store('draft');
            NormaHasil::where('id', $norma_hasil->id)->update($validatedData);
    
            return redirect('pegawai/norma-hasil')->with('success', 'Berhasil mengajukan kembali usulan norma hasil!');
        } elseif ($request->input('status') == '3') {
            $validatedData = $request->validate([
                'status' => 'required',
                'id' => 'required',
                'surat' => 'required|mimes:pdf'
            ], [
                'required' => 'Wajib diisi',
                'mimes' => 'File yang diupload harus bertipe .pdf'
            ]);
            if ($norma_hasil->surat) {
                Storage::delete($norma_hasil->surat);
            }
            $validatedData['surat'] = '/storage'.'/'.$request->file('surat')->store('norma-hasil');
            NormaHasil::where('id', $request->input('id'))->update($validatedData);
            return redirect('/pegawai/norma-hasil')->with('success', 'Berhasil mengunggah file!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function destroy(NormaHasil $normaHasil)
    {
        //
    }
}
