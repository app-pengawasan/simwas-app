<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TimKerja;
use App\Models\StKinerja;
use App\Models\NormaHasil;
use Illuminate\Http\Request;
use App\Models\MasterLaporan;
use App\Models\NormaHasilTim;
use App\Models\PelaksanaTugas;
use App\Models\NormaHasilAccepted;
use App\Models\KodeKlasifikasiArsip;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Builder;

class ArsiparisNormaHasilController extends Controller
{
    protected $unit_kerja = [
        '08000' => 'Inspektorat Utama',
        '08010' => 'Bagian Umum Inspektorat Utama',
        '08100' => 'Inspektorat Wilayah I',
        '08200' => 'Inspektorat Wilayah II',
        '08300' => 'Inspektorat Wilayah III'
    ];
    private $kodeHasilPengawasan = [
        "110" => 'LHA',
        "120" => 'LHK',
        "130" => 'LHT',
        "140" => 'LHI',
        "150" => 'LHR',
        "160" => 'LHE',
        "170" => 'LHP',
        "180" => 'LHN',
        "190" => 'LTA',
        "200" => 'LTR',
        "210" => 'LTE',
        "220" => 'LKP',
        "230" => 'LKS',
        "240" => 'LKB',
        "500" => 'EHP',
        "510" => 'LTS',
        "520" => 'PHP',
        "530" => 'QAP'
    ];
    private $hasilPengawasan = [
    "110" => "Laporan Hasil Audit Kepatuhan",
    "120" => "Laporan Hasil Audit Kinerja",
    "130" => "Laporan Hasil Audit ADTT",
    "140" => "Laporan Hasil Audit Investigasi",
    "150" => "Laporan Hasil Reviu",
    "160" => "Laporan Hasil Evaluasi",
    "170" => "Laporan Hasil Pemantauan",
    "180" => "Laporan Hasil Penelaahan",
    "190" => "Laporan Hasil Monitoring Tindak Lanjut Hasil Audit",
    "200" => "Laporan Hasil Monitoring Tindak Lanjut Hasil Reviu",
    "210" => "Laporan Hasil Monitoring Tindak Lanjut Hasil Evaluasi",
    "220" => "Laporan Pendampingan",
    "230" => "Laporan Sosialisasi",
    "240" => "Laporan Bimbingan Teknis",
    "500" => "Evaluasi Hasil Pengawasan",
    "510" => "Telaah Sejawat",
    "520" => "Pengolahan Hasil Pengawasan",
    "530" => "Penjaminan Kualitas Pengawasan"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('arsiparis');
        $year = $request->year;
        $unit_kerja = $request->unit_kerja;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $laporan = NormaHasilTim::with('rencanaKerja','normaHasilAccepted.normaHasil.masterLaporan','normaHasilAccepted.normaHasil.laporanPengawasan.objekPengawasan')->latest()
            ->where(function ($query) use ($year) {
                $query->whereYear('created_at', $year)
                    ->whereRelation('normaHasilAccepted', function (Builder $query) {
                        $query->whereNot('status_verifikasi_arsiparis', 'belum unggah');
                    })
                    ->orWhereRelation('normaHasilDokumen', function (Builder $query) {
                        $query->whereNot('status_verifikasi_arsiparis', 'belum unggah');
                    });
            })
            ->get();



        $normaHasilBelumUpload = NormaHasilAccepted::with('normaHasil.masterLaporan','normaHasil.laporanPengawasan.objekPengawasan','normaHasil.rencanaKerja')->where('status_verifikasi_arsiparis', 'belum unggah')->whereYear('created_at', $year);

        if (!is_null($unit_kerja)) {
            $normaHasilBelumUpload = $normaHasilBelumUpload->whereHas('normaHasil', function (Builder $query) use ($unit_kerja) {
                $query->whereHas('rencanaKerja', function (Builder $query) use ($unit_kerja) {
                    $query->where('unit_kerja', $unit_kerja);
                });
            });
            $laporan = NormaHasilTim::latest()
                ->whereRelation('normaHasilAccepted', function (Builder $query) use ($unit_kerja) {
                    $query->whereNot('status_verifikasi_arsiparis', 'belum unggah')
                        ->whereHas('normaHasil', function (Builder $query) use ($unit_kerja) {
                            $query->whereHas('rencanaKerja.timKerja', function (Builder $query) use ($unit_kerja) {
                                $query->where('unit_kerja', $unit_kerja);
                            });
                        });
                })->whereYear('created_at', $year)
                // whererelation where normaHasilTim->rencaKerja->unit_kerja = $unit_kerja and status_verifikasi_arsiparis != tes
                ->orWhereRelation('normaHasilDokumen', function (Builder $query) use ($unit_kerja) {
                    $query->whereNot('status_verifikasi_arsiparis', 'belum unggah')
                        ->whereHas('normaHasilTim', function (Builder $query) use ($unit_kerja) {
                            $query->whereHas('rencanaKerja.timKerja', function (Builder $query) use ($unit_kerja) {
                                $query->where('unitkerja', $unit_kerja);
                            });
                        });
                })
                ->whereYear('created_at', $year)
                ->get();


        }

        $normaHasilBelumUpload = $normaHasilBelumUpload->get();


        $jenisNormaHasil = MasterLaporan::get();


        $currentYear = date('Y');

        $year = NormaHasilTim::selectRaw('YEAR(created_at) as year')->distinct()->get();

        $yearValues = $year->pluck('year')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['year' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('year');


        $months=[
            0 => '',
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];


        return view('arsiparis.norma-hasil.index', [
            'type_menu' => 'tugas-tim',
            'laporan' => $laporan,
            'months' => $months,
            'normaHasilBelumUpload' => $normaHasilBelumUpload,
            'year' => $year,
            'jenisNormaHasil' => $jenisNormaHasil,
            'unit_kerja' => $this->unit_kerja,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $laporan = NormaHasilTim::findOrFail($request->norma_hasil);
        if ($request->jenis == 1) {
            $laporan->normaHasilAccepted->update([
                'status_verifikasi_arsiparis' => 'disetujui',
            ]);
        } else {
            $laporan->normaHasilDokumen->update([
                'status_verifikasi_arsiparis' => 'disetujui',
            ]);
        }
        return redirect()->back()->with('success', 'Norma Hasil Berhasil Disetujui');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $norma_hasil = NormaHasilTim::findOrFail($id);
        return view('arsiparis.norma-hasil.show', [
            "usulan" => $norma_hasil,
            'kodeHasilPengawasan' => $this->kodeHasilPengawasan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $months=[
            0 => 'Pilih Bulan',
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        $normaHasilTim = NormaHasilTim::findOrFail($id);
        $normaHasilAccepted = $normaHasilTim->normaHasilAccepted;
        $normaHasilUsulan = $normaHasilTim->normaHasilAccepted->normaHasil;
        $timKerja = TimKerja::get();
        $pengusul = User::get();
        $klasifikasi = KodeKlasifikasiArsip::get();
        $masterLaporan = MasterLaporan::get();
        return view('arsiparis.norma-hasil.edit', [
            'normaHasilTim' => $normaHasilTim,
            'normaHasilAccepted' => $normaHasilAccepted,
            'normaHasilUsulan' => $normaHasilUsulan,
            'timKerja' => $timKerja,
            'pengusul' => $pengusul,
            'klasifikasi' => $klasifikasi,
            'masterLaporan' => $masterLaporan,
            'unit_kerja' => $this->unit_kerja,
            'months' => $months,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $laporan = NormaHasilTim::findOrFail($id);

        if ($request->jenis == 1) {
            $laporan->normaHasilAccepted->update([
                'status_verifikasi_arsiparis' => 'ditolak',
                'catatan_arsiparis' => $request->alasan
            ]);
        } else {
            $laporan->normaHasilDokumen->update([
                'status_verifikasi_arsiparis' => 'ditolak',
                'catatan_arsiparis' => $request->alasan
            ]);
        }

        return redirect()->back()->with('success', 'Norma Hasil Berhasil Ditolak');
    }

    public function updateNormaHasil(Request $request, $id)
    {
        try {
            $normaHasilUsulan = NormaHasil::findOrFail($id);
            $normaHasilUsulan->update([
                'user_id' => $request->nama_pengusul,
                'tanggal' => $request->tanggal_norma_hasil,
                'unit_kerja' => $request->unit_kerja,
                'tugas_id' => $request->rencana_id,
                'jenis_norma_hasil_id' => $request->jenis_norma_hasil,
                'document_path' => $request->url_norma_hasil,
                'laporan_pengawasan_id' => $request->bulan_pelaporan,
            ]);

            $file = $request->file('file');
            if ($file == null) {
                $normaHasilAccepted = NormaHasilAccepted::where('id_norma_hasil', $normaHasilUsulan->id)->first();
                $normaHasilAccepted->update([
                'tanggal_norma_hasil' => $request->tanggal_norma_hasil,
                'unit_kerja' => $request->unit_kerja,
                'kode_norma_hasil' =>  $request->jenis_norma_hasil,
            ]);

            } else {
                $fileName = time() . '-laporan-norma-hasil.' . $file->getClientOriginalExtension();
                $path = public_path('storage/tim/norma-hasil');
                $file->move($path, $fileName);
                $laporan_path = 'storage/tim/norma-hasil/' . $fileName;
                $normaHasilAccepted = NormaHasilAccepted::where('id_norma_hasil', $normaHasilUsulan->id)->first();
                $normaHasilAccepted->update([
                'tanggal_norma_hasil' => $request->tanggal_norma_hasil,
                'unit_kerja' => $request->unit_kerja,
                'laporan_path' => $laporan_path,
            ]);
            }

            $normaHasilTim = NormaHasilTim::where('laporan_id',$normaHasilUsulan->normaHasilAccepted->id)->first();
            $normaHasilTim->update([
                'tugas_id' => $request->rencana_id,
            ]);
            return redirect('/arsiparis/norma-hasil/'.$normaHasilTim->id)->with('success', 'Norma Hasil Berhasil Diubah');
        } catch (\Throwable $th) {
            dd($th);
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
