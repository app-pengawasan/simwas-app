<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\TimKerja;
use App\Models\MasterHasil;
use Illuminate\Support\Arr;
use App\Models\RencanaKerja;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\ObjekPengawasan;
use App\Models\AnggaranRencanaKerja;
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
        $events = Event::with('rencanaKerja')->get();
        foreach ($events as $event) {
            $event->title = $event->rencanaKerja->tugas;
        }
        $tugasSaya = PelaksanaTugas::where('id_pegawai', auth()->user()->id)
                    ->whereRelation('rencanaKerja.timKerja', function (Builder $query){
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
        // dd($request->all());
        
        $rules = [
            'id_rencanakerja'   => 'required',
            'start'             => 'required|date_format:H:i|before:end',
            'end'               => 'required|date_format:H:i|after:start',
            'aktivitas'         => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);
        $validateData['start'] = $request->tgl.' '.$request->start;
        $validateData['end'] = $request->tgl.' '.$request->end;

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
        $rules = [
            'start'             => 'required|date_format:H:i|before:end',
            'end'               => 'required|date_format:H:i|after:start',
            'aktivitas'         => 'required',
            'tgl'               => 'required|date_format:Y-m-d',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);
        $validateData['start'] = $request->tgl.' '.$request->start;
        $validateData['end'] = $request->tgl.' '.$request->end;

        $eventEdit = Event::where('id', $id)->update(Arr::except($validateData, ['tgl']));

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
        Event::destroy($id);
        $request->session()->put('status', 'Berhasil menghapus data aktivitas.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data aktivitas',
        ]);
    }
}
