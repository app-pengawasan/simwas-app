<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DataKepegawaian;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\MasterDataKepegawaian;
use App\Imports\DataKepegawaianImport;
use Maatwebsite\Excel\HeadingRowImport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class DataKepegawaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('analis_sdm');
        $masters = MasterDataKepegawaian::all()->where('is_aktif', true);
        return view('analis-sdm.data-kepegawaian.index', [
            "masters" => $masters,
            "type_menu" => 'data-kepegawaian'
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
            'is_aktif' => 'required',
            'jenis' => 'required|unique:master_data_kepegawaians'
        ],[
            'required' => 'Wajib diisi.',
            'unique' => 'Jenis data kepegawaian yang dimasukkan sudah ada.'
        ]);

        MasterDataKepegawaian::create($validatedData);

        return back()->with('status', 'Berhasil menambahkan jenis data kepegawaian!')->with('alert-type', 'success');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pp  $pp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->authorize('analis_sdm');
        if ($request->has('nonaktifkan')) {
            $validatedData = $request->validate([
                'is_aktif' => 'required'
            ]);
            MasterDataKepegawaian::where('id', $request->input('id'))->update($validatedData);
            return redirect('analis-sdm/master-data-kepegawaian')->with('success', 'Berhasil menonaktifkan jenis data kepegawaian!');
        } elseif ($request->has('aktifkan')) {
            $validatedData = $request->validate([
                'is_aktif' => 'required'
            ]);
            MasterDataKepegawaian::where('id', $request->input('id'))->update($validatedData);
            return redirect('analis-sdm/master-data-kepegawaian')->with('success', 'Berhasil mengaktifkan jenis data kepegawaian!');
        }
    }

    public function editNilai(Request $request, $id)
    {
        $this->authorize('analis_sdm');

        $rule = ['nilai' => 'decimal:0,2|between:0,100'];

        $validateData = request()->validate($rule);

        DataKepegawaian::where('id', $id)->update($validateData);

        $request->session()->put('status', 'Berhasil mengedit nilai.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui'
        ]);
    }

    public function nonaktif() {
        $this->authorize('analis_sdm');
        $masters = MasterDataKepegawaian::all()->where('is_aktif', false);
        return view('analis-sdm.data-kepegawaian.nonaktif', [
            "masters" => $masters,
            "type_menu" => 'data-kepegawaian'
        ]);
    }

    public function kelola() {
        $this->authorize('analis_sdm');
        $datas = DataKepegawaian::all();
        return view('analis-sdm.data-kepegawaian.kelola', [
            "datas" => $datas,
            "type_menu" => 'data-kepegawaian'
        ]);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request)
    {
        $this->authorize('analis_sdm');
        $validateFile = $request->validate([
            'file' => 'required|mimes::xls,xlsx'
        ]);

        $file = $request->file('file');
        $file_name = rand().$file->getClientOriginalName();
        $file->move(storage_path('/document/upload/'), $file_name);

        $header = (new HeadingRowImport)->toArray(storage_path('/document/upload/').$file_name);
        $rules = [
            'nip',
            'id_jenis_data_kepegawaian',
            'nilai',
        ];

        foreach($rules as $rule){
            if(!in_array($rule, $header[0][0])){
                File::delete(storage_path('/document/upload/').$file_name);
                return back()
                ->with('status', 'Gagal mengimpor data, format file tidak sesuai. Silahkan unduh format yang telah disediakan.')
                ->with('alert-type', 'danger');
            }
        }

        $array = Excel::toArray(new DataKepegawaianImport, storage_path('/document/upload/').$file_name);

        $assoc_array = array();
        foreach ($array[0] as $key => $value) {
            $new_key = $value['nip'] . $value['id_jenis_data_kepegawaian'];

            // Presence of combination of company_code and clerk_code in the assoc_array indicates that
            // there is duplicate entry in the Excel being imported. So, abort the process and report this to user.
            if (array_key_exists($new_key, $assoc_array)) {
                File::delete(storage_path('/document/upload/').$file_name);
                $error = "Terjadi duplikat untuk kombinasi NIP: ".$value['nip'].
                            " dan ID jenis data kepegawaian: ".$value['id_jenis_data_kepegawaian'];
                return back()
                ->with('status', $error)
                ->with('alert-type', 'danger');
            }

            $assoc_array[$new_key] = $value;
        }

        // $import = new DataKepegawaianImport(); 
        
        // $import->import(storage_path('/document/upload/').$file_name);
        try {
            Excel::import(new DataKepegawaianImport, storage_path('/document/upload/').$file_name);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $error = 'Gagal mengimpor data <br>';
            foreach ($failures as $failure) {
                $error = $error.'- Baris data ke-' . $failure->row() - 1 . ': ';
                foreach ($failure->errors() as $errors) {
                    $error = $error.$errors.' ';
                }
                $error = $error.'<br>';
            }
            File::delete(storage_path('/document/upload/').$file_name);
            return back()
                ->with('status', $error)
                ->with('alert-type', 'danger');
        }

        File::delete(storage_path('/document/upload/').$file_name);

        if (session()->has('duplikat')) {
            session()->forget('duplikat');
            return back()->with('status', 'Gagal mengimpor data, nilai pegawai sudah ada.')->with('alert-type', 'danger');
        }

        return back()->with('status', 'Berhasil mengimpor data pegawai.')->with('alert-type', 'success');
    }

    public function export() {
        $this->authorize('analis_sdm');
        $spreadsheet = IOFactory::load(public_path()."/document/data-kepegawaian-inspektorat-utama.xlsx");

        $sheetpegawai = $spreadsheet->getSheet(1);
        $users = User::all();
        foreach ($users as $key => $pegawai) {
            $row = $key + 2;
            $sheetpegawai->getCell('A'.$row)->setValueExplicit($pegawai->nip, DataType::TYPE_STRING2);
            $sheetpegawai->setCellValue('B'.$row, $pegawai->name);
        }

        $sheetjenis = $spreadsheet->getSheet(2);
        $jenis_data_kepegawaian = MasterDataKepegawaian::all();
        foreach ($jenis_data_kepegawaian as $key => $jenis) {
            $row = $key + 2;
            $sheetjenis->setCellValue('A'.$row, $jenis->id);
            $sheetjenis->setCellValue('B'.$row, $jenis->jenis);
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="data-kepegawaian-inspektorat-utama.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        die;
    }
}
