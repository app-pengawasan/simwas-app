<?php

namespace App\Http\Controllers;

use App\Models\LaporanObjekPengawasan;
use App\Models\NilaiInspektur;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\RencanaKerja;
use App\Models\TimKerja;
use App\Models\UsulanSuratSrikandi;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Time;

class AdminRekapNilaiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('admin');

        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $unit = $request->unit;

        if ($unit == null || $unit == '8000') $pegawai = User::get();
        else $pegawai = User::where('unit_kerja', $unit)->get();

        $nilai = NilaiInspektur::where('tahun', $year)->get();
        $rekap = [];
        
        $nilai_arr = $nilai->groupBy(['id_pegawai', 'bulan'])->map->map(function ($item) {
                            return $item[0]->nilai;
                        })->toArray();

        $nilai_avg = $nilai->groupBy('id_pegawai')->map(function ($items) {
                            return $items->avg->nilai;
                        })->toArray();

        foreach ($pegawai as $user) {
            $rekap[$user->id] = $nilai_arr[$user->id] ?? [];
            $rekap[$user->id]['avg'] = $nilai_avg[$user->id] ?? 0;
            $rekap[$user->id]['nama'] = $user->name;
        }

        return view('admin.rekap-nilai.index',[
            'type_menu'     => 'rekap-nilai'
        ])->with('rekap', $rekap);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $year)
    {
        // $this->authorize('admin');

        // $tugas = PelaksanaTugas::where('id_pegawai', $id)
        //         ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
        //             $query->whereIn('status', [1,2])->where('tahun', $year);
        //         })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as total')
        //           ->get();

        // $pegawai = User::findOrFail($id)->name;

        // return view('admin.rencana-jam-kerja.show',[
        //     'type_menu'     => 'rencana-jam-kerja',
        //     'jabatan'       => $this->jabatan,
        //     'pegawai'       => $pegawai
        // ])->with('tugas', $tugas);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $start = $request->tgl.' '.$request->start;
    //     $end = $request->tgl.' '.$request->end;
    //     $duplicateStart = Event::where('start', '<=', $start)->where('end', '>', $start)->count();
    //     $duplicateEnd = Event::where('start', '<=', $end)->where('end', '>', $end)->count();

    //     $rules = [
    //         'id_pelaksana'   => 'required',
    //         'start'             => [
    //                                     'required',
    //                                     'date_format:H:i',
    //                                     'before:end',
    //                                     Rule::when($duplicateStart != 0 , ['boolean'])
    //                                ],
    //         'end'               => [
    //                                     'required',
    //                                     'date_format:H:i',
    //                                     'after:start',
    //                                     Rule::when($duplicateStart != 0 && $duplicateEnd != 0, ['boolean'])
    //                                 ],
    //         'aktivitas'         => 'required',
    //     ];

    //     $customMessages = [
    //         'boolean' => 'Sudah ada aktivitas pada jam ini',
    //         'required' => ':attribute harus diisi',
    //         'date_format' => 'Format jam harus JJ:MM',
    //         'before' => 'Jam mulai harus sebelum jam selesai',
    //         'after' => 'Jam selesai harus setelah jam mulai',
    //     ];

    //     $validator = Validator::make($request->all(), $rules, $customMessages)
    //                 ->setAttributeNames(
    //                     [
    //                         'id_pelaksana' => 'Tugas',
    //                         'aktivitas' => 'Aktivitas',
    //                     ], // Your field name and alias
    //                 );

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $validateData = $request->validate($rules);
    //     $validateData['start'] = $start;
    //     $validateData['end'] = $end;

    //     Event::create($validateData);
    //     $request->session()->put('status', 'Berhasil menambahkan aktivitas.');
    //     $request->session()->put('alert-type', 'success');

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Berhasil menambah aktivitas.',
    //     ]);
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $event = Event::where('id', $id)->get();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Detail Data Event',
    //         'data'    => $event
    //     ]);
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $rules = [
    //         'start'             => 'required|date_format:H:i|before:end',
    //         'end'               => 'required|date_format:H:i|after:start',
    //         'aktivitas'         => 'required',
    //         'tgl'               => 'required|date_format:Y-m-d',
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $validateData = $request->validate($rules);
    //     $validateData['start'] = $request->tgl.' '.$request->start;
    //     $validateData['end'] = $request->tgl.' '.$request->end;

    //     $eventEdit = Event::where('id', $id)->update(Arr::except($validateData, ['tgl']));

    //     $request->session()->put('status', 'Berhasil memperbarui data aktivitas.');
    //     $request->session()->put('alert-type', 'success');

    //     return response()->json([
    //         'success'   => true,
    //         'message'   => 'Data Berhasil Diperbarui',
    //         'data'      => $eventEdit
    //     ]);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Request $request, $id)
    // {
    //     Event::destroy($id);
    //     $request->session()->put('status', 'Berhasil menghapus data aktivitas.');
    //     $request->session()->put('alert-type', 'success');

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Berhasil menghapus data aktivitas',
    //     ]);
    // }
}
