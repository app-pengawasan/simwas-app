<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use Illuminate\Validation\Rule;
use App\Models\RealisasiKinerja;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class RealisasiController extends Controller
{
    protected $colorText = [
        1   => 'success',
        2   => 'danger'
    ];

    protected $status = [
        1   => 'Selesai',
        2   => 'Dibatalkan'
    ];

    protected $hasilKerja = [
        'mhk001' => 'Konsep rencana strategis pengawasan internal',
        'mhk002' => 'Konsep rencana pengawasan tahunan',
        'mhk003' => 'Laporan Hasil Pemantauan rencana pengawasan tahunan',
        'mhk004' => 'Peraturan/pedoman pengawasan intern',
        'mhk005' => 'Kebijakan pengawasan internal',
        'mhk006' => 'Laporan Hasil Audit Kinerja',
        'mhk007' => 'Laporan Hasil audit dengan tujuan tertentu',
        'mhk008' => 'Laporan Hasil Audit Investigatif/PKKN',
        'mhk009' => 'Laporan Hasil Reviu',
        'mhk010' => 'Laporan Hasil Evaluasi',
        'mhk011' => 'Laporan Hasil Pemantauan',
        'mhk012' => 'Laporan Pemberian Keterangan Ahli',
        'mhk013' => 'Hasil Telaah',
        'mhk014' => 'Laporan Hasil Monitoring Tindak Lanjut',
        'mhk015' => 'Laporan Kegiatan Sosialisasi',
        'mhk016' => 'Laporan Kegiatan bimbingan teknis',
        'mhk017' => 'Laporan Kegiatan asistensi',
        'mhk018' => 'Laporan Hasil Evaluasi',
        'mhk019' => 'Laporan Hasil Telaah Sejawat',
        'mhk020' => 'Laporan Penjaminan Kualitas',
        '2'      => 'Kertas Kerja'
    ];

    protected $jabatan = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $realisasi = RealisasiKinerja::whereRelation(
                    'pelaksana', function (Builder $query){    
                        $id_pegawai = auth()->user()->id;
                        $query->where('id_pegawai', $id_pegawai);
                    })->orderByDesc('created_at')->get();

        return view('pegawai.realisasi.index',[
            'type_menu'     => 'realisasi-kinerja',
            'realisasi'     => $realisasi,
            'status'        => $this->status,
            'colorText'     => $this->colorText
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_pegawai = auth()->user()->id;

        $tugasSaya = PelaksanaTugas::where('id_pegawai', $id_pegawai)
                    ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query){
                        $query->where('status', 6);
                    })->get();
        
        //menghapus tugas yang sudah terisi realisasinya
        foreach ($tugasSaya as $key => $ts) {
            if (RealisasiKinerja::where('id_pelaksana', $ts->id_pelaksana)->get()->isNotEmpty())
                $tugasSaya->forget($key);
        }

        //mengambil tim dan proyek unik
        $proyek = [];
        $tim = [];
        foreach ($tugasSaya as $ts) {
            $tim[$ts->rencanaKerja->proyek->timkerja->id_timkerja] = $ts->rencanaKerja->timkerja->nama;
            $proyek[$ts->rencanaKerja->proyek->id] = [
                'nama_proyek' => $ts->rencanaKerja->proyek->nama_proyek,
                'tim'    => $ts->rencanaKerja->proyek->timkerja->id_timkerja
            ];
        }

        $events = Event::whereRelation('pelaksana.user', function (Builder $query) use ($id_pegawai){
                        $query->where('id', $id_pegawai);
                    })->orderBy('start')->get();

        return view('pegawai.realisasi.create',
            [
                'type_menu'     => 'realisasi-kinerja',
                'tugasSaya'     => $tugasSaya,
                'status'        => $this->status,
                'hasilKerja'    => $this->hasilKerja,
                'timkerja'      => $tim,
                'proyeks'       => $proyek,
                'events'        => $events
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $start = $request->tgl.' '.$request->start;
        // $end = $request->tgl.' '.$request->end;
        // //cek duplikat jam mulai
        // $duplicateStart = Event::whereRelation('pelaksana', function (Builder $query){   
        //                     $query->where('id_pegawai', auth()->user()->id);
        //                 })->where('start', '<=', $start)->where('end', '>', $start)->count();
        // //cek duplikat jam selesai
        // $duplicateEnd = Event::whereRelation('pelaksana', function (Builder $query){   
        //                     $query->where('id_pegawai', auth()->user()->id);
        //                 })->where('start', '<', $end)->where('end', '>=', $end)->count();
        // //cek jam antara jam mulai dan jam selesai
        // $duplicateBetween = Event::whereRelation('pelaksana', function (Builder $query){   
        //                         $query->where('id_pegawai', auth()->user()->id);
        //                     })->where('start', '>=', $start)->where('end', '<=', $end)->count();
        
        $rules = [
            'tugas'         => 'required',
            'tim'         => 'required',
            'proyek'         => 'required',
            // 'tgl'           => 'required|date_format:Y-m-d',
            // 'start'         => [
            //                     'required',
            //                     'date_format:H:i',
            //                     'before:end',
            //                     // Rule::when($duplicateStart != 0 || $duplicateBetween != 0, ['boolean'])
            //                 ],
            // 'end'           => [
            //                     'required',
            //                     'date_format:H:i',
            //                     'after:start',
            //                     Rule::when($duplicateEnd != 0 || $duplicateBetween != 0, ['boolean'])
            //                 ],
            'status'        => 'required',
            'kegiatan'      => 'required_if:status,1',
            'capaian'       => 'required_if:status,1',
            'hasil_kerja'   => 'required_if:status,1|nullable|url',
            // 'link'          => 'required_if:file,0|url',
            // 'file'          => 'required_if:link,0|mimes:pdf|max:500',
            // 'catatan'       => 'string',
            'alasan'       => 'required_if:status,2',
        ];

        // ($duplicateBetween != 0) ? $timeMessage = 'Ada aktivitas di antara jam mulai dan selesai ini'
        //                          : $timeMessage = 'Sudah ada aktivitas pada jam ini';

        $customMessages = [
            'required' => ':attribute harus diisi',
            'required_if' => ':attribute harus diisi'
        ];
        
        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $realisasiData = $request->validate($rules);

        // if (array_key_exists("link", $realisasiData)) 
        //     $realisasiData['hasil_kerja'] = $realisasiData['link'];
        // else {
        //     $realisasiData['hasil_kerja'] =  'Realisasi_'.time().'.'.$realisasiData['file']->getClientOriginalExtension();
        //     $realisasiData['file']->move(public_path()."/document/realisasi/", $realisasiData['hasil_kerja']);
        // }

        $realisasiData['id_pelaksana'] = $realisasiData['tugas'];
        $realisasiData['catatan'] = $request->catatan;
        if ($realisasiData['status'] == 2) {
            $realisasiData['kegiatan'] = null;
            $realisasiData['capaian'] = null;
        }

        //create realisasi
        RealisasiKinerja::where('id_pelaksana', $realisasiData['tugas'])->where('status', 1)->update(['status' => 2]);
        RealisasiKinerja::create($realisasiData);

        // $check_tugas = Event::where('id_pelaksana', $realisasiData['tugas'])->first();

        // if ($check_tugas == null) { //jika tugas belum ada aktivitas, cari warna event baru untuk kalender
        //     //kecualikan warna muda
        //     $exclude = range(50, 197); 
        //     while(in_array(($hue = rand(0,359)), $exclude));
            
        //     //jika ada minimal 212 tugas (jumlah warna max = 212) maka warna boleh tidak unik
        //     if (Event::distinct()->count('id_pelaksana') >= 212) $color = 'hsl('.$hue.',100%,50%)'; 
        //     else { //jika jumlah tugas < 212 warna harus unik
        //         $check_color_duplicate = Event::where('color', 'hsl('.$hue.',100%,50%)')->first();

        //         if ($check_color_duplicate != null) { 
        //             while ($check_color_duplicate->color == 'hsl('.$hue.',100%,50%)') //selagi warna masih duplikat, terus cari warna
        //                 while(in_array(($hue = rand(0,359)), $exclude));
        //         } 

        //         $color = 'hsl('.$hue.',100%,50%)';
        //     }
        // } else $color = $check_tugas->color; //jika tugas sudah ada aktivitas, ambil warnanya

        // //create event kalender
        // Event::create([
        //     'id_pelaksana' => $realisasiData['tugas'],
        //     'start'        => $start,
        //     'end'          => $end,
        //     'color'        => $color,
        // ]);


        $request->session()->put('status', 'Berhasil mengisi realisasi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil realisasi kinerja.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $realisasi = RealisasiKinerja::findOrfail($id);
        $events = Event::where('id_pelaksana', $realisasi->id_pelaksana)->get();

        return view('components.realisasi-kinerja.show', [
            'type_menu' => 'realisasi-kinerja',
            'jabatan'   => $this->jabatan,
            'status'        => $this->status,
            'colorText'     => $this->colorText,
            'hasilKerja'    => $this->hasilKerja,
            'kembali'       => 'realisasi',
            'events'        => $events
            ])
            ->with('realisasi', $realisasi);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $realisasi = RealisasiKinerja::findOrfail($id);

        $events = Event::where('id_pelaksana', $realisasi->id_pelaksana)->get();

        return view('pegawai.realisasi.edit', [
            'type_menu' => 'realisasi-kinerja',
            'status'        => $this->status,
            'colorText'     => $this->colorText,
            'events'        => $events
            ])
            ->with('realisasi', $realisasi);
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
        $realisasi = RealisasiKinerja::findOrfail($id);        
        // $event = Event::where('id_pelaksana', $realisasi->id_pelaksana)
        //                 ->where('start', $realisasi->tgl.' '.$realisasi->start)
        //                 ->where('end', $realisasi->tgl.' '.$realisasi->end)->first();

        // $start = $request->tgl.' '.$request->start;
        // $end = $request->tgl.' '.$request->end;
        // //cek duplikat jam mulai
        // $duplicateStart = Event::whereNot('id', $event->id)
        //                     ->whereRelation('pelaksana', function (Builder $query){   
        //                         $query->where('id_pegawai', auth()->user()->id);
        //                     })->where('start', '<=', $start)->where('end', '>', $start)->count();
        // //cek duplikat jam selesai
        // $duplicateEnd = Event::whereNot('id', $event->id)
        //                     ->whereRelation('pelaksana', function (Builder $query){  
        //                         $query->where('id_pegawai', auth()->user()->id);
        //                     })->where('start', '<', $end)->where('end', '>=', $end)->count();
        // //cek jam antara jam mulai dan jam selesai
        // $duplicateBetween = Event::whereNot('id', $event->id)
        //                     ->whereRelation('pelaksana', function (Builder $query){   
        //                         $query->where('id_pegawai', auth()->user()->id);
        //                     })->where('start', '>=', $start)->where('end', '<=', $end)->count();

        $rules = [
            // 'tgl'           => 'required|date_format:Y-m-d',
            // 'start'         => [
            //                         'required',
            //                         'date_format:H:i',
            //                         'before:end',
            //                         Rule::when($duplicateStart != 0 || $duplicateBetween != 0, ['boolean'])
            //                     ],
            // 'end'           => [
            //                         'required',
            //                         'date_format:H:i',
            //                         'after:start',
            //                         Rule::when($duplicateEnd != 0 || $duplicateBetween != 0, ['boolean'])
            //                     ],
            'status'        => 'required',
            'kegiatan'      => 'required_if:status,1',
            'capaian'       => 'required_if:status,1',
            'edit-link'     => 'required_if:status,1|url',
            // 'edit-file'     => 'nullable|mimes:pdf|max:500',
            // 'catatan'       => 'required_if:status,2',
            'alasan'       => 'required_if:status,2',
        ];

        // ($duplicateBetween != 0) ? $timeMessage = 'Ada aktivitas di antara jam mulai dan selesai ini'
        //                          : $timeMessage = 'Sudah ada aktivitas pada jam ini';

        $customMessages = [
            'required' => ':attribute harus diisi',
            'required_if' => ':attribute harus diisi',
            'url' => ':attribute harus berupa url/link',
        ];
        
        $validator = Validator::make($request->all(), $rules, $customMessages, ['edit-link' => 'hasil kerja']);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);
        
        File::delete(public_path()."/document/realisasi/".$realisasi->hasil_kerja);

        // if (array_key_exists("edit-link", $validateData) && $validateData['edit-link'] != '') 
        //     $validateData['hasil_kerja'] = $validateData['edit-link'];

        // if (array_key_exists("edit-file", $validateData) && $validateData['edit-file'] != '') {
        //     $validateData['hasil_kerja'] =  'Realisasi_'.time().'.'.$validateData['edit-file']->getClientOriginalExtension();
        //     $validateData['edit-file']->move(public_path()."/document/realisasi/", $validateData['hasil_kerja']);
        // }

        $validateData['hasil_kerja'] = $validateData['edit-link'];
        $validateData['catatan'] = $request->catatan;
        if ($validateData['status'] == 2) {
            $validateData['kegiatan'] = null;
            $validateData['capaian'] = null;
            $validateData['catatan'] = null;
            $validateData['hasil_kerja'] = null;
        } else {
            $validateData['alasan'] = null;
            RealisasiKinerja::where('id_pelaksana', $request->id_pelaksana)
                            ->where('status', 1)->update(['status' => 2]);
        }
        
        $realisasiEdit = RealisasiKinerja::where('id', $id)->update(Arr::except($validateData, ['edit-link', 'edit-file']));
        
        // Event::where('id', $event->id)->update(['start' => $start, 'end' => $end]);

        $request->session()->put('status', 'Berhasil memperbarui data realisasi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $realisasiEdit
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $realisasi = RealisasiKinerja::where('id', $id)->first();
        $realisasi->delete();
           
        // $event = Event::where('id_pelaksana', $realisasi->id_pelaksana)
        //                 ->where('start', $realisasi->tgl.' '.$realisasi->start)
        //                 ->where('end', $realisasi->tgl.' '.$realisasi->end)->first();
        // $event->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!',
        ]);
    }
}
