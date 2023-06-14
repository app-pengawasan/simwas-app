<?php

namespace App\Http\Controllers;

use App\Models\StKinerja;
use App\Models\Surat;
use App\Models\User;
use App\Models\MasterPimpinan;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

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
        '8100' => 'Insapektorat Wilayah I',
        '8200' => 'Insapektorat Wilayah II',
        '8300' => 'Insapektorat Wilayah III'
    ];

    protected $jabatan = [
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ((auth()->user()->is_aktif) && (auth()->user()->unit_kerja == '8000') ) {
            $usulan = StKinerja::latest()->get();
        } else {
            $usulan = StKinerja::latest()->where('unit_kerja', auth()->user()->unit_kerja)->get();
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
        $anggotaArray = explode(', ', $stKinerja->anggota);
        $users = \App\Models\User::whereIn('id', $anggotaArray)->get();
        $nama = $users->pluck('name')->toArray();
        $anggota = implode(', ', $nama);
        return view('inspektur.st-kinerja.show', [
            "usulan" => $stKinerja,
            "anggota" => $anggota
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
        $pimpinanAktif = MasterPimpinan::latest()->whereDate('selesai', '>=', date('Y-m-d'))->get();
        $pimpinanNonaktif = MasterPimpinan::latest()->whereDate('selesai', '<', date('Y-m-d'))->get();
        $user = User::all();
        return view('inspektur.st-kinerja.edit', [
            "usulan" => $st_kinerja,
            "user" => $user,
            "pimpinanAktif" => $pimpinanAktif,
            "pimpinanNonaktif" => $pimpinanNonaktif
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StKinerja $stKinerja)
    {
        if ($request->input('status') == '1') {
            $validatedData = $request->validate([
                'catatan' => 'required'
            ],[
                'required' => 'Wajib diisi'
            ]);
            $validatedData['status'] = '1';
            StKinerja::where('id', $request->input('id'))->update($validatedData);
            return redirect('inspektur/st-kinerja')->with('success', 'Berhasil menolak usulan surat!');
        } elseif ($request->input('status') == '2') {
            if ($request->has('edit')) {
                $usulan = StKinerja::find($request->input('id'));
                $validatedData = $request->validate([
                    'is_backdate' => 'required',
                    'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
                    'unit_kerja' => 'required',
                    'tim_kerja' => 'required',
                    'tugas' => 'required',
                    'melaksanakan' => 'required',
                    'objek' => 'required',
                    'mulai' => 'required|date',
                    'selesai' => 'required|date|after_or_equal:mulai',
                    'is_gugus_tugas' => 'required',
                    'is_perseorangan' => $request->input('is_gugus_tugas') === '0' ? 'required' : '',
                    'dalnis_id' => $request->input('is_gugus_tugas') === '1' ? 'required' : '',
                    'ketua_koor_id' => ($request->input('is_gugus_tugas') === '1' || $request->input('is_perseorangan') === '0') ? 'required' : '',
                    'anggota' => ($request->input('is_gugus_tugas') === '1' || $request->input('is_perseorangan') === '0') ? 'required' : '',
                    'penandatangan' => 'required',
                    'status' => 'required',
                    'is_esign' => 'required',
                ],[
                    'after_or_equal' => 'Waktu selesai harus setelah atau sama dengan waktu mulai.',
                    'required' => 'Wajib diisi.'
                ]);
        
                if (!($validatedData['is_gugus_tugas'])) {
                    if ($validatedData['is_perseorangan'] == '0') {
                        $validatedData['anggota'] = implode(', ', $validatedData['anggota']);
                    }
                } else {
                    $validatedData['anggota'] = implode(', ', $validatedData['anggota']);
                }
                StKinerja::where('id', $request->input('id'))->update($validatedData);
            }
            $usulan = StKinerja::find($request->input('id'));
            $data = new Request();
            $tanggal = ($usulan->is_backdate == '0') ? date('Y-m-d') : $usulan->tanggal;
            $data->merge([
                'user_id' => $usulan->user_id,
                'derajat_klasifikasi' => 'B',
                'nomor_organisasi' => $usulan->unit_kerja,
                'kka' => 'PW.110',
                'tanggal' => $tanggal,
                'jenis' => 'ST Kinerja',
                'is_backdate' => $usulan->is_backdate
            ]);
            $buatSurat = new SuratController();
            $buatSurat->store($data);
            $nomorSurat = Surat::latest()->first()->nomor_surat;
            
            // Path untuk menyimpan hasil dokumen
            $outputPath = '/st-kinerja'.'/'.$usulan->id.'.docx';

            // Pembuatan surat
            if ($usulan->is_perseorangan) {
                if ($usulan->is_esign) {
                    // Path ke template dokumen .docx
                    $stkPerseoranganPath = 'document/template-dokumen/draft-st-kinerja-perorangan-esign.docx';

                    // Inisialisasi TemplateProcessor dengan template dokumen
                    $templateProcessor = new TemplateProcessor($stkPerseoranganPath);

                    $templateProcessor->setValues([
                        'no_surat' => $nomorSurat,
                        'nama' => $usulan->user->name,
                        'pangkat' => $this->pangkat[$usulan->user->pangkat],
                        'nip' => $usulan->user->nip,
                        'jabatan' => $this->jabatan[$usulan->user->jabatan],
                        'melaksanakan' => $usulan->melaksanakan,
                        'mulaiSelesai' => $this->konvTanggalIndo($usulan->mulai).' - '.$this->konvTanggalIndo($usulan->selesai),
                        'objek' => $usulan->objek,
                        'tanggal' => $this->konvTanggalIndo($tanggal)
                    ]);

                    // Simpan dokumen hasil
                    $templateProcessor->saveAs('storage/'.$outputPath);
                } else {
                    // Path ke template dokumen .docx
                    $stkPerseoranganPath = 'document/template-dokumen/draft-st-kinerja-perorangan-nonesign.docx';

                    // Inisialisasi TemplateProcessor dengan template dokumen
                    $templateProcessor = new TemplateProcessor($stkPerseoranganPath);
                    $pimpinan = MasterPimpinan::find($usulan->penandatangan);
                    $templateProcessor->setValues([
                        'no_surat' => $nomorSurat,
                        'nama' => $usulan->user->name,
                        'pangkat' => $this->pangkat[$usulan->user->pangkat],
                        'nip' => $usulan->user->nip,
                        'jabatan' => $this->jabatan[$usulan->user->jabatan],
                        'melaksanakan' => $usulan->melaksanakan,
                        'mulaiSelesai' => $this->konvTanggalIndo($usulan->mulai).' - '.$this->konvTanggalIndo($usulan->selesai),
                        'objek' => $usulan->objek,
                        'tanggal' => $this->konvTanggalIndo($tanggal),
                        'roleInspektur' => $pimpinan->jabatan,
                        'inspektur' => $pimpinan->user->name
                    ]);

                    // Simpan dokumen hasil
                    $templateProcessor->saveAs('storage/'.$outputPath);
                }
                
            } else {
                // Ambil anggota
                $anggotaArray = explode(', ', $usulan->anggota);
                $users = \App\Models\User::whereIn('id', $anggotaArray)->get();

                if ($usulan->is_esign) {
                    // Path ke template dokumen .docx
                    $stkKolektifPath = 'document/template-dokumen/draft-st-kinerja-kolektif-esign.docx';

                    // Inisialisasi TemplateProcessor dengan template dokumen
                    $templateProcessor = new TemplateProcessor($stkKolektifPath);
                    
                    $values = [];
                    if ($usulan->is_gugus_tugas) {
                        $values[] = ['no' => 1, 'nama' => $usulan->dalnis->name, 'pangkat' => $this->pangkat[$usulan->dalnis->pangkat], 'nip' => $usulan->dalnis->nip, 'jabatan' => $this->jabatan[$usulan->dalnis->jabatan], 'keterangan' => 'Pengendali Teknis'];
                        $values[] = ['no' => 2, 'nama' => $usulan->ketuaKoor->name, 'pangkat' => $this->pangkat[$usulan->ketuaKoor->pangkat], 'nip' => $usulan->ketuaKoor->nip, 'jabatan' => $this->jabatan[$usulan->ketuaKoor->jabatan], 'keterangan' => 'Ketua Tim'];
                        $counter = 3;
                        foreach ($users as $anggota) {
                            $values[] = ['no' => $counter, 'nama' => $anggota->name, 'pangkat' => $this->pangkat[$anggota->pangkat], 'nip' => $anggota->nip, 'jabatan' => $this->jabatan[$anggota->jabatan], 'keterangan' => 'Anggota Tim'];
                            $counter++;
                        }
                        $templateProcessor->cloneRowAndSetValues('no', $values);
                    } else {
                        $values[] = ['no' => 1, 'nama' => $usulan->ketuaKoor->name, 'pangkat' => $this->pangkat[$usulan->ketuaKoor->pangkat], 'nip' => $usulan->ketuaKoor->nip, 'jabatan' => $this->jabatan[$usulan->ketuaKoor->jabatan], 'keterangan' => 'Koordinator'];
                        $counter = 2;
                        foreach ($users as $anggota) {
                            $values[] = ['no' => $counter, 'nama' => $anggota->name, 'pangkat' => $this->pangkat[$anggota->pangkat], 'nip' => $anggota->nip, 'jabatan' => $this->jabatan[$anggota->jabatan], 'keterangan' => 'Anggota'];
                            $counter++;
                        }
                        $templateProcessor->cloneRowAndSetValues('no', $values);
                    }

                    $templateProcessor->setValues([
                        'no_surat' => $nomorSurat,
                        'melaksanakan' => $usulan->melaksanakan,
                        'mulaiSelesai' => $this->konvTanggalIndo($usulan->mulai).' - '.$this->konvTanggalIndo($usulan->selesai),
                        'objek' => $usulan->objek,
                        'tanggal' => $this->konvTanggalIndo($tanggal)
                    ]);

                    // Simpan dokumen hasil
                    $templateProcessor->saveAs('storage/'.$outputPath);
                } else {
                    // Path ke template dokumen .docx
                    $stkKolektifPath = 'document/template-dokumen/draft-st-kinerja-kolektif-nonesign.docx';

                    // Inisialisasi TemplateProcessor dengan template dokumen
                    $templateProcessor = new TemplateProcessor($stkKolektifPath);
                    
                    $values = [];
                    if ($usulan->is_gugus_tugas) {
                        $values[] = ['no' => 1, 'nama' => $usulan->dalnis->name, 'pangkat' => $this->pangkat[$usulan->dalnis->pangkat], 'nip' => $usulan->dalnis->nip, 'jabatan' => $this->jabatan[$usulan->dalnis->jabatan], 'keterangan' => 'Pengendali Teknis'];
                        $values[] = ['no' => 2, 'nama' => $usulan->ketuaKoor->name, 'pangkat' => $this->pangkat[$usulan->ketuaKoor->pangkat], 'nip' => $usulan->ketuaKoor->nip, 'jabatan' => $this->jabatan[$usulan->ketuaKoor->jabatan], 'keterangan' => 'Ketua Tim'];
                        $counter = 3;
                        foreach ($users as $anggota) {
                            $values[] = ['no' => $counter, 'nama' => $anggota->name, 'pangkat' => $this->pangkat[$anggota->pangkat], 'nip' => $anggota->nip, 'jabatan' => $this->jabatan[$anggota->jabatan], 'keterangan' => 'Anggota Tim'];
                            $counter++;
                        }
                        $templateProcessor->cloneRowAndSetValues('no', $values);
                    } else {
                        $values[] = ['no' => 1, 'nama' => $usulan->ketuaKoor->name, 'pangkat' => $this->pangkat[$usulan->ketuaKoor->pangkat], 'nip' => $usulan->ketuaKoor->nip, 'jabatan' => $this->jabatan[$usulan->ketuaKoor->jabatan], 'keterangan' => 'Koordinator'];
                        $counter = 2;
                        foreach ($users as $anggota) {
                            $values[] = ['no' => $counter, 'nama' => $anggota->name, 'pangkat' => $this->pangkat[$anggota->pangkat], 'nip' => $anggota->nip, 'jabatan' => $this->jabatan[$anggota->jabatan], 'keterangan' => 'Anggota'];
                            $counter++;
                        }
                        $templateProcessor->cloneRowAndSetValues('no', $values);
                    }

                    $pimpinan = MasterPimpinan::find($usulan->penandatangan);
                    $templateProcessor->setValues([
                        'no_surat' => $nomorSurat,
                        'melaksanakan' => $usulan->melaksanakan,
                        'mulaiSelesai' => $this->konvTanggalIndo($usulan->mulai).' - '.$this->konvTanggalIndo($usulan->selesai),
                        'objek' => $usulan->objek,
                        'tanggal' => $this->konvTanggalIndo($tanggal),
                        'roleInspektur' => $pimpinan->jabatan,
                        'inspektur' => $pimpinan->user->name
                    ]);

                    // Simpan dokumen hasil
                    $templateProcessor->saveAs('storage/'.$outputPath);
                }
            }
            
            // Simpan ke tabel Surat
            Surat::where('nomor_surat', $nomorSurat)->update(['file' => '/storage'.'/'.$outputPath]);

            // Update data di tabel StKinerja
            $validatedData = ([
                'status' => '2',
                'tanggal' => $tanggal,
                'no_surat' => $nomorSurat,
                'file' => '/storage'.'/'.$outputPath
            ]);
            StKinerja::where('id', $request->input('id'))->update($validatedData);
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
}
