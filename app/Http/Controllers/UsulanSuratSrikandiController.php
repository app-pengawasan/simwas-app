<?php

namespace App\Http\Controllers;

use App\Models\RencanaKerja;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use App\Models\UsulanSuratSrikandi;
use App\Models\KodeKlasifikasiArsip;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Http\Requests\StoreUsulanSuratSrikandiRequest;
use App\Http\Requests\UpdateUsulanSuratSrikandiRequest;

class UsulanSuratSrikandiController extends Controller
{

    // make array of variable to be used in the view
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
    protected $pangkat = [
        'II/a' =>	'Pengatur Muda',
        'II/b' =>	'Pengatur Muda Tingkat I',
        'II/c' => 	'Pengatur',
        'II/d' => 	'Pengatur Tingkat I',
        'III/a' =>	'Penata Muda',
        'III/b' =>	'Penata Muda Tingkat I',
        'III/c' =>	'Penata',
        'III/d' =>	'Penata Tingkat I',
        'IV/a' =>	'Pembina',
        'IV/b' =>	'Pembina Tingkat I',
        'IV/c' =>	'Pembina Muda',
        'IV/d' =>	'Pembina Madya',
        'IV/e' =>	'Pembina Utama'
    ];

    protected $unit_kerja = [
        '8000' => 'Inspektorat Utama',
        '8010' => 'Bagian Umum Inspektorat Utama',
        '8100' => 'Inspektorat Wilayah I',
        '8200' => 'Inspektorat Wilayah II',
        '8300' => 'Inspektorat Wilayah III'
    ];

