<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sekretaris.surat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi dan pengambilan input dari request
        $validatedData = $request->validate([
            'user_id' => 'required',
            'derajat_klasifikasi' => 'required',
            'nomor_organisasi' => 'required',
            'kka' => 'required',
            'tanggal' => 'required',
            'jenis' => 'required',
            'is_backdate' => 'required'
        ]);
        
        $backdate = $validatedData['is_backdate'];
        unset($validatedData['is_backdate']);

        if ($backdate == '0') {
            // Cari data terakhir dengan unit_kerja yang sama
            $lastData = Surat::where('nomor_organisasi', $validatedData['nomor_organisasi'])
            ->whereNull('backdate')
            ->orderBy('created_at', 'desc')
            ->first();

            // Jika ada data terakhir dengan unit_kerja yang sama, tambahkan nomor_naskah
            if ($lastData) {
                $lastNomorNaskah = $lastData->nomor_naskah;
                $lastNomorNaskah++;
            } else {
                // Jika tidak ada data sebelumnya dengan unit_kerja yang sama, set nomor_naskah awal
                $lastNomorNaskah = 1;
            }

            // Tambahkan nomor_naskah ke validatedData
            $validatedData['nomor_naskah'] = $lastNomorNaskah;
            $nomorNaskahPadded = str_pad($lastNomorNaskah, 3, '0', STR_PAD_LEFT);
            $bulan = date('m', strtotime($validatedData['tanggal']));
            $tahun = date('Y', strtotime($validatedData['tanggal']));
            $validatedData['nomor_surat'] = $validatedData['derajat_klasifikasi'].'-'.$nomorNaskahPadded.'/0'.$validatedData['nomor_organisasi'].'/'.$validatedData['kka'].'/'.$bulan.'/'.$tahun;

            // Simpan data ke database
            Surat::create($validatedData);

            // Redirect atau response sesuai kebutuhan
        } else {
            $notFound = true;
            $tanggal = $validatedData['tanggal'];
            while ($notFound) {
                $lastData = Surat::where('nomor_organisasi', $validatedData['nomor_organisasi'])
                ->where('tanggal', $tanggal)
                ->orderBy('created_at', 'desc')
                ->first();
                if ($lastData) {
                    if($lastData->backdate) {
                        $validatedData['backdate'] += $lastData->backdate;
                    } else {
                        $validatedData['backdate'] = 1;
                    }
                    $validatedData['nomor_naskah'] = $lastData->nomor_naskah;
                    $nomorNaskahPadded = str_pad($validatedData['nomor_naskah'], 3, '0', STR_PAD_LEFT);
                    $bulan = date('m', strtotime($validatedData['tanggal']));
                    $tahun = date('Y', strtotime($validatedData['tanggal']));
                    $validatedData['nomor_surat'] = $validatedData['derajat_klasifikasi'].'-'.$nomorNaskahPadded.'.'.$validatedData['backdate'].'/0'.$validatedData['nomor_organisasi'].'/'.$validatedData['kka'].'/'.$bulan.'/'.$tahun;
                    Surat::create($validatedData);
                    $notFound = false;
                } else {
                    $tanggal = date('Y-m-d', strtotime('-1 day', strtotime($tanggal)));
                }
            }
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function show(Surat $surat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function edit(Surat $surat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Surat $surat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Surat $surat)
    {
        //
    }
}
