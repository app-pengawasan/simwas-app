<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PelaksanaTugas;
use App\Models\RealisasiKinerja;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class AktivitasHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::whereRelation('pelaksana', function (Builder $query){
                        $query->where('id_pegawai', auth()->user()->id);
                  })->get();

        foreach ($events as $event) {
            $realisasi = RealisasiKinerja::where('id_pelaksana', $event->id_pelaksana)
                        ->where('tgl', date_format(date_create($event->start), 'Y-m-d'))
                        ->where('start', date_format(date_create($event->start), 'H:i:s'))
                        ->where('end', date_format(date_create($event->end), 'H:i:s'))->first();

            $event->title = $event->pelaksana->rencanaKerja->tugas;
            $event->tim = $event->pelaksana->rencanaKerja->proyek->timkerja->nama;
            $event->proyek = $event->pelaksana->rencanaKerja->proyek->nama_proyek;
            $event->status = $realisasi->status;
            $event->hasil_kerja = $realisasi->hasil_kerja;
            $event->catatan = $realisasi->catatan;
        }

        $tugasSaya = PelaksanaTugas::where('id_pegawai', auth()->user()->id)
                    ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query){
                        $query->where('status', 6);
                    })->get();
                    
        return view('pegawai.aktivitas-harian.index',[
            'type_menu'     => 'realisasi-kinerja',
            'tugasSaya'     => $tugasSaya
        ])->with('events', $events);
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
        $start = $request->tgl.' '.$request->start;
        $end = $request->tgl.' '.$request->end;
        $duplicateStart = Event::where('start', '<=', $start)->where('end', '>', $start)->count();
        $duplicateEnd = Event::where('start', '<=', $end)->where('end', '>', $end)->count();
        
        $rules = [
            'id_pelaksana'   => 'required',
            'start'             => [
                                        'required',
                                        'date_format:H:i',
                                        'before:end',
                                        Rule::when($duplicateStart != 0 , ['boolean'])
                                   ],
            'end'               => [
                                        'required',
                                        'date_format:H:i',
                                        'after:start',
                                        Rule::when($duplicateStart != 0 && $duplicateEnd != 0, ['boolean'])
                                    ],
            // 'aktivitas'         => 'required',
        ];

        $customMessages = [
            'boolean' => 'Sudah ada aktivitas pada jam ini',
            'required' => ':attribute harus diisi',
            'date_format' => 'Format jam harus JJ:MM',
            'before' => 'Jam mulai harus sebelum jam selesai',
            'after' => 'Jam selesai harus setelah jam mulai',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages)
                    ->setAttributeNames(
                        [
                            'id_pelaksana' => 'Tugas',
                            'aktivitas' => 'Aktivitas',
                        ], // Your field name and alias
                    );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);
        $validateData['start'] = $start;
        $validateData['end'] = $end;

        Event::create($validateData);
        $request->session()->put('status', 'Berhasil menambahkan aktivitas.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah aktivitas.',
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
        $event = Event::where('id', $id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Event',
            'data'    => $event
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $start = $request->tgl.' '.$request->start;
        $end = $request->tgl.' '.$request->end;

        $eventEdit = Event::where('id', $id)->first();
        //cek duplikat jam mulai
        $duplicateStart = Event::whereNot('id', $eventEdit->id)
                            ->whereRelation('pelaksana', function (Builder $query){   
                                $query->where('id_pegawai', auth()->user()->id);
                            })->where('start', '<=', $start)->where('end', '>', $start)->count();
        //cek duplikat jam selesai
        $duplicateEnd = Event::whereNot('id', $eventEdit->id)
                            ->whereRelation('pelaksana', function (Builder $query){  
                                $query->where('id_pegawai', auth()->user()->id);
                            })->where('start', '<=', $end)->where('end', '>', $end)->count();
        //cek jam antara jam mulai dan jam selesai
        $duplicateBetween = Event::whereNot('id', $eventEdit->id)
                            ->whereRelation('pelaksana', function (Builder $query){   
                                $query->where('id_pegawai', auth()->user()->id);
                            })->where('start', '>=', $start)->where('end', '<', $end)->count();

        $rules = [
            'start'         => [
                                    'required',
                                    'date_format:H:i',
                                    'before:end',
                                    Rule::when($duplicateStart != 0 || $duplicateBetween != 0, ['boolean'])
                                ],
            'end'           => [
                                    'required',
                                    'date_format:H:i',
                                    'after:start',
                                    Rule::when($duplicateEnd != 0 || $duplicateBetween != 0, ['boolean'])
                                ],
            // 'aktivitas'         => 'required',
            'tgl'               => 'required|date_format:Y-m-d',
        ];

        ($duplicateBetween != 0) ? $timeMessage = 'Ada aktivitas di antara jam mulai dan selesai ini'
                                 : $timeMessage = 'Sudah ada aktivitas pada jam ini';

        $customMessages = [
            'boolean' => $timeMessage,
            'required' => ':attribute harus diisi',
            'date_format' => 'Format jam harus JJ:MM',
            'before' => 'Jam mulai harus sebelum jam selesai',
            'after' => 'Jam selesai harus setelah jam mulai',
        ];
        
        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);
        $validateData['start'] = $start;
        $validateData['end'] = $end; 

        RealisasiKinerja::where('id_pelaksana', $eventEdit->id_pelaksana)
            ->where('tgl', date_format(date_create($eventEdit->start), 'Y-m-d'))
            ->where('start', date_format(date_create($eventEdit->start), 'H:i:s'))
            ->where('end', date_format(date_create($eventEdit->end), 'H:i:s'))
            ->update($validateData);
            // ->update(Arr::except($validateData, ['aktivitas']));
        
        $eventEdit->update($validateData);

        $request->session()->put('status', 'Berhasil memperbarui data aktivitas.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $eventEdit
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
        $event = Event::findOrFail($id);

        RealisasiKinerja::where('id_pelaksana', $event->id_pelaksana)
            ->where('tgl', date_format(date_create($event->start), 'Y-m-d'))
            ->where('start', date_format(date_create($event->start), 'H:i:s'))
            ->where('end', date_format(date_create($event->end), 'H:i:s'))
            ->delete();

        $event->delete();

        $request->session()->put('status', 'Berhasil menghapus data aktivitas.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data aktivitas',
        ]);
    }
}
