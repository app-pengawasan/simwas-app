<?php

namespace App\Http\Controllers;

use App\Models\StKinerja;
use App\Models\Surat;
use App\Models\User;
use App\Models\MasterPimpinan;
use App\Models\ObjekPengawasan;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Settings;
use Dompdf\Dompdf;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use App\Models\RencanaKerja;
use Illuminate\Support\Facades\Storage;
use TCPDF;

class InspekturStKinerjaController extends Controller
{
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

    protected $role = [
        'is_admin'      => 'Admin',
        'is_sekma'      => 'Sekretaris Utama',
        'is_sekwil'     => 'Sekretaris Wilayah',
        'is_perencana'  => 'Perencana',
        'is_apkapbn'    => 'APK-APBN',
        'is_opwil'      => 'Operator Wilayah',
        'is_analissdm'  => 'Analis SDM'
    ];

    protected $jabatan_pimpinan = [
        'jpm000'      => 'Inspektur Utama',
        'jpm001'      => 'Inspektur Wilayah I',
        'jpm002'      => 'Inspektur Wilayah II',
        'jpm003'      => 'Inspektur Wilayah III',
        'jpm004'      => 'Kepala Bagian Umum'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('inspektur');
        if ((auth()->user()->is_aktif) && (auth()->user()->unit_kerja == '8000') ) {
            $usulan = StKinerja::latest()->get();
        } else {
            // $usulan = StKinerja::latest()->where('unit_kerja', auth()->user()->unit_kerja)->get();
            $usulan = StKinerja::latest()->whereHas('rencanaKerja.proyek.timkerja', function ($query) {
                $query->where('unitkerja', auth()->user()->unit_kerja);
            })->get();
        }
        return view('inspektur.st-kinerja.index', [
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
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function show(StKinerja $stKinerja)
    {
        $this->authorize('inspektur');
        $anggotaArray = explode(', ', $stKinerja->anggota);
        $users = \App\Models\User::whereIn('id', $anggotaArray)->get();
        $nama = $users->pluck('name')->toArray();
        $anggota = implode(', ', $nama);
        return view('inspektur.st-kinerja.show', [
            "usulan" => $stKinerja,
            "anggota" => $anggota,
            "jabatan_pimpinan" =>$this->jabatan_pimpinan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function edit(StKinerja $st_kinerja)
    {
        $this->authorize('inspektur');
        $rencana_kerja = RencanaKerja::latest()->whereHas('timkerja', function ($query) {
            $query->whereIn('status', [1,2]);
        })->whereHas('pelaksana', function ($query) {
            $query->where('id_pegawai', auth()->user()->id)
                ->whereIn('pt_jabatan', [2, 3]);
        })->get();
        $objPengawasan = ObjekPengawasan::all();
        $pimpinanAktif = MasterPimpinan::latest()->whereDate('selesai', '>=', date('Y-m-d'))->get();
        $pimpinanNonaktif = MasterPimpinan::latest()->whereDate('selesai', '<', date('Y-m-d'))->get();
        $user = User::all();
        return view('inspektur.st-kinerja.edit', [
            "usulan" => $st_kinerja,
            "rencana_kerja" => $rencana_kerja,
            "user" => $user,
            "pimpinanAktif" => $pimpinanAktif,
            "pimpinanNonaktif" => $pimpinanNonaktif,
            "jabatan_pimpinan" => $this->jabatan_pimpinan,
            "objPengawasan" => $objPengawasan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StKinerja $st_kinerja)
    {
        $this->authorize('inspektur');
        if ($request->input('status') == '1' || $request->input('status') == '4') {
            $validatedData = $request->validate([
                'catatan' => 'required'
            ],[
                'required' => 'Wajib diisi'
            ]);
            $validatedData['status'] = $request->input('status');
            StKinerja::where('id', $request->input('id'))->update($validatedData);
            return redirect('inspektur/st-kinerja')->with('success', 'Berhasil menolak usulan surat!');
        } elseif ($request->input('status') == '2') {
            if ($request->has('edit')) {
                $validatedData = $request->validate([
                    'is_backdate' => 'required',
                    'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
                    'rencana_id' => 'required',
                    'melaksanakan' => 'required',
                    'mulai' => $request->input('is_backdate') === '1' ? 'required|date|after_or_equal:tanggal' : 'required|date|after_or_equal:today' ,
                    'selesai' => 'required|date|after_or_equal:mulai',
                    'penandatangan' => 'required',
                    'status' => 'required',
                    'is_esign' => 'required',
                ],[
                    'selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan waktu mulai.',
                    'mulai.after_or_equal' => 'Tanggal mulai harus setelah atau sama dengan hari ini/tanggal surat',
                    'required' => 'Wajib diisi.'
                ]);

                StKinerja::where('id', $request->input('id'))->update($validatedData);
            }
            $usulan = StKinerja::find($request->input('id'));
            $data = new Request();
            $tanggal = ($usulan->is_backdate == '0') ? date('Y-m-d') : $usulan->tanggal;
            $data->merge([
                'user_id' => $usulan->user_id,
                'derajat_klasifikasi' => 'B',
                'nomor_organisasi' => $usulan->rencanaKerja->timkerja->unitkerja,
                'kka' => 'PW.110',
                'tanggal' => $tanggal,
                'jenis' => 'ST Kinerja',
                'is_backdate' => $usulan->is_backdate
            ]);
            $buatSurat = new SuratController();
            $buatSurat->store($data);
            $nomorSurat = Surat::latest()->first()->nomor_surat;

            // Path untuk menyimpan hasil dokumen
            $tempFilePath = 'storage/temp/temp_file.docx';
            $outputPath = 'st-kinerja'.'/'.$usulan->id.'-draft.docx';

            // Ambil pelaksana dan objek
            $objek_pengawasan = $usulan->rencanaKerja->objekPengawasan;
            $obj = [];
            foreach ($objek_pengawasan as $op) {
                $obj[] = $op->nama;
            }
            $objekGabung = implode(', ', $obj);
            $pelaksana_tugas = $usulan->rencanaKerja->pelaksana;
            $pimpinan = MasterPimpinan::find($usulan->penandatangan);
            // Pembuatan surat
            if (count($pelaksana_tugas) == 1) {
                $surat = Surat::where('nomor_surat', $nomorSurat)->first();
                if ($pelaksana_tugas->id_pegawai != $surat->user_id) {
                    $newSurat = $surat->replicate();
                    $newSurat->user_id = $pelaksana_tugas->id_pegawai;
                    $newSurat->save();
                }
                if ($usulan->is_esign) {
                    // Path ke template dokumen .docx
                    $stkPerseoranganPath = 'document/template-dokumen/draft-st-kinerja-perorangan-esign.docx';

                    // Inisialisasi TemplateProcessor dengan template dokumen
                    $templateProcessor = new TemplateProcessor($stkPerseoranganPath);

                    $templateProcessor->setValues([
                        'no_surat' => $nomorSurat,
                        'nama' => $pelaksana_tugas->user->name,
                        'pangkat' => $this->pangkat[$pelaksana_tugas->user->pangkat],
                        'nip' => $pelaksana_tugas->user->nip,
                        'jabatan' => $this->jabatan[$pelaksana_tugas->user->jabatan],
                        'melaksanakan' => $usulan->melaksanakan,
                        'mulaiSelesai' => $this->konvTanggalIndo($usulan->mulai).' - '.$this->konvTanggalIndo($usulan->selesai),
                        'objek' => $objekGabung,
                        'tanggal' => $this->konvTanggalIndo($tanggal),
                        'roleInspektur' => $this->jabatan_pimpinan[$pimpinan->jabatan],
                        'inspektur' => $pimpinan->user->name
                    ]);

                    // Simpan dokumen hasil
                    $templateProcessor->saveAs('storage/'.$outputPath);


                } else {
                    // Path ke template dokumen .docx
                    $stkPerseoranganPath = 'document/template-dokumen/draft-st-kinerja-perorangan-nonesign.docx';

                    // Inisialisasi TemplateProcessor dengan template dokumen
                    $templateProcessor = new TemplateProcessor($stkPerseoranganPath);
                    $templateProcessor->setValues([
                        'no_surat' => $nomorSurat,
                        'nama' => $pelaksana_tugas->user->name,
                        'pangkat' => $this->pangkat[$pelaksana_tugas->user->pangkat],
                        'nip' => $pelaksana_tugas->user->nip,
                        'jabatan' => $this->jabatan[$pelaksana_tugas->user->jabatan],
                        'melaksanakan' => $usulan->melaksanakan,
                        'mulaiSelesai' => $this->konvTanggalIndo($usulan->mulai).' - '.$this->konvTanggalIndo($usulan->selesai),
                        'objek' => $objekGabung,
                        'tanggal' => $this->konvTanggalIndo($tanggal),
                        'roleInspektur' => $this->jabatan_pimpinan[$pimpinan->jabatan],
                        'inspektur' => $pimpinan->user->name
                    ]);

                    // Simpan dokumen hasil
                    $templateProcessor->saveAs('storage/'.$outputPath);
                }

            } else {
                $surat = Surat::where('nomor_surat', $nomorSurat)->first();

                // Ambil anggota
                $anggotaArray = explode(', ', $usulan->anggota);
                $users = \App\Models\User::whereIn('id', $anggotaArray)->get();

                $values = [];
                $i = 0;
                // Ambil dalnis
                foreach ($pelaksana_tugas as $pel) {
                    if ($pel->pt_jabatan == 1 ) {
                        $i++;
                        $values[] = ['no' => $i, 'nama' => $pel->user->name, 'pangkat' => $this->pangkat[$pel->user->pangkat], 'nip' => $pel->user->nip, 'jabatan' => $this->jabatan[$pel->user->jabatan], 'keterangan' => 'Pengendali Teknis'];
                        if ($pel->id_pegawai != $surat->user_id) {
                            $newSurat = $surat->replicate();
                            $newSurat->user_id = $pel->id_pegawai;
                            $newSurat->save();
                        }
                        break;
                    }
                }
                foreach ($pelaksana_tugas as $pel) {
                    if ($pel->pt_jabatan == 2 ) {
                        $i++;
                        $values[] = ['no' => $i, 'nama' => $pel->user->name, 'pangkat' => $this->pangkat[$pel->user->pangkat], 'nip' => $pel->user->nip, 'jabatan' => $this->jabatan[$pel->user->jabatan], 'keterangan' => 'Ketua Tim'];
                        if ($pel->id_pegawai != $surat->user_id) {
                            $newSurat = $surat->replicate();
                            $newSurat->user_id = $pel->id_pegawai;
                            $newSurat->save();
                        }
                        break;
                    }
                }
                foreach ($pelaksana_tugas as $pel) {
                    if ($pel->pt_jabatan == 3 ) {
                        $i++;
                        $values[] = ['no' => $i, 'nama' => $pel->user->name, 'pangkat' => $this->pangkat[$pel->user->pangkat], 'nip' => $pel->user->nip, 'jabatan' => $this->jabatan[$pel->user->jabatan], 'keterangan' => 'PIC'];
                        if ($pel->id_pegawai != $surat->user_id) {
                            $newSurat = $surat->replicate();
                            $newSurat->user_id = $pel->id_pegawai;
                            $newSurat->save();
                        }
                        break;
                    }
                }
                foreach ($pelaksana_tugas as $pel) {
                    if ($pel->pt_jabatan == 4 ) {
                        $i++;
                        $values[] = ['no' => $i, 'nama' => $pel->user->name, 'pangkat' => $this->pangkat[$pel->user->pangkat], 'nip' => $pel->user->nip, 'jabatan' => $this->jabatan[$pel->user->jabatan], 'keterangan' => 'Anggota'];
                        if ($pel->id_pegawai != $surat->user_id) {
                            $newSurat = $surat->replicate();
                            $newSurat->user_id = $pel->id_pegawai;
                            $newSurat->save();
                        }
                    }
                }

                if ($usulan->is_esign) {
                    // Path ke template dokumen .docx
                    $stkKolektifPath = 'document/template-dokumen/draft-st-kinerja-kolektif-esign.docx';

                    // Inisialisasi TemplateProcessor dengan template dokumen
                    $templateProcessor = new TemplateProcessor($stkKolektifPath);

                    $templateProcessor->cloneRowAndSetValues('no', $values);

                    $pimpinan = MasterPimpinan::find($usulan->penandatangan);
                    $templateProcessor->setValues([
                        'no_surat' => $nomorSurat,
                        'melaksanakan' => $usulan->melaksanakan,
                        'mulaiSelesai' => $this->konvTanggalIndo($usulan->mulai).' - '.$this->konvTanggalIndo($usulan->selesai),
                        'objek' => $objekGabung,
                        'tanggal' => $this->konvTanggalIndo($tanggal),
                        'roleInspektur' => $this->jabatan_pimpinan[$pimpinan->jabatan],
                        'inspektur' => $pimpinan->user->name
                    ]);

                    // Simpan dokumen hasil
                    $templateProcessor->saveAs('storage/'.$outputPath);
                } else {
                    // Path ke template dokumen .docx
                    $stkKolektifPath = 'document/template-dokumen/draft-st-kinerja-kolektif-nonesign.docx';

                    // Inisialisasi TemplateProcessor dengan template dokumen
                    $templateProcessor = new TemplateProcessor($stkKolektifPath);

                    $templateProcessor->cloneRowAndSetValues('no', $values);

                    $templateProcessor->setValues([
                        'no_surat' => $nomorSurat,
                        'melaksanakan' => $usulan->melaksanakan,
                        'mulaiSelesai' => $this->konvTanggalIndo($usulan->mulai).' - '.$this->konvTanggalIndo($usulan->selesai),
                        'objek' => $objekGabung,
                        'tanggal' => $this->konvTanggalIndo($tanggal),
                        'roleInspektur' => $this->jabatan_pimpinan[$pimpinan->jabatan],
                        'inspektur' => $pimpinan->user->name
                    ]);

                    // Simpan dokumen hasil
                    $templateProcessor->saveAs(public_path().'/document/storage/'.$outputPath);
                }
            }

            // Simpan PDF ke dalam file
            // $phpWord = IOFactory::load($tempFilePath);

            // Settings::setPdfRendererName(Settings::PDF_RENDERER_TCPDF);
            // Settings::setPdfRendererPath(base_path('vendor/tecnickcom/tcpdf'));

            // $phpWord->save('storage/'.$outputPath, 'PDF');

            //$this->convertToPDF($tempFilePath, 'storage/'.$outputPath);


            // Hapus file temporary .docx
            // unlink($tempFilePath);
            // unlink('storage/temp/file.html');

            // Update data di tabel StKinerja
            $validatedData = ([
                'status' => '2',
                'tanggal' => $tanggal,
                'no_surat' => $nomorSurat,
                'draft' => '/storage'.'/'.$outputPath
            ]);
            RencanaKerja::where('id_rencanakerja', $usulan->rencanaKerja->id_rencanakerja)->update(['status_realisasi' => '1']);
            StKinerja::where('id', $request->input('id'))->update($validatedData);
            return redirect('inspektur/st-kinerja')->with('success', 'Berhasil menyetujui usulan surat!');
        } elseif ($request->input('status') == '5') {
            $validatedData = $request->validate([
                'status' => 'required'
            ]);
            StKinerja::where('id', $request->input('id'))->update($validatedData);
            Surat::where('nomor_surat', $st_kinerja->no_surat)->update(['file' => $st_kinerja->file]);
            return redirect('inspektur/st-kinerja')->with('success', 'Berhasil menyetujui usulan surat!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(StKinerja $stKinerja)
    {
        //
    }

    public function konvTanggalIndo($date)
    {
        $dateComponents = date_parse($date);

        $year = $dateComponents['year'];
        $month = $dateComponents['month'];
        $day = $dateComponents['day'];

        switch ($month) {
            case 1:
                $month = 'Januari';
                break;
            case 2:
                $month = 'Februari';
                break;
            case 3:
                $month = 'Maret';
                break;
            case 4:
                $month = 'April';
                break;
            case 5:
                $month = 'Mei';
                break;
            case 6:
                $month = 'Juni';
                break;
            case 7:
                $month = 'Juli';
                break;
            case 8:
                $month = 'Agustus';
                break;
            case 9:
                $month = 'September';
                break;
            case 10:
                $month = 'Oktober';
                break;
            case 11:
                $month = 'November';
                break;
            case 12:
                $month = 'Desember';
                break;
        }

        return $day.' '.$month.' '.$year;
    }

    public function convertToPDF($inputPath, $outputPath)
    {
        $dompdf = new Dompdf();
        $docxFile = public_path($inputPath);
        $html = $this->docxToHtml($docxFile);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();
        $pdfPath = public_path($outputPath);
        file_put_contents($pdfPath, $output);
    }

    private function docxToHtml($docxFile)
    {
        $phpWord = IOFactory::load($docxFile);
        $htmlWriter = new \PhpOffice\PhpWord\Writer\HTML($phpWord);
        $htmlWriter->save('storage/temp/file.html');
        $html = file_get_contents('storage/temp/file.html');
        return $html;
    }
}
