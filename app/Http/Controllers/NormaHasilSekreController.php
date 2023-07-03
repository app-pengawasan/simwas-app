<?php

namespace App\Http\Controllers;

use App\Models\NormaHasil;
use App\Models\RencanaKerja;
use App\Models\StKinerja;
use App\Models\Surat;
use Illuminate\Http\Request;

class NormaHasilSekreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('sekretaris');
        if (auth()->user()->is_sekma) {
            $usulan = NormaHasil::latest()->get();
        } else {
            $usulan = NormaHasil::latest()->where('unit_kerja', auth()->user()->unit_kerja)->get();
        }
        return view('sekretaris.norma-hasil.index', [
        ])->with('usulan', $usulan);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function show(NormaHasil $norma_hasil)
    {
        $this->authorize('sekretaris');
        return view('sekretaris.norma-hasil.show', [
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
        $this->authorize('sekretaris');
        $stks = StKinerja::latest()->where('user_id', auth()->user()->id)->where('status', 5)->get();
        return view('sekretaris.norma-hasil.edit', [
            "usulan" => $norma_hasil,
            "stks" => $stks
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NormaHasil $norma_hasil)
    {
        $this->authorize('sekretaris');
        if ($request->input('status') == '1' || $request->input('status') == '4') {
            $validatedData = $request->validate([
                'catatan' => 'required'
            ],[
                'required' => 'Wajib diisi'
            ]);
            $validatedData['status'] = $request->input('status');
            NormaHasil::where('id', $request->input('id'))->update($validatedData);
            return redirect('sekretaris/norma-hasil')->with('success', 'Berhasil menolak usulan!');
        } elseif ($request->input('status') == '2') {
            if ($request->has('edit')) {
                $usulan = NormaHasil::find($request->input('id'));
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
                NormaHasil::where('id', $request->input('id'))->update($validatedData);
            }
            $usulan = NormaHasil::find($request->input('id'));
            $tanggal = ($usulan->is_backdate == '0') ? date('Y-m-d') : $usulan->tanggal;
            $data = new Request();
            $data->merge([
                'user_id' => $usulan->user_id,
                'derajat_klasifikasi' => 'R',
                'nomor_organisasi' => $usulan->unit_kerja,
                'kka' => 'PW.120',
                'tanggal' => $tanggal,
                'jenis' => 'Norma Hasil',
                'is_backdate' => $usulan->is_backdate
            ]);
            $buatSurat = new SuratController();
            $buatSurat->store($data);
            $nomorSurat = Surat::latest()->first()->nomor_surat;
            $validatedData = ([
                'status' => '2',
                'no_surat' => $nomorSurat,
                'tanggal' => $tanggal
            ]);
            RencanaKerja::where('id_rencanakerja', $usulan->rencanaKerja->id_rencanakerja)->update(['status' => '2']);
            NormaHasil::where('id', $request->input('id'))->update($validatedData);
            return redirect('sekretaris/norma-hasil')->with('success', 'Berhasil menyetujui usulan nomor surat!');
        } elseif ($request->input('status') == '5') {
            $validatedData = $request->validate([
                'status' => 'required'
            ]);
            NormaHasil::where('id', $request->input('id'))->update($validatedData);
            Surat::where('nomor_surat', $norma_hasil->no_surat)->update(['file' => $norma_hasil->surat]);
            return redirect('sekretaris/norma-hasil')->with('success', 'Berhasil menyetujui norma hasil!');
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
