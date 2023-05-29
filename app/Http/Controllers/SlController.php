<?php

namespace App\Http\Controllers;

use App\Models\Sl;
use App\Http\Requests\StoreSlRequest;
use App\Http\Requests\UpdateSlRequest;
use Illuminate\Support\Facades\Storage;

class SlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = '';

        return view('pegawai.surat-lain.index', [
            "title" => "Surat Lain" . $title,
            "type_menu" => "surat-saya",
            // "usulan" => UsulanNomor::all()
            "usulan" => Sl::latest()->where('user_id', '=', auth()->user()->id)->filter(request(['search']))->paginate(5)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pegawai.surat-lain.create', [
            "title" => "Form Surat Lain",
            "type_menu" => "surat-saya"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSlRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSlRequest $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required',
            'kegiatan' => 'required',
            'subkegiatan' => 'required',
            'jenis_surat_id' => 'required',
            'kka' => 'required',
            'status' => 'required'
        ], [
            'required' => 'Wajib diisi'
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        Sl::create($validatedData);

        return redirect('pegawai/surat-lain')->with('success', 'Berhasil mengajukan usulan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function show(Sl $surat_lain)
    {
        return view('pegawai.surat-lain.show', [
            "title" => "Detail Usulan Surat Lain",
            "type_menu" => "surat-saya",
            "usulan" => $surat_lain
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function edit(Sl $surat_lain)
    {
        return view('pegawai.surat-lain.edit', [
            "title" => "Edit Usulan",
            "type_menu" => "surat-saya",
            "usulan" => $surat_lain
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSlRequest  $request
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSlRequest $request)
    {
        if ($request->input('status') == '2' || $request->input('status') == '4') {
            $validatedData = $request->validate([
                'status' => 'required',
                'no_surat' => 'required',
                'surat' => 'required|mimes:pdf'
            ], [
                'required' => 'Wajib diisi',
                'mimes' => 'File yang diupload harus bertipe .pdf'
            ]);
            $pesan = ($request->input('status') == '2') ? 'Berhasil mengunggah file!' : 'Berhasil mengunggah ulang file!';
            $validatedData['status'] = '3';
            $no_surat = $request->input('no_surat');
            $surat = $request->input('surat');
            if ($surat) {
                Storage::delete($surat);
            }
            $validatedData['surat'] = $request->file('surat')->store('surat-lain-update');
            Sl::where('no_surat', $no_surat)->update($validatedData);
            return redirect('/pegawai/surat-lain')->with('success', $pesan);
        } elseif ($request->input('status') == '1') {
            $validatedData = $request->validate([
                'tanggal' => 'required',
                'kegiatan' => 'required',
                'subkegiatan' => 'required',
                'jenis_surat_id' => 'required',
                'kka' => 'required',
                'status' => 'required'
            ], [
                'required' => 'Wajib diisi'
            ]);
            $validatedData['status'] = '0';
            $id = $request->input('id');
            Sl::where('id', $id)->update($validatedData);
            return redirect('/pegawai/surat-lain')->with('success', 'Berhasil mengedit usulan nomor surat!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sl $sl)
    {
        //
    }

    public function upload()
    {
        return view('pegawai.surat-lain.upload', [
            "title" => "Upload Surat",
            "type_menu" => "surat-saya"
        ]);
    }

    // public function uploadFile(UpdateSlRequest $request)
    // {
    //     $no_surat = $request->no_surat;
    //     $file_name = $request->file('fileToUpload')->store('surat-lain-update');
    //     Sl::where('no_surat', $no_surat)->update(['surat' => $file_name, 'status' => '3']);
    //     return redirect('/pegawai/surat-lain')->with('success', 'Berhasil mengunggah file!');
    // }

    // public function suratUpdate(UpdateSlRequest $request)
    // {
    //     $no_surat = $request->no_surat;
    //     $file_name = $request->file('fileToUpload')->store('surat-lain-update');
    //     Sl::where('no_surat', $no_surat)->update(['surat' => $file_name, 'status' => '3']);
    //     return redirect('/pegawai/surat-lain');
    // }
}
