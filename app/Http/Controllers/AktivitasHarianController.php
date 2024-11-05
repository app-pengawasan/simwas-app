<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\LaporanObjekPengawasan;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use Illuminate\Validation\Rule;
use App\Models\RealisasiKinerja;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class AktivitasHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tugasSaya = PelaksanaTugas::where('id_pegawai', auth()->user()->id)
                    ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query){
                        $query->whereIn('status', [1,2]);
                    })->get();

        $events = Event::whereRelation('laporanOPengawasan.objekPengawasan', function (Builder $query) use ($tugasSaya) {
                        $query->whereIn('id_rencanakerja', $tugasSaya->pluck('id_rencanakerja'));
                  })->get();

        foreach ($events as $event) {
            $realisasi = RealisasiKinerja::where('id_laporan_objek', $event->laporan_opengawasan)
                         ->whereRelation('pelaksana', function (Builder $query){
                            $query->where('id_pegawai', auth()->user()->id);
                         })->get();

            if ($realisasi->isEmpty()) $event->color = 'orange';
            else {
                if ($realisasi->contains('status', 1)) $event->color = 'green';
                elseif ($realisasi->contains('status', 2)) $event->color = 'red';
                else $event->color = 'black';
            }

            $event->title = $event->laporanOPengawasan->objekPengawasan->rencanaKerja->tugas;
        }

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
        //cek duplikat jam mulai
        $duplicateStart = Event::whereRelation('user', function (Builder $query){
                                $query->where('id_pegawai', auth()->user()->id);
                            })->where('start', '<=', $start)->where('end', '>', $start)->count();
        //cek duplikat jam selesai
        $duplicateEnd = Event::whereRelation('user', function (Builder $query){
                            $query->where('id_pegawai', auth()->user()->id);
                        })->where('start', '<', $end)->where('end', '>=', $end)->count();
        //cek jam antara jam mulai dan jam selesai
        $duplicateBetween = Event::whereRelation('user', function (Builder $query){
                                $query->where('id_pegawai', auth()->user()->id);
                            })->where('start', '>=', $start)->where('end', '<=', $end)->count();
        // $duplicateStart = Event::where('start', '<=', $start)->where('end', '>', $start)->count();
        // $duplicateEnd = Event::where('start', '<=', $end)->where('end', '>', $end)->count();

        $rules = [
            'laporan_opengawasan'   => 'required',
            'start'             => [
                                        'required',
                                        'date_format:H:i',
                                        'before:end',
                                        Rule::when($duplicateStart != 0 || $duplicateBetween != 0, ['boolean'])
                                   ],
            'end'               => [
                                        'required',
                                        'date_format:H:i',
                                        'after:start',
                                        Rule::when($duplicateEnd != 0 || $duplicateBetween != 0, ['boolean'])
                                    ],
            'aktivitas'         => 'required',
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
                            'laporan_opengawasan' => 'Bulan Pelaporan',
                            'aktivitas' => 'Aktivitas',
                        ], // Your field name and alias
                    );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        $validateData['start'] = $start;
        $validateData['end'] = $end;
        $validateData['id_pegawai'] = auth()->user()->id;

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
        $id_rencanakerja = $event->first()->laporanOPengawasan->objekPengawasan->id_rencanakerja;

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Event',
            'data'    => $event,
            'id_rencanakerja' => $id_rencanakerja
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
                            ->whereRelation('user', function (Builder $query){
                                $query->where('id_pegawai', auth()->user()->id);
                            })->where('start', '<=', $start)->where('end', '>', $start)->count();
        //cek duplikat jam selesai
        $duplicateEnd = Event::whereNot('id', $eventEdit->id)
                            ->whereRelation('user', function (Builder $query){
                                $query->where('id_pegawai', auth()->user()->id);
                            })->where('start', '<=', $end)->where('end', '>', $end)->count();
        //cek jam antara jam mulai dan jam selesai
        $duplicateBetween = Event::whereNot('id', $eventEdit->id)
                            ->whereRelation('user', function (Builder $query){
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
            'aktivitas'         => 'required',
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

        // RealisasiKinerja::where('id_pelaksana', $eventEdit->id_pelaksana)
        //     ->where('tgl', date_format(date_create($eventEdit->start), 'Y-m-d'))
        //     ->where('start', date_format(date_create($eventEdit->start), 'H:i:s'))
        //     ->where('end', date_format(date_create($eventEdit->end), 'H:i:s'))
        //     ->update($validateData);
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

        $event->delete();

        $request->session()->put('status', 'Berhasil menghapus data aktivitas.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data aktivitas',
        ]);
    }

    public function export($bulan, $tahun) 
    {
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                  'Oktober', 'November', 'Desember'];
        $events = Event::whereMonth('start', $bulan)->whereYear('start', $tahun)
                    ->whereRelation('user', function (Builder $query){
                        $query->where('id_pegawai', auth()->user()->id);
                    })->orderBy('start')->get();
        
        $mySpreadsheet = new Spreadsheet();
        $sheet = $mySpreadsheet->getSheet(0);
        $sheet1Data = [
            ["No.", "Hari", "Tanggal", "Waktu", "Tugas", 'Bulan Pelaporan', "Aktivitas"]
        ];

        foreach ($events as $key => $event) {
            $start = date_create($event->start);
            $end = date_create($event->end);

            array_push($sheet1Data, [
                                        $key + 1, 
                                        $hari[date_format($start, 'N') - 1],
                                        date_format($start, 'd-m-Y'), 
                                        date_format($start, 'H:i').' - '.date_format($end, 'H:i'),
                                        $event->laporanOPengawasan->objekPengawasan->rencanakerja->tugas,
                                        $months[$event->laporanOPengawasan->month - 1],
                                        preg_replace("/\r|\n/", "; ", $event->aktivitas)
                                    ]
            );
        }

        $sheet->fromArray($sheet1Data);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true); //resize kolom
        }

        $nama_pegawai = $events[0]->pelaksana->user->name ?? '';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Aktivitas Harian '
                .$nama_pegawai ?? ''.' '.$bulan.'-'.$tahun.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($mySpreadsheet, 'Xlsx');
        $writer->save('php://output');
        die;
    }

    public function getBulanPelaporan($id_rencanakerja)
    {
        $data = LaporanObjekPengawasan::whereRelation('objekPengawasan', function (Builder $query) use ($id_rencanakerja) {
                    $query->where('id_rencanakerja', $id_rencanakerja);
                })->where('status', 1)->get();

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }
}
