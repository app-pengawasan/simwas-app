<?php

namespace App\Http\Controllers;

use App\Models\UsulanSuratSrikandi;
use App\Models\SuratSrikandi;
use App\Http\Requests\StoreSuratSrikandiRequest;
use App\Http\Requests\UpdateSuratSrikandiRequest;
use App\Models\KodeKlasifikasiArsip;
use Illuminate\Http\Request;

class SuratSrikandiController extends Controller
{
    private $pejabatPenandaTangan = [
        "8000" => "Inspektur Utama",
        "8100" => "Inspektur Wilayah I",
        "8200" => "Inspektur Wilayah II",
        "8300" => "Inspektur Wilayah III",
        "8010" => "Kepala Bagian Umum",
    ];

    private $jenisNaskahDinas = [
        "1031" => "Surat Tugas",
        "1032" => "Surat Korespondensi",
    ];

    private $jenisNaskahDinasKorespondensi = [
        "2011" => "Nota Dinas",
        "2012" => "Memorandum",
        "2013" => "Disposisi",
        "2014" => "Surat Undangan Internal",
        "2021" => "Surat Dinas",
        "2022" => "Surat Undangan Eksternal",
    ];

    private $jenisNaskahDinasPenugasan = [
        "1031" => "Surat Tugas",
        "1032" => "Surat Perintah",
    ];

    private $kegiatan = [
        "1" => "Pengawasan",
        "2" => "Pendukung Pengawasan",
        "3" => "Pengembangan Kompetensi",
        "4" => "Bukan Pengawasan",
    ];

    private $derajatKeamanan = [
        "B-biasa/terbuka",
        "R-rahasia",
        "T-terbatas",
    ];

    private $kegiatanPengawasan = [
            "01" => "Anggaran",
            "02" => "Pengelolaan Keuangan dan Barang",
            "03" => "Laporan Keuangan",
            "04" => "Pengendalian Internal atas Pelaporan Keuangan",
            "05" => "Penerapan Program Peningkatan Penggunaan Produksi Dalam Negeri (P3DN)",
            "06" => "Pengadaan Barang dan Jasa",
            "07" => "Pengelolaan Barang Milik Negara",
            "08" => "Liaison Officer Pemeriksaan BPK",
            "09" => "Penyelesaian Tindak lanjut Rekomendasi Pemeriksaan BPK",
            "10" => "Penyelenggaraan Statistik",
            "11" => "Tugas dan Fungsi selain penyelenggaraan statistik",
            "12" => "Teknologi Informasi",
            "13" => "Akuntabilitas Kinerja Instansi Pemerintah",
            "14" => "Laporan Kinerja",
            "15" => "Reformasi Birokrasi",
            "16" => "Kerjasama",
            "17" => "Tata Kelola",
            "18" => "Pembangunan Zona Integritas",
            "19" => "Sistem Pengendalian Internal Pemerintah",
            "20" => "Manajemen Risiko",
            "21" => "Survei Penilaian Integritas",
            "22" => "Pengaduan",
            "23" => "Pengendalian Gratifikasi",
            "24" => "Pelaporan Harta Kekayaan Aparatur Negara",
            "25" => "Pengendalian Benturan Kepentingan",
            "26" => "Layanan Konsultasi Halo Inspektorat",
            "27" => "Kapabilitas Aparat Pengawasan Intern Pemerintah",
            "28" => "Telaah Sejawat",
            "29" => "Auditor Mitra Satker",
    ];

    private $pendukungPengawasan = [
        "01" => "Pengelolaan Hasil Pengawasan",
        "02" => "Penyelesaian Regulasi Inspektorat Utama",
        "03" => "Akuntabilitas Kinerja Inspektorat Utama",
        "04" => "Anggaran dan Realisasi Keuangan",
        "05" => "Pengelolaan SDM Inspektorat Utama",
        "06" => "Pengembangan Teknologi Informasi Pengawasan",
        "07" => "Pengelolaan Arsip Inspektorat Utama",
        "08" => "Monitoring Bukti Dukung SPIP Inspektorat Utama",
        "09" => "Pengelolaan Manajemen Risiko Inspektorat Utama",
        "10" => "Aktivitas Non Pengawasan - Inspektorat Utama",
    ];

