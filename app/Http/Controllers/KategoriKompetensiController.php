<?php

namespace App\Http\Controllers;

use App\Models\JenisKompetensi;
use App\Models\KategoriKompetensi;
use Illuminate\Http\Request;

class KategoriKompetensiController extends Controller
{
    private $peserta = [
        '100' => 'Pengawasan (Auditor Pertama)',
        '200' => 'Pengawasan (Auditor Muda)',
        '300' => 'Pengawasan (Auditor Madya/Utama)',
        '400' => 'Pengawasan (semua jenjang)',
        '500' => 'Manajemen',
        '600' => 'Pengelolaan Keuangan dan Barang',
        '700' => 'Sumber Daya Manusia',
        '800' => 'Arsip dan Diseminasi Pengawasan',
        '900' => 'Teknologi Informasi dan Multimedia',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('analis_sdm');
        $kategori = KategoriKompetensi::all();
        return view('analis-sdm.master-pp.index', [
            "kategori" => $kategori,
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
            'nama' => 'required|unique:kategori_kompetensis'
        ],[
            'required' => 'Wajib diisi.',
            'unique' => 'Jenis PP yang dimasukkan sudah ada.'
        ]);

        KategoriKompetensi::create($validatedData);

        return redirect('/analis-sdm/kategori')->with('success', 'Berhasil menambahkan kategori kompetensi!');
    }

    public function show(KategoriKompetensi $kategori)
    {
        $this->authorize('analis_sdm');
        $jenisKomp = JenisKompetensi::where('kategori_id', $kategori->id)->get();
        return view('analis-sdm.master-pp.jenis', [
            "kategori" => $kategori,
            "jenisKomp" => $jenisKomp,
            "type_menu" => 'kompetensi'
        ]);
    }

    public function edit(KategoriKompetensi $pp)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->authorize('analis_sdm');
        
        KategoriKompetensi::where('id', $id)->update([
            'nama' => $request->nama
        ]);

        $request->session()->put('status', 'Berhasil mengedit kategori kompetensi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui'
        ]);
    }

    public function destroy(KategoriKompetensi $kategori)
    {
        $this->authorize('analis_sdm');
        $kategori->delete();
        return redirect('/analis-sdm/kategori')
                ->with('success', 'Berhasil menghapus kategori kompetensi!');
    }
}