    protected $jabatan = [
        '0'  => '-',
        '10' => 'Inspektur Utama',
        '11' => 'Inspektur Wilayah I',
        '12' => 'Inspektur wilayah II',
        '13' => 'Inspektur wilayah III',
        '14' => 'Kepala Bagian Umum',
        '21' =>	'Auditor Utama',
        '22' =>	'Auditor Madya',
        '23' =>	'Auditor Muda',
        '24' =>	'Auditor Pertama',
        '25' =>	'Auditor Penyelia',
        '26' =>	'Auditor Pelaksana Lanjutan',
        '27' =>	'Auditor Pelaksana',
        '31' =>	'Perencana Madya',
        '32' =>	'Perencana Muda',
        '33' =>	'Perencana Pertama',
        '41' =>	'Analis Kepegawaian Madya',
        '42' =>	'Analis Kepegawaian Muda',
        '43' =>	'Analis Kepegawaian Pertama',
        '51' =>	'Analis Pengelolaan Keuangan APBN Madya',
        '52' =>	'Analis Pengelolaan Keuangan APBN Muda',
        '53' =>	'Analis Pengelolaan Keuangan APBN Pertama',
        '61' =>	'Pranata Komputer Madya',
        '62' =>	'Pranata Komputer Muda',
        '63' =>	'Pranata Komputer Pratama',
        '71' =>	'Arsiparis Madya',
        '72' =>	'Arsiparis Muda',
        '73' =>	'Arsiparis Pertama',
        '81' =>	'Analis Hukum Madya',
        '82' =>	'Analis Hukum Muda',
        '83' =>	'Analis Hukum Pertama',
        '91' =>	'Penatalaksana Barang',
        '90' =>	'Fungsional Umum'
    ];
    protected $keterangan = [
        '1' => 'Pengendali Teknis',
        '2' => 'Ketua Tim',
        '3' => 'PIC',
        '4' => 'Anggota Tim',
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

        $allStatus = UsulanSuratSrikandi::select('status')->distinct()->get();
        $usulanSuratSrikandi = UsulanSuratSrikandi::with('user')->latest()->where('user_id', auth()->user()->id)->whereYear('created_at', $year)->where('jenis_naskah_dinas', '1031')->get();


        $year = UsulanSuratSrikandi::selectRaw('YEAR(created_at) year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();


        $currentYear = date('Y');

        $yearValues = $year->pluck('year')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['year' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('year');





        return view('pegawai.usulan-surat-srikandi.index', [
            'type_menu' => 'usulan-surat',
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
        $rencanaKerja = RencanaKerja::latest()->whereHas('pelaksana', function ($query) {
                            $query->where('id_pegawai', auth()->user()->id);
                        })->get();
        $kodeKlasifikasiArsip = KodeKlasifikasiArsip::where('is_aktif', 1)->get();
                        // dd($rencanaKerja);
        return view('pegawai.usulan-surat-srikandi.create', [
            'type_menu' => 'usulan-surat',
            'jenisNaskahDinas' => $this->jenisNaskahDinas,
            'pejabatPenandaTangan' => $this->pejabatPenandaTangan,
            'jenisNaskahDinasPenugasan' => $this->jenisNaskahDinasPenugasan,
            'jenisNaskahDinasKorespondensi' => $this->jenisNaskahDinasKorespondensi,
            'kegiatan' => $this->kegiatan,
            'derajatKeamanan' => $this->derajatKeamanan,
            'kodeKlasifikasiArsip' => $kodeKlasifikasiArsip,
            'kegiatanPengawasan' => $this->kegiatanPengawasan,
            'pendukungPengawasan' => $this->pendukungPengawasan,
            'unsurTugas' => $this->unsurTugas,
            'rencanaKerja' => $rencanaKerja,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUsulanSuratSrikandiRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function makeSurat($menimbang, $mengingat, $rencana_id, $untuk, $path_doc){
        $usulan = RencanaKerja::findOrFail($rencana_id);
        $pelaksanaTugas = $usulan->pelaksana;
        // dd($untuk);
        // replace /r/n untuk enter
        $menimbang = str_replace("\r\n", "<w:br/>", $menimbang);
        $mengingat = str_replace("\r\n", "<w:br/>", $mengingat);
        $untuk = str_replace("\r\n", "<w:br/>", $untuk);

        // Jika pelaksana tugas kurang dari sama dengan 3 orang
        if (count($pelaksanaTugas) <= 3) {
            $path_template = 'document/template-dokumen/template-surat-tugas.docx';
            $templateProcessor = new TemplateProcessor($path_template);
            $templateProcessor->setValue('menimbang', $menimbang);
            $templateProcessor->setValue('mengingat', $mengingat);
            $templateProcessor->setValue('untuk', $untuk);
            $no = 1;
            $nama = "";
            foreach ($pelaksanaTugas as $pelaksana) {
                $nama .= $no . ". " . $pelaksana->user->name . "\n";
                $no++;
            }
            $nama = str_replace("\n", "<w:br/>", $nama);
            $templateProcessor->setValue('nama', $nama);

        } else {
            $path_template = 'document/template-dokumen/template-surat-tugas-gt3.docx';
            $templateProcessor = new TemplateProcessor($path_template);
            $templateProcessor->setValue('menimbang', $menimbang);
            $templateProcessor->setValue('mengingat', $mengingat);
            $templateProcessor->setValue('untuk', $untuk);

            // duplicate row
            $templateProcessor->cloneRow('no', count($pelaksanaTugas));
            $no = 1;
            foreach ($pelaksanaTugas as $pelaksana) {
                $templateProcessor->setValue('no#' . $no, $no);
                $templateProcessor->setValue('nama#' . $no, $pelaksana->user->name);
                $templateProcessor->setValue('pangkat#' . $no, $this->pangkat[$pelaksana->user->pangkat]);
                $templateProcessor->setValue('nip#' . $no, $pelaksana->user->nip);
                $templateProcessor->setValue('jabatan#' . $no, $this->jabatan[$pelaksana->user->jabatan]);
                $templateProcessor->setValue('keterangan#' . $no, $this->keterangan[$pelaksana->pt_jabatan]);
                $no++;
            }
        }

        $path = public_path('storage/usulan-surat-srikandi/' . $path_doc);
        $fileName = time() . '-usulan-surat-srikandi.docx';
        $templateProcessor->saveAs($path . $fileName);
        // dd($path . $fileName);
        return "storage/usulan-surat-srikandi/" .   $path_doc . $fileName;
    }

    public function store(StoreUsulanSuratSrikandiRequest $request)
    {

        // dd($request->all());

        $pejabatPenandaTangan = $request->pejabatPenandaTangan;
        if ($request->file('file') != null) {
            $file = $request->file('file');
            $fileName = time() . '-usulan-surat-srikandi.' . $file->getClientOriginalExtension();
            if ($pejabatPenandaTangan == "8000") {
                $path = public_path('storage/usulan-surat-srikandi/8000-Inspektur-Utama');
                $document ='storage/usulan-surat-srikandi/8000-Inspektur-Utama/' . $fileName;
            }
            elseif ($pejabatPenandaTangan == "8100") {
                $path = public_path('storage/usulan-surat-srikandi/8100-Inspektur-Wilayah-I');
                $document ='storage/usulan-surat-srikandi/8100-Inspektur-Wilayah-I/' . $fileName;
            }
            elseif ($pejabatPenandaTangan == "8200") {
                $path = public_path('storage/usulan-surat-srikandi/8200-Inspektur-Wilayah-II');
                $document ='storage/usulan-surat-srikandi/8200-Inspektur-Wilayah-II/' . $fileName;
            }
            elseif ($pejabatPenandaTangan == "8300") {
                $path = public_path('storage/usulan-surat-srikandi/8300-Inspektur-Wilayah-III');
                $document ='storage/usulan-surat-srikandi/8300-Inspektur-Wilayah-III/' . $fileName;
            }
            elseif ($pejabatPenandaTangan == "8010") {
                $path = public_path('storage/usulan-surat-srikandi/8010-Kepala-Bagian-Umum');
                $document ='storage/usulan-surat-srikandi/8010-Kepala-Bagian-Umum/' . $fileName;
            }
            else {
                $path = public_path('storage/usulan-surat-srikandi');
            }

            $file->move($path, $fileName);
        } else if ($request->file('file') == null) {
            $path_doc = "";
            if ($pejabatPenandaTangan == "8000") {
                $path_doc = "8000-Inspektur-Utama/";
            }
            elseif ($pejabatPenandaTangan == "8100") {
                $path_doc = "8100-Inspektur-Wilayah-I/";
            }
            elseif ($pejabatPenandaTangan == "8200") {
                $path_doc = "8200-Inspektur-Wilayah-II/";
            }
            elseif ($pejabatPenandaTangan == "8300") {
                $path_doc = "8300-Inspektur-Wilayah-III/";
            }
            elseif ($pejabatPenandaTangan == "8010") {
                $path_doc = "8010-Kepala-Bagian-Umum/";
            }
            $document = $this->makeSurat($request->menimbang, $request->mengingat, $request->rencana_id, $request->untuk, $path_doc);
        }





        UsulanSuratSrikandi::create([
            'type_menu' => 'usulan-surat',
            'pejabat_penanda_tangan' => $request->pejabatPenandaTangan,
            'rencana_kerja_id' => $request->rencana_id ?? null,
            'jenis_naskah_dinas' => $request->jenisNaskahDinas,
            'jenis_naskah_dinas_penugasan' => $request->jenisNaskahDinasPenugasan,
            'derajat_keamanan' => $request->derajatKeamanan,
            'kode_klasifikasi_arsip' => $request->kodeKlasifikasiArsip,
            'melaksanakan' => $request->melaksanakan,
            'usulan_tanggal_penandatanganan' => $request->usulanTanggal,
            'directory' => $document,
            'jenis_naskah_dinas_korespondensi' => $request->jenisNaskahDinasKorespondensi,
            'perihal' => $request->perihal,
            'unsur_tugas' => $request->unsurTugas,
            'status' => 'usulan',
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('pegawai.usulan-surat-srikandi.index')->with('status', 'Berhasil Menambahkan Usulan Surat Srikandi!')
            ->with('alert-type', 'success');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UsulanSuratSrikandi  $usulanSuratSrikandi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $usulanSuratSrikandi = UsulanSuratSrikandi::findOrFail($id);
        return view('pegawai.usulan-surat-srikandi.show', [
            'type_menu' => 'usulan-surat',
            'usulanSuratSrikandi' => $usulanSuratSrikandi,
            'pejabatPenandaTangan' => $this->pejabatPenandaTangan,
            'jenisNaskahDinas' => $this->jenisNaskahDinas,
            'jenisNaskahDinasPenugasan' => $this->jenisNaskahDinasPenugasan,
            'jenisNaskahDinasKorespondensi' => $this->jenisNaskahDinasKorespondensi,
            'kegiatan' => $this->kegiatan,
            'derajatKeamanan' => $this->derajatKeamanan,
            'kegiatanPengawasan' => $this->kegiatanPengawasan,
            'pendukungPengawasan' => $this->pendukungPengawasan,
            'unsurTugas' => $this->unsurTugas,
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
        $kodeKlasifikasiArsip = KodeKlasifikasiArsip::where('is_aktif', 1)->get();

        return view('pegawai.usulan-surat-srikandi.edit', [
            'type_menu' => 'usulan-surat',
            'usulanSuratSrikandi' => $usulanSuratSrikandi,
            'jenisNaskahDinas' => $this->jenisNaskahDinas,
            'pejabatPenandaTangan' => $this->pejabatPenandaTangan,
            'jenisNaskahDinasPenugasan' => $this->jenisNaskahDinasPenugasan,
            'kegiatan' => $this->kegiatan,
            'derajatKeamanan' => $this->derajatKeamanan,
            'kodeKlasifikasiArsip' => $kodeKlasifikasiArsip,
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
        return redirect()->route('pegawai.usulan-surat-srikandi.show', $usulanSuratSrikandi->id)->with('status', 'Berhasil Mengubah Usulan Surat Srikandi!')
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
        return redirect()->route('pegawai.usulan-surat-srikandi.index')->with('status', 'Berhasil Menghapus Usulan Surat Srikandi!')
            ->with('alert-type', 'success');
    }

    public function acceptUsulanSurat($id)
    {
        $usulanSuratSrikandi = UsulanSuratSrikandi::findOrFail($id);
        $usulanSuratSrikandi->update([
            'status' => 'disetujui',
        ]);

        return redirect()->route('pegawai.surat-srikandi.index')
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

