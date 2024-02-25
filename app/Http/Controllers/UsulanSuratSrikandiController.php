<?php

namespace App\Http\Controllers;

use App\Models\UsulanSuratSrikandi;
use App\Http\Requests\StoreUsulanSuratSrikandiRequest;
use App\Http\Requests\UpdateUsulanSuratSrikandiRequest;
use Illuminate\Http\Request;
class UsulanSuratSrikandiController extends Controller
{

    // make array of variable to be used in the view
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
        $year = request('year');
        // get parameter from url
       if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }
        $usulanSuratSrikandi = UsulanSuratSrikandi::with('user')->latest()->where('user_id', auth()->user()->id)->whereYear('created_at', $year)->get();
        // dd($usulanSuratSrikandi);
        return view('pegawai.usulan-surat-srikandi.index', [
            'type_menu' => 'usulan-surat-srikandi',
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
        return view('pegawai.usulan-surat-srikandi.create', [
            'type_menu' => 'usulan-surat-srikandi',
            'jenisNaskahDinas' => $this->jenisNaskahDinas,
            'pejabatPenandaTangan' => $this->pejabatPenandaTangan,
            'jenisNaskahDinasPenugasan' => $this->jenisNaskahDinasPenugasan,
            'kegiatan' => $this->kegiatan,
            'derajatKeamanan' => $this->derajatKeamanan,
            'kodeKlasifikasiArsip' => $this->kodeKlasifikasiArsip,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUsulanSuratSrikandiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsulanSuratSrikandiRequest $request)
    {

        $file = $request->file('file');
        $fileName = time() . '-usulan-surat-srikandi.' . $file->getClientOriginalExtension();
        $pejabatPenandaTangan = $request->pejabatPenandaTangan;
        if ($pejabatPenandaTangan == "8000 Inspektur Utama") {
            $path = public_path('storage/usulan-surat-srikandi/8000-Inspektur-Utama');
            $document ='storage/usulan-surat-srikandi/8000-Inspektur-Utama/' . $fileName;
        }
        elseif ($pejabatPenandaTangan == "8100 Inspektur Wilayah I") {
            $path = public_path('storage/usulan-surat-srikandi/8100-Inspektur-Wilayah-I');
            $document ='storage/usulan-surat-srikandi/8100-Inspektur-Wilayah-I/' . $fileName;
        }
        elseif ($pejabatPenandaTangan == "8200 Inspektur Wilayah II") {
            $path = public_path('storage/usulan-surat-srikandi/8200-Inspektur-Wilayah-II');
            $document ='storage/usulan-surat-srikandi/8200-Inspektur-Wilayah-II/' . $fileName;
        }
        elseif ($pejabatPenandaTangan == "8300 Inspektur Wilayah III") {
            $path = public_path('storage/usulan-surat-srikandi/8300-Inspektur-Wilayah-III');
            $document ='storage/usulan-surat-srikandi/8300-Inspektur-Wilayah-III/' . $fileName;
        }
        elseif ($pejabatPenandaTangan == "8010 Kepala Bagian Umum") {
            $path = public_path('storage/usulan-surat-srikandi/8010-Kepala-Bagian-Umum');
            $document ='storage/usulan-surat-srikandi/8010-Kepala-Bagian-Umum/' . $fileName;
        }
        else {
            $path = public_path('storage/usulan-surat-srikandi');
        }

        $file->move($path, $fileName);





        UsulanSuratSrikandi::create([
            'pejabat_penanda_tangan' => $request->pejabatPenandaTangan,
            'jenis_naskah_dinas' => $request->jenisNaskahDinas,
            'jenis_naskah_dinas_penugasan' => $request->jenisNaskahDinasPenugasan,
            'kegiatan' => $request->kegiatan,
            'derajat_keamanan' => $request->derajatKeamanan,
            'kode_klasifikasi_arsip' => $request->kodeKlasifikasiArsip,
            'melaksanakan' => $request->melaksanakan,
            'usulan_tanggal_penandatanganan' => $request->usulanTanggal,
            'directory' => $document,
            'status' => 'usulan',
            'catatan' => 'catatan',
            'user_id' => auth()->user()->id,
            'nomor_surat' => 'belum',
        ]);

        return redirect()->route('usulan-surat-srikandi.index')->with('status', 'Berhasil Menambahkan Usulan Surat Srikandi!')
            ->with('alert-type', 'success');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UsulanSuratSrikandi  $usulanSuratSrikandi
     * @return \Illuminate\Http\Response
     */
    public function show(UsulanSuratSrikandi $usulanSuratSrikandi)
    {
        // left join usulan_surat_srikandi and surat_srikandi
        $usulanSuratSrikandi = UsulanSuratSrikandi::leftJoin('surat_srikandis', 'usulan_surat_srikandis.id', '=', 'surat_srikandis.id_usulan_surat_srikandi')
        ->select('usulan_surat_srikandis.*', 'surat_srikandis.*', 'usulan_surat_srikandis.id as id')
        ->where('usulan_surat_srikandis.id', $usulanSuratSrikandi->id)
        ->first();
            // dd($usulanSuratSrikandi);
        return view('pegawai.usulan-surat-srikandi.show', [
            'type_menu' => 'usulan-surat-srikandi',
            'usulanSuratSrikandi' => $usulanSuratSrikandi,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UsulanSuratSrikandi  $usulanSuratSrikandi
     * @return \Illuminate\Http\Response
     */
    public function edit(UsulanSuratSrikandi $usulanSuratSrikandi)
    {
        return view('pegawai.usulan-surat-srikandi.edit', [
            'type_menu' => 'usulan-surat-srikandi',
            'usulanSuratSrikandi' => $usulanSuratSrikandi,
            'jenisNaskahDinas' => $this->jenisNaskahDinas,
            'pejabatPenandaTangan' => $this->pejabatPenandaTangan,
            'jenisNaskahDinasPenugasan' => $this->jenisNaskahDinasPenugasan,
            'kegiatan' => $this->kegiatan,
            'derajatKeamanan' => $this->derajatKeamanan,
            'kodeKlasifikasiArsip' => $this->kodeKlasifikasiArsip,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUsulanSuratSrikandiRequest  $request
     * @param  \App\Models\UsulanSuratSrikandi  $usulanSuratSrikandi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsulanSuratSrikandiRequest $request, UsulanSuratSrikandi $usulanSuratSrikandi)
    {
        $usulanSuratSrikandi->update([
            'pejabat_penanda_tangan' => $request->pejabatPenandaTangan,
            'jenis_naskah_dinas' => $request->jenisNaskahDinas,
            'jenis_naskah_dinas_penugasan' => $request->jenisNaskahDinasPenugasan,
            'kegiatan' => $request->kegiatan,
            'derajat_keamanan' => $request->derajatKeamanan,
            'kode_klasifikasi_arsip' => $request->kodeKlasifikasiArsip,
            'melaksanakan' => $request->melaksanakan,
            'usulan_tanggal_penandatanganan' => $request->usulanTanggal,
            'status' => 'usulan',
            'catatan' => 'catatan',
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('usulan-surat-srikandi.show', $usulanSuratSrikandi->id)->with('status', 'Berhasil Mengubah Usulan Surat Srikandi!')
            ->with('alert-type', 'success');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UsulanSuratSrikandi  $usulanSuratSrikandi
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsulanSuratSrikandi $usulanSuratSrikandi)
    {
        $usulanSuratSrikandi->delete();
        return redirect()->route('usulan-surat-srikandi.index')->with('status', 'Berhasil Menghapus Usulan Surat Srikandi!')
            ->with('alert-type', 'success');
    }

    public function acceptUsulanSurat($id)
    {
        $usulanSuratSrikandi = UsulanSuratSrikandi::findOrFail($id);
        $usulanSuratSrikandi->update([
            'status' => 'disetujui',
        ]);

        return redirect()->route('surat-srikandi.index')
            ->with('alert-message', 'Usulan Surat Srikandi berhasil disetujui')
            ->with('alert-type', 'success');
    }
    public function downloadUsulanSurat($id)
    {
        $usulanSuratSrikandi = UsulanSuratSrikandi::findOrFail($id);
        $file = public_path($usulanSuratSrikandi->directory);
        return response()->download($file);
    }
}