        private $unsurTugas = [
            "10" => "Perencanaan Pengawasan",
            "21" => "Audit Kepatuhan",
            "22" => "Audit Kinerja",
            "23" => "Audit ADTT",
            "24" => "Audit Investigasi",
            "25" => "Reviu",
            "26" => "Evaluasi",
            "27" => "Pemantauan",
            "28" => "Penelaahan",
            "29" => "Monitoring Tindak Lanjut Hasil Audit",
            "30" => "Monitoring Tindak Lanjut Hasil Reviu",
            "31" => "Monitoring Tindak Lanjut Hasil Evaluasi",
            "32" => "Pendampingan",
            "33" => "Sosialisasi",
            "34" => "Bimbingan Teknis",
            "71" => "Kompilasi/Evaluasi Pengawasan",
            "72" => "Telaah Sejawat",
            "91" => "Monitoring Pelaksanaan Kegiatan Pengawasan (Tim Koordinator)",
            "92" => "Pengelolaan Kegiatan Pengawasan (Tim Sekeretariat)",
        ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {
        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }
        if(auth()->user()->is_sekma){
            $usulanSuratSrikandi = UsulanSuratSrikandi::latest()->whereYear('created_at', $year)->get();
            $allStatus = UsulanSuratSrikandi::select('status')->distinct()->get();
        } else {
            $unitKerja = auth()->user()->unit_kerja;
            $usulanSuratSrikandi = UsulanSuratSrikandi::latest()->where('pejabat_penanda_tangan', $unitKerja)->whereYear('created_at', $year)->get();
            $allStatus = UsulanSuratSrikandi::select('status')->distinct()->where('pejabat_penanda_tangan', $unitKerja)->get();
        }

        foreach ($usulanSuratSrikandi as $usulan) {
            $usulan->user_name = $usulan->user->name;
        }

        foreach ($usulanSuratSrikandi as $usulan) {
            $usulan->tanggal = date('d F Y', strtotime($usulan->updated_at));
        }

        $year = UsulanSuratSrikandi::selectRaw('YEAR(created_at) year')->distinct()->orderBy('year', 'desc')->get();

        $currentYear = date('Y');

        $yearValues = $year->pluck('year')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['year' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('year');


        return view('sekretaris.surat-srikandi.index', [
            'type_menu' => 'surat-srikandi',
            'usulanSuratSrikandi' => $usulanSuratSrikandi,
            'year' => $year,
            'allStatus' => $allStatus,
            'jenisNaskahDinasKorespondensi' => $this->jenisNaskahDinasKorespondensi,
            'jenisNaskahDinasPenugasan' => $this->jenisNaskahDinasPenugasan,
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
        // dd($request->all());
        $pejabatPenandaTangan = $request->pejabat_penanda_tangan;
        $file = $request->file('upload_word_document');
        $fileName = time() . '-surat_srikandi.' . $file->getClientOriginalExtension();

        $file2 = $request->file('upload_pdf_document');
        $fileName2 = time() . '-surat_srikandi.' . $file2->getClientOriginalExtension();

        if ($pejabatPenandaTangan == "8000") {
            $path = public_path('storage/surat-srikandi/8000-Inspektur-Utama/word');
            $document ='storage/surat-srikandi/8000-Inspektur-Utama/word/' . $fileName;
            $path2 = public_path('storage/surat-srikandi/8000-Inspektur-Utama/pdf');
            $document2 ='storage/surat-srikandi/8000-Inspektur-Utama/pdf/' . $fileName2;
        }
        elseif ($pejabatPenandaTangan == "8100") {
            $path = public_path('storage/surat-srikandi/8100-Inspektur-Wilayah-I/word');
            $document ='storage/surat-srikandi/8100-Inspektur-Wilayah-I/word/' . $fileName;
            $path2 = public_path('storage/surat-srikandi/8100-Inspektur-Wilayah-I/pdf');
            $document2 ='storage/surat-srikandi/8100-Inspektur-Wilayah-I/pdf/' . $fileName2;
        }
        elseif ($pejabatPenandaTangan == "8200") {
            $path = public_path('storage/surat-srikandi/8200-Inspektur-Wilayah-II/word');
            $document ='storage/surat-srikandi/8200-Inspektur-Wilayah-II/word/' . $fileName;
            $path2 = public_path('storage/surat-srikandi/8200-Inspektur-Wilayah-II/pdf');
            $document2 ='storage/surat-srikandi/8200-Inspektur-Wilayah-II/pdf/' . $fileName2;
        }
        elseif ($pejabatPenandaTangan == "8300") {
            $path = public_path('storage/surat-srikandi/8300-Inspektur-Wilayah-III/word');
            $document ='storage/surat-srikandi/8300-Inspektur-Wilayah-III/word/' . $fileName;
            $path2 = public_path('storage/surat-srikandi/8300-Inspektur-Wilayah-III/pdf');
            $document2 ='storage/surat-srikandi/8300-Inspektur-Wilayah-III/pdf/' . $fileName2;
        }
        elseif ($pejabatPenandaTangan == "8010") {
            $path = public_path('storage/surat-srikandi/8010-Kepala-Bagian-Umum/word');
            $document ='storage/surat-srikandi/8010-Kepala-Bagian-Umum/word/' . $fileName;
            $path2 = public_path('storage/surat-srikandi/8010-Kepala-Bagian-Umum/pdf');
            $document2 ='storage/surat-srikandi/8010-Kepala-Bagian-Umum/pdf/' . $fileName2;
        }
        else {
            $path = public_path('storage/surat-srikandi');
        }

        $file->move($path, $fileName);
        $file2->move($path2, $fileName2);





        // dd($request->all());


        SuratSrikandi::create([
            'jenis_naskah_dinas_srikandi' => $request->jenisNaskahDinas,
            'tanggal_persetujuan_srikandi' => $request->tanggal_persetujuan_srikandi,
            'nomor_surat_srikandi' => $request->nomor_surat_srikandi,
            'derajat_keamanan_srikandi' => $request->derajatKeamanan,
            'kode_klasifikasi_arsip_srikandi' => $request->kodeKlasifikasiArsip,
            'perihal_srikandi' => $request->melaksanakan,
            'kepala_unit_penandatangan_srikandi' => $request->pejabatPenandaTangan,
            'link_srikandi' => $request->link_srikandi,
            'document_srikandi_word_path' => $document,
            'document_srikandi_pdf_path' => $document2,
            'user_id' => auth()->user()->id,
            'id_usulan_surat_srikandi' => $request->usulan_surat_srikandi_id,
        ]);
        $this->acceptUsulanSurat($request->usulan_surat_srikandi_id, $request->nomor_surat_srikandi);
        return redirect()->route('sekretaris.surat-srikandi.index')->with('status', 'Berhasil Menambahkan Surat Srikandi!')
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
        $usulanSuratSrikandi = UsulanSuratSrikandi::findOrFail($id);
        $kodeKlasifikasiArsip = KodeKlasifikasiArsip::where('is_aktif', 1)->get();
        return view('sekretaris.surat-srikandi.show', [
            'type_menu' => 'surat-srikandi',
            'usulanSuratSrikandi' => $usulanSuratSrikandi,
            'pejabatPenandaTangan' => $this->pejabatPenandaTangan,
            'jenisNaskahDinas' => $this->jenisNaskahDinas,
            'jenisNaskahDinasPenugasan' => $this->jenisNaskahDinasPenugasan,
            'jenisNaskahDinasKorespondensi' => $this->jenisNaskahDinasKorespondensi,
            'kegiatan' => $this->kegiatan,
            'derajatKeamanan' => $this->derajatKeamanan,
            'kodeKlasifikasiArsip' => $kodeKlasifikasiArsip,
            'kegiatanPengawasan' => $this->kegiatanPengawasan,
            'pendukungPengawasan' => $this->pendukungPengawasan,
            'unsurTugas' => $this->unsurTugas,
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
    public function update(Request $request, SuratSrikandi $suratSrikandi)
    {
        // dd($request->all());
        try {
            // dd($request->all());
$pejabatPenandaTangan = $request->pejabat_penanda_tangan;
            if ($request->hasFile('upload_word_document')) {
    $file = $request->file('upload_word_document');
    $fileName = time() . '-surat_srikandi.' . $file->getClientOriginalExtension();

    // Determine the path based on $pejabatPenandaTangan
    if ($pejabatPenandaTangan == "8000") {
        $path = public_path('storage/surat-srikandi/8000-Inspektur-Utama/word');
        $document ='storage/surat-srikandi/8000-Inspektur-Utama/word/' . $fileName;

    } elseif ($pejabatPenandaTangan == "8100") {
        $path = public_path('storage/surat-srikandi/8100-Inspektur-Wilayah-I/word');
        $document ='storage/surat-srikandi/8100-Inspektur-Wilayah-I/word/' . $fileName;
    } elseif ($pejabatPenandaTangan == "8200") {
        $path = public_path('storage/surat-srikandi/8200-Inspektur-Wilayah-II/word');
        $document ='storage/surat-srikandi/8200-Inspektur-Wilayah-II/word/' . $fileName;
    } elseif ($pejabatPenandaTangan == "8300") {
        $path = public_path('storage/surat-srikandi/8300-Inspektur-Wilayah-III/word');
        $document ='storage/surat-srikandi/8300-Inspektur-Wilayah-III/word/' . $fileName;
    } elseif ($pejabatPenandaTangan == "8010") {
        $path = public_path('storage/surat-srikandi/8010-Kepala-Bagian-Umum/word');
        $document ='storage/surat-srikandi/8010-Kepala-Bagian-Umum/word/' . $fileName;
    } else {
        $path = public_path('storage/surat-srikandi');
        $document ='storage/surat-srikandi/' . $fileName;
    }

    // Move the file to the determined path
    $file->move($path, $fileName);

    // Construct the document path
}

// Check if the 'upload_pdf_document' file exists in the request
if ($request->hasFile('upload_pdf_document')) {
    $file2 = $request->file('upload_pdf_document');
    $fileName2 = time() . '-surat_srikandi.' . $file2->getClientOriginalExtension();

    // Determine the path for the second file based on $pejabatPenandaTangan
    if ($pejabatPenandaTangan == "8000") {
        $path2 = public_path('storage/surat-srikandi/8000-Inspektur-Utama/pdf');
        $document2 ='storage/surat-srikandi/8000-Inspektur-Utama/pdf/' . $fileName2;

    } elseif ($pejabatPenandaTangan == "8100") {
        $path2 = public_path('storage/surat-srikandi/8100-Inspektur-Wilayah-I/pdf');
        $document2 ='storage/surat-srikandi/8100-Inspektur-Wilayah-I/pdf/' . $fileName2;
    } elseif ($pejabatPenandaTangan == "8200") {
        $path2 = public_path('storage/surat-srikandi/8200-Inspektur-Wilayah-II/pdf');
        $document2 ='storage/surat-srikandi/8200-Inspektur-Wilayah-II/pdf/' . $fileName2;
    } elseif ($pejabatPenandaTangan == "8300") {
        $path2 = public_path('storage/surat-srikandi/8300-Inspektur-Wilayah-III/pdf');
        $document2 ='storage/surat-srikandi/8300-Inspektur-Wilayah-III/pdf/' . $fileName2;
    } elseif ($pejabatPenandaTangan == "8010") {
        $path2 = public_path('storage/surat-srikandi/8010-Kepala-Bagian-Umum/pdf');
        $document2 ='storage/surat-srikandi/8010-Kepala-Bagian-Umum/pdf/' . $fileName2;
    } else {
        $path2 = public_path('storage/surat-srikandi');
        $document2 ='storage/surat-srikandi/' . $fileName2;
    }

    // Move the second file to the determined path
    $file2->move($path2, $fileName2);

    // Construct the second document path
}

            $suratSrikandi->update([
                'jenis_naskah_dinas_srikandi' => $request->jenisNaskahDinas,
                'tanggal_persetujuan_srikandi' => $request->tanggal_persetujuan_srikandi,
                'nomor_surat_srikandi' => $request->nomor_surat_srikandi,
                'derajat_keamanan_srikandi' => $request->derajatKeamanan,
                'kode_klasifikasi_arsip_srikandi' => $request->kodeKlasifikasiArsip,
                'perihal_srikandi' => $request->melaksanakan,
                'kepala_unit_penandatangan_srikandi' => $request->pejabatPenandaTangan,
                'link_srikandi' => $request->link_srikandi,
                'user_id' => auth()->user()->id,
                'id_usulan_surat_srikandi' => $request->usulan_surat_srikandi_id,
                'document_srikandi_word_path' => $request->hasFile('upload_word_document') ? $document : $suratSrikandi->document_srikandi_word_path,
                'document_srikandi_pdf_path' => $request->hasFile('upload_pdf_document') ? $document2 : $suratSrikandi->document_srikandi_pdf_path,
            ]);
            // update nomor surat pada usulan surat srikandi
            $usulanSuratSrikandi = UsulanSuratSrikandi::findOrFail($request->usulan_surat_srikandi_id);
            $usulanSuratSrikandi->update([
                'nomor_surat' => $request->nomor_surat_srikandi,
            ]);
            return back()->with('status', 'Berhasil Mengubah Surat Srikandi!')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('sekretaris.surat-srikandi.index')->with('status', 'Gagal Mengubah Surat Srikandi!')
                ->with('alert-type', 'danger');
        }
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

        return redirect()->route('sekretaris.surat-srikandi.index')
            ->with('alert-message', 'Usulan Surat Srikandi berhasil ditolak')
            ->with('alert-type', 'success');
    }

    public function downloadSuratSrikandi($id)
    {
        $suratSrikandi = SuratSrikandi::where('id_usulan_surat_srikandi', $id)->first();
        $file = public_path($suratSrikandi->document_srikandi_pdf_path);
        return response()->download($file);
        // dd($suratSrikandi);
    }

    public function arsip(Request $request)
    {
        $year = $request->year;
        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        if(auth()->user()->is_sekma){
            $suratSrikandi = SuratSrikandi::with('usulanSuratSrikandi.user')->whereYear('created_at', $year)->get();
        } else {
            $unitKerja = auth()->user()->unit_kerja;
            $suratSrikandi = SuratSrikandi::with('usulanSuratSrikandi.user')->whereHas('usulanSuratSrikandi', function($query) use ($unitKerja) {
                $query->where('pejabat_penanda_tangan', $unitKerja);
            })->whereYear('created_at', $year)->get();
        }


                $kodeKlasifikasiArsip = KodeKlasifikasiArsip::where('is_aktif', 1)->get();

                foreach ($suratSrikandi as $surat) {
                    $surat->tanggal = date('d F Y', strtotime($surat->updated_at));
                }
                $year = SuratSrikandi::selectRaw('YEAR(created_at) year')->distinct()->orderBy('year', 'desc')->get();

        return view('sekretaris.arsip.index', [
            'kodeKlasifikasiArsip' => $kodeKlasifikasiArsip,
            'type_menu' => 'surat-srikandi',
            'suratSrikandi' => $suratSrikandi,
            'pejabatPenandatangan' => $this->pejabatPenandaTangan,
            'year' => $year,
            'jenisNaskahDinasKorespondensi' => $this->jenisNaskahDinasKorespondensi,
            'jenisNaskahDinasPenugasan' => $this->jenisNaskahDinasPenugasan,
        ]);
    }

    public function batalSuratSrikandi($id)
    {
        try {
            // change status to dibatalkan
            $usulanSuratSrikandi = UsulanSuratSrikandi::findOrFail($id);
            $usulanSuratSrikandi->update([
                'status' => 'dibatalkan',
            ]);
            return redirect()->route('sekretaris.surat-srikandi.index')->with('status', 'Surat Srikandi berhasil dibatalkan')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('sekretaris.surat-srikandi.index')->with('status', 'Surat Srikandi gagal dibatalkan, silakan periksa data lagi')->with('alert-type', 'danger');
        }
    }
}
