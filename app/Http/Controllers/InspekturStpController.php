<?php

namespace App\Http\Controllers;

use App\Models\Stp;
use App\Models\Surat;
use App\Models\User;
use App\Models\MasterPimpinan;
use App\Models\Pembebanan;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;


class InspekturStpController extends Controller
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
            $usulan = Stp::latest()->get();
        } else {
            $usulan = Stp::latest()->where('unit_kerja', auth()->user()->unit_kerja)->get();
        }
        return view('inspektur.st-pp.index', [
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
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function show(Stp $st_pp)
    {
        $this->authorize('inspektur');
        $pegawaiArray = explode(', ', $st_pp->pegawai);
        $users = \App\Models\User::whereIn('id', $pegawaiArray)->get();
        $nama = $users->pluck('name')->toArray();
        $pegawai = implode(', ', $nama);
        return view('inspektur.st-pp.show', [
            "usulan" => $st_pp,
            "pegawai" => $pegawai,
            "jabatan_pimpinan" =>$this->jabatan_pimpinan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function edit(Stp $st_pp)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stp $st_pp)
    {
        $this->authorize('inspektur');
        if ($request->input('status') == '1' || $request->input('status') == '4' || $request->input('status') == '7') {
            $validatedData = $request->validate([
                'catatan' => 'required'
            ],[
                'required' => 'Wajib diisi'
            ]);
            $validatedData['status'] = $request->input('status');
            Stp::where('id', $request->input('id'))->update($validatedData);
            return redirect('inspektur/st-pp')->with('success', 'Berhasil menolak usulan surat!');
        } elseif ($request->input('status') == '2') {
            if ($request->has('edit')) {
                $validatedData = $request->validate([
                    'is_backdate' => 'required',
                    'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
                    'unit_kerja' => 'required',
                    'pp_id' => 'required',
                    'nama_pp' => 'required',
                    'melaksanakan' => 'required',
                    'mulai' => $request->input('is_backdate') === '1' ? 'required|date|after_or_equal:tanggal' : 'required|date|after_or_equal:today',
                    'selesai' => 'required|date|after_or_equal:mulai',
                    'pembebanan_id' => 'required',
                    'pegawai' => 'required',
                    'penandatangan' => 'required',
                    'is_esign' => 'required',
                    'status' => 'required'
                ], [
                    'selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan waktu mulai.',
                    'mulai.after_or_equal' => 'Tanggal mulai harus setelah atau sama dengan hari ini/tanggal surat',
                    'required' => 'Wajib diisi'
                ]);
        
                $validatedData['pegawai'] = implode(', ', $validatedData['pegawai']);
                Stp::where('id', $request->input('id'))->update($validatedData);
            }
            $usulan = Stp::find($request->input('id'));
            $data = new Request();
            $tanggal = ($usulan->is_backdate == '0') ? date('Y-m-d') : $usulan->tanggal;
            $data->merge([
                'user_id' => $usulan->user_id,
                'derajat_klasifikasi' => 'B',
                'nomor_organisasi' => $usulan->unit_kerja,
                'kka' => 'KP.310',
                'tanggal' => $tanggal,
                'jenis' => 'ST Pengembangan Profesi',
                'is_backdate' => $usulan->is_backdate
            ]);
            $buatSurat = new SuratController();
            $buatSurat->store($data);
            $nomorSurat = Surat::latest()->first()->nomor_surat;
            
            // Path untuk menyimpan hasil dokumen
            $tempFilePath = 'storage/temp/temp_file.docx';
            $outputPath = 'st-pp'.'/'.$usulan->id.'-draft.docx';

            // Ambil pegawai
            $pegawaiArray = explode(', ', $usulan->pegawai);
            $pimpinan = MasterPimpinan::find($usulan->penandatangan);

            if (count($pegawaiArray) == 1) {
                if ($usulan->is_esign) {
                    // Path ke template dokumen .docx
                    $stpPerseoranganPath = 'document/template-dokumen/draft-st-pp-perorangan-esign.docx';

                    // Inisialisasi TemplateProcessor dengan template dokumen
                    $templateProcessor = new TemplateProcessor($stpPerseoranganPath);

                    $templateProcessor->setValues([
                        'no_surat' => $nomorSurat,
                        'nama' => $usulan->user->name,
                        'pangkat' => $this->pangkat[$usulan->user->pangkat],
                        'nip' => $usulan->user->nip,
                        'jabatan' => $this->jabatan[$usulan->user->jabatan],
                        'melaksanakan' => $usulan->melaksanakan,
                        'pembebanan' => $usulan->pembebanan->nama,
                        'mulaiSelesai' => $this->konvTanggalIndo($usulan->mulai).' - '.$this->konvTanggalIndo($usulan->selesai),
                        'tanggal' => $this->konvTanggalIndo($tanggal),
                        'roleInspektur' => $this->jabatan_pimpinan[$pimpinan->jabatan],
                        'inspektur' => $pimpinan->user->name
                    ]);

                    // Simpan dokumen hasil
                    $templateProcessor->saveAs('storage/'.$outputPath);

                } else {
                    // Path ke template dokumen .docx
                    $stpPerseoranganPath = 'document/template-dokumen/draft-st-pp-perorangan-nonesign.docx';

                    // Inisialisasi TemplateProcessor dengan template dokumen
                    $templateProcessor = new TemplateProcessor($stpPerseoranganPath);
                    $templateProcessor->setValues([
                        'no_surat' => $nomorSurat,
                        'nama' => $usulan->user->name,
                        'pangkat' => $this->pangkat[$usulan->user->pangkat],
                        'nip' => $usulan->user->nip,
                        'jabatan' => $this->jabatan[$usulan->user->jabatan],
                        'melaksanakan' => $usulan->melaksanakan,
                        'pembebanan' => $usulan->pembebanan->nama,
                        'mulaiSelesai' => $this->konvTanggalIndo($usulan->mulai).' - '.$this->konvTanggalIndo($usulan->selesai),
                        'tanggal' => $this->konvTanggalIndo($tanggal),
                        'roleInspektur' => $this->jabatan_pimpinan[$pimpinan->jabatan],
                        'inspektur' => $pimpinan->user->name
                    ]);

                    // Simpan dokumen hasil
                    $templateProcessor->saveAs('storage/'.$outputPath);
                }
                
            } else {
                $surat = Surat::where('nomor_surat', $nomorSurat)->first();

                $users = \App\Models\User::whereIn('id', $pegawaiArray)->get();

                $values = [];
                $counter = 1;
                foreach ($users as $anggota) {
                    $values[] = ['no' => $counter, 'nama' => $anggota->name, 'pangkat' => $this->pangkat[$anggota->pangkat], 'nip' => $anggota->nip, 'jabatan' => $this->jabatan[$anggota->jabatan]];
                    if ($anggota->id != $surat->user_id) {
                        $newSurat = $surat->replicate();
                        $newSurat->user_id = $anggota->id;
                        $newSurat->save();
                    }
                    $counter++;
                }

                if ($usulan->is_esign) {
                    // Path ke template dokumen .docx
                    $stpKolektifPath = 'document/template-dokumen/draft-st-pp-kolektif-esign.docx';

                    // Inisialisasi TemplateProcessor dengan template dokumen
                    $templateProcessor = new TemplateProcessor($stpKolektifPath);
                    
                    $templateProcessor->cloneRowAndSetValues('no', $values);
                    
                    $pimpinan = MasterPimpinan::find($usulan->penandatangan);
                    $templateProcessor->setValues([
                        'no_surat' => $nomorSurat,
                        'melaksanakan' => $usulan->melaksanakan,
                        'pembebanan' => $usulan->pembebanan->nama,
                        'mulaiSelesai' => $this->konvTanggalIndo($usulan->mulai).' - '.$this->konvTanggalIndo($usulan->selesai),
                        'tanggal' => $this->konvTanggalIndo($tanggal),
                        'roleInspektur' => $this->jabatan_pimpinan[$pimpinan->jabatan],
                        'inspektur' => $pimpinan->user->name
                    ]);

                    // Simpan dokumen hasil
                    $templateProcessor->saveAs('storage/'.$outputPath);
                } else {
                    // Path ke template dokumen .docx
                    $stpKolektifPath = 'document/template-dokumen/draft-st-pp-kolektif-nonesign.docx';

                    // Inisialisasi TemplateProcessor dengan template dokumen
                    $templateProcessor = new TemplateProcessor($stpKolektifPath);
                    
                    $templateProcessor->cloneRowAndSetValues('no', $values);

                    $templateProcessor->setValues([
                        'no_surat' => $nomorSurat,
                        'melaksanakan' => $usulan->melaksanakan,
                        'pembebanan' => $usulan->pembebanan->nama,
                        'mulaiSelesai' => $this->konvTanggalIndo($usulan->mulai).' - '.$this->konvTanggalIndo($usulan->selesai),
                        'tanggal' => $this->konvTanggalIndo($tanggal),
                        'roleInspektur' => $this->jabatan_pimpinan[$pimpinan->jabatan],
                        'inspektur' => $pimpinan->user->name
                    ]);

                    // Simpan dokumen hasil
                    $templateProcessor->saveAs('storage/'.$outputPath);
                }
            }

            //$this->convertToPDF($tempFilePath, 'storage/'.$outputPath);


            // Hapus file temporary .docx
            // unlink($tempFilePath);
            // unlink('storage/temp/file.html');

            $validatedData = ([
                'status' => '2',
                'tanggal' => $tanggal,
                'no_surat' => $nomorSurat,
                'draft' => '/storage'.'/'.$outputPath
            ]);
            Stp::where('id', $request->input('id'))->update($validatedData);
            return redirect('inspektur/st-pp')->with('success', 'Berhasil menyetujui usulan surat!');
        } elseif ($request->input('status') == '5') {
            $validatedData = $request->validate([
                'status' => 'required'
            ]);
            Stp::where('id', $request->input('id'))->update($validatedData);
            Surat::where('nomor_surat', $st_pp->no_surat)->update(['file' => $st_pp->file]);
            return redirect('inspektur/st-pp')->with('success', 'Berhasil menyetujui usulan surat!');
        } elseif ($request->input('status') == '8') {
            $validatedData = $request->validate([
                'status' => 'required'
            ]);
            Stp::where('id', $request->input('id'))->update($validatedData);
            return redirect('inspektur/st-pp')->with('success', 'Berhasil menyetujui sertifikat!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stp $stp)
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
