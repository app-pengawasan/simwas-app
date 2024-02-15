<?php

namespace App\Http\Controllers;

use App\Models\UsulanSuratSrikandi;
use App\Models\SuratSrikandi;
use App\Http\Requests\StoreSuratSrikandiRequest;
use App\Http\Requests\UpdateSuratSrikandiRequest;

class SuratSrikandiController extends Controller
{
    private $pejabatPenandaTangan = [
        "8000 Inspektur Utama", "8100 Inspektur Wilayah I", "8200 Inspektur Wilayah II", "8300 Inspektur Wilayah III", "8010 Kepala Bagian Umum",
    ];

    private $jenisNaskahDinas = [
        "1031 surat tugas",
        "1032 surat perintah",
        "2011 nota dinas",
        "2012 memorandum",
        "2013 disposisi",
        "2014 surat undangan internal",
        "2021 surat dinas",
        "2022 surat undangan eksternal",
    ];

    private $jenisNaskahDinasPenugasan = [
        "1031 surat tugas",
        "1032 surat perintah",
    ];

    private $kegiatan = [
        "10. Perencanaan Pengawasan",
        "21. Audit Kinerja",
        "22. Audit Ketaatan",
        "23. Reviu",
        "24. Evaluasi",
        "25. Pemantauan",
        "26. Pendampingan",
        "27. Penguatan Pengawasan",
        "28. Evaluasi Kegiatan Pengawasan",
        "29. Evaluasi Kegiatan Pengawasan",
        "40. Pendukung Pengawasan",
    ];

    private $derajatKeamanan = [
        "B-biasa/terbuka",
        "R-rahasia",
        "T-terbatas",
    ];

    private $kodeKlasifikasiArsip = [
            "PW.110 Surat Tugas Kegiatan Audit",
            "PW.100 Surat Tugas Pengawasan Selain Audit",
            "PW.100 Surat Tugas Diklat Pengawasan",
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usulanSuratSrikandi = UsulanSuratSrikandi::latest()->get();
        foreach ($usulanSuratSrikandi as $usulan) {
            $usulan->user_name = $usulan->user->name;
        }

        foreach ($usulanSuratSrikandi as $usulan) {
            $usulan->tanggal = date('d F Y', strtotime($usulan->updated_at));
        }

        return view('sekretaris.surat-srikandi.index', [
            'type_menu' => 'surat-srikandi',
            'usulanSuratSrikandi' => $usulanSuratSrikandi,
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
     * @param  \App\Http\Requests\StoreSuratSrikandiRequest  $request
     * @return \Illuminate\Http\Response
     */
    private function acceptUsulanSurat($id, $nomorSurat)
    {
        $usulanSuratSrikandi = UsulanSuratSrikandi::findOrFail($id);
        $usulanSuratSrikandi->update([
            'status' => 'disetujui',
            'nomor_surat' => $nomorSurat,
        ]);
    }

    public function store(StoreSuratSrikandiRequest $request)
    {
        $file = $request->file('upload_word_document');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);
        $file2 = $request->file('upload_pdf_document');
        $fileName2 = time() . '_' . $file2->getClientOriginalName();
        $file2->move(public_path('uploads'), $fileName2);

        // dd($request->all());


        SuratSrikandi::create([
            'jenis_naskah_dinas_srikandi' => $request->jenisNaskahDinas,
            'tanggal_persetujuan_srikandi' => $request->tanggal_persetujuan_srikandi,
            'nomor_surat_srikandi' => $request->nomor_surat_srikandi,
            'derajat_keamanan_srikandi' => $request->derajatKeamanan,
            'kode_klasifikasi_arsip_srikandi' => $request->kodeKlasifikasiArsip,
            'perihal_srikandi' => 'Surat Srikandi',
            'kepala_unit_penandatangan_srikandi' => $request->pejabatPenandaTangan,
            'link_srikandi' => $request->link_srikandi,
            'document_srikandi_word_path' => $fileName,
            'document_srikandi_pdf_path' => $fileName2,
            'user_id' => auth()->user()->id,
            'id_usulan_surat_srikandi' => $request->usulan_surat_srikandi_id,
        ]);
        $this->acceptUsulanSurat($request->usulan_surat_srikandi_id, $request->nomor_surat_srikandi);
        return redirect()->route('surat-srikandi.index')->with('status', 'Berhasil Menambahkan Surat Srikandi!')
            ->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SuratSrikandi  $suratSrikandi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usulanSuratSrikandi = UsulanSuratSrikandi::leftJoin('surat_srikandis', 'usulan_surat_srikandis.id', '=', 'surat_srikandis.id_usulan_surat_srikandi')
        ->select('usulan_surat_srikandis.*', 'surat_srikandis.*', 'usulan_surat_srikandis.id as id', 'usulan_surat_srikandis.user_id as user_id')
        ->where('usulan_surat_srikandis.id', $id)
        ->first();
        // dd($usulanSuratSrikandi);
        $usulanSuratSrikandi->user_name = $usulanSuratSrikandi->user->name;

        return view('sekretaris.surat-srikandi.show', [
            'type_menu' => 'surat-srikandi',
            'usulanSuratSrikandi' => $usulanSuratSrikandi,
            'pejabatPenandaTangan' => $this->pejabatPenandaTangan,
            'jenisNaskahDinas' => $this->jenisNaskahDinas,
            'jenisNaskahDinasPenugasan' => $this->jenisNaskahDinasPenugasan,
            'kegiatan' => $this->kegiatan,
            'derajatKeamanan' => $this->derajatKeamanan,
            'kodeKlasifikasiArsip' => $this->kodeKlasifikasiArsip,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuratSrikandi  $suratSrikandi
     * @return \Illuminate\Http\Response
     */
    public function edit(SuratSrikandi $suratSrikandi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSuratSrikandiRequest  $request
     * @param  \App\Models\SuratSrikandi  $suratSrikandi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSuratSrikandiRequest $request, SuratSrikandi $suratSrikandi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SuratSrikandi  $suratSrikandi
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuratSrikandi $suratSrikandi)
    {
        //
    }


    public function declineUsulanSurat($id)
    {
        $request = request()->all();

        $usulanSuratSrikandi = UsulanSuratSrikandi::findOrFail($id);
        $usulanSuratSrikandi->update([
            'status' => 'ditolak',
            'catatan' => $request['alasan'],
        ]);

        return redirect()->route('surat-srikandi.index')
            ->with('alert-message', 'Usulan Surat Srikandi berhasil ditolak')
            ->with('alert-type', 'success');
    }

    public function downloadSuratSrikandi($id)
    {
        $suratSrikandi = SuratSrikandi::where('id_usulan_surat_srikandi', $id)->first();

        $file = public_path('uploads/' . $suratSrikandi->document_srikandi_pdf_path);
        return response()->download($file);
        // dd($suratSrikandi);
    }

    public function arsip()
    {
        $suratSrikandi = SuratSrikandi::latest()->get();
        foreach ($suratSrikandi as $surat) {
            $surat->user_name = $surat->user->name;
        }


        foreach ($suratSrikandi as $surat) {
            $surat->tanggal = date('d F Y', strtotime($surat->updated_at));
        }

        return view('sekretaris.arsip.index', [
            'type_menu' => 'surat-srikandi',
            'suratSrikandi' => $suratSrikandi,
        ]);
    }
}
