<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisKompetensi;
use App\Models\TeknisKompetensi;
use App\Models\KategoriKompetensi;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class KategoriKompetensiController extends Controller
{
    private $peserta = [
        '100' => 'Pengawasan (Auditor Pertama)',
        '200' => 'Pengawasan (Auditor Muda)',
        '300' => 'Pengawasan (Auditor Madya/Utama)',
        '400' => 'Pengawasan (semua jenjang)',
        '500' => 'Manajemen',
        '600' => 'Pengelolaan Keuangan dan Barang',
        '700' => 'Sumber Daya Manusia',
        '800' => 'Arsip dan Diseminasi Pengawasan',
        '900' => 'Teknologi Informasi dan Multimedia',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('analis_sdm');
        $kategori = KategoriKompetensi::all();
        return view('analis-sdm.master-pp.index', [
            "kategori" => $kategori,
            "type_menu" => 'kompetensi'
        ]);
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
        $this->authorize('analis_sdm');
        $validatedData = $request->validate([
            'nama' => 'required|unique:kategori_kompetensis'
        ],[
            'required' => 'Wajib diisi.',
            'unique' => 'Jenis PP yang dimasukkan sudah ada.'
        ]);

        KategoriKompetensi::create($validatedData);

        return redirect('/analis-sdm/kategori')->with('success', 'Berhasil menambahkan kategori kompetensi!');
    }

    public function show(KategoriKompetensi $kategori)
    {
        $this->authorize('analis_sdm');
        $jenisKomp = JenisKompetensi::where('kategori_id', $kategori->id)->get();
        return view('analis-sdm.master-pp.jenis', [
            "kategori" => $kategori,
            "jenisKomp" => $jenisKomp,
            "type_menu" => 'kompetensi'
        ]);
    }

    public function edit(KategoriKompetensi $pp)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->authorize('analis_sdm');
        
        KategoriKompetensi::where('id', $id)->update([
            'nama' => $request->nama
        ]);

        $request->session()->put('status', 'Berhasil mengedit kategori kompetensi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui'
        ]);
    }

    public function destroy(KategoriKompetensi $kategori)
    {
        $this->authorize('analis_sdm');
        $kategori->delete();
        return redirect('/analis-sdm/kategori') ->with('success', 'Berhasil menghapus kategori kompetensi!');
    }

    public function export()
    {
        $this->authorize('analis_sdm');
        
        $kategoris = KategoriKompetensi::with('jenis')->get();
        $mySpreadsheet = new Spreadsheet();
        $sheet = $mySpreadsheet->getSheet(0);
        $data = [
            ['Kategori', 'Jenis', 'Teknis']
        ];

        foreach ($kategoris as $kategori) {
            if ($kategori->jenis->count() == 0) array_push($data, [$kategori->nama, null, null]);
            else {
                foreach ($kategori->jenis as $jenis) {
                    if ($jenis->teknis->count() == 0) array_push($data, [$kategori->nama, $jenis->nama, null]);
                    else {
                        foreach ($jenis->teknis as $teknis) {
                            array_push($data, [$kategori->nama, $jenis->nama, $teknis->nama]);
                        }
                    }
                }
            }
        } 

        $sheet->fromArray($data);
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true); //resize kolom
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Master Kompetensi Pegawai.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($mySpreadsheet, 'Xlsx');
        $writer->save('php://output');
        die;
    }
}
