<?php

namespace App\Http\Controllers;

use App\Models\JenisKompetensi;
use App\Models\KategoriKompetensi;
use App\Models\User;
use App\Models\Kompetensi;
use App\Models\MasterPenyelenggara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Http\Request;

class AnalisKompetensiController extends Controller
{
    protected $status = [
        1   => 'Disetujui',
        2   => 'Ditolak',
        3   => 'Menunggu Persetujuan'
    ];

    protected $colorText = [
        1   => 'success',
        2   => 'danger',
        3   => 'primary'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('analis_sdm');
        
        $kompetensi = Kompetensi::all();
        $pegawai = User::all();
        $penyelenggara = MasterPenyelenggara::all();
        $kategori = KategoriKompetensi::all();

        return view('analis-sdm.kelola-kompetensi.index',[
            'type_menu'     => 'kompetensi',
            'colorText'     => $this->colorText,
            'status'        => $this->status,
            'pegawai'       => $pegawai,
            'penyelenggara' => $penyelenggara,
            'kategori'      => $kategori,
            // 'nama_pps'       => $nama_pp,
            'role'          => 'analis sdm'
        ])->with('kompetensi', $kompetensi);
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

        $rules = [
            'pegawai_id'       => 'required',
            'teknis_id'            => 'required',
            'nama_pelatihan'            => 'required',
            'create-sertifikat'    => 'required|mimes:pdf|max:2048',
            'tgl_mulai'         => 'required|date|before_or_equal:tgl_selesai',
            'tgl_selesai'         => 'required|date|after_or_equal:tgl_mulai',
            'tgl_sertifikat'         => 'required|date',
            'durasi'         => 'required|decimal:0,2',
            'penyelenggara'         => 'required',
            'jumlah_peserta'         => 'nullable|integer',
            'ranking'         => 'nullable|integer',
        ];

        $messages = [
            'required' => 'Harus diisi',
            'required_if' => 'Harus diisi',
            'mimes' => 'Format file harus pdf',
            'max' => 'Ukuran file maksimal 2MB',
            'integer' => 'Angka bilangan bulat',
            'decimal' => 'Nilai maksimal memiliki 2 angka desimal. Contoh: 98.67',
            'before_or_equal' => 'Tanggal mulai tidak boleh setelah tanggal selesai.',
            'after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        $validateData['sertifikat'] =  time().'.'.$validateData['create-sertifikat']->getClientOriginalExtension();
        $validateData['create-sertifikat']->move(public_path()."/document/sertifikat/", $validateData['sertifikat']);

        $validateData['status'] = 1;
        $validateData['approved_by'] = auth()->user()->id;
        $validateData['tgl_upload'] = now();
        $validateData['tgl_approve'] = now();
        // $validateData['catatan'] = $request->catatan;

        // $validateData = $request->validate($rules);

        Kompetensi::create($validateData);
        $request->session()->put('status', 'Berhasil menambahkan kompetensi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah kompetensi pegawai.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterPimpinan  $masterPimpinan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('analis_sdm');
        
        $kompetensi = Kompetensi::findOrFail($id);

        return view('components.kelola-kompetensi.show',[
            'type_menu'     => 'kompetensi',
            'role'          => 'analis-sdm',
            'colorText'     => $this->colorText,
            'status'        => $this->status,
        ])->with('kompetensi', $kompetensi);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterPimpinan  $masterPimpinan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterPimpinanRequest  $request
     * @param  \App\Models\MasterPimpinan  $masterPimpinan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('analis_sdm');

        if ($request->terima) {
            $kompetensiEdit = Kompetensi::where('id', $id)->update([
                'status' => 1,
                'approved_by' => auth()->user()->id,
                'tgl_approve' => now()
            ]);

            $request->session()->put('status', 'Berhasil menyetujui data kompetensi.');
            $request->session()->put('alert-type', 'success');

            return response()->json([
                'success'   => true,
                'message'   => 'Data Berhasil Diperbarui',
                'data'      => $kompetensiEdit
            ]);
        }

        if ($request->tolak) {
            $request->validate(['catatan' => 'required'], ['required' => 'Harus diisi']);

            $kompetensiEdit = Kompetensi::where('id', $id)->update([
                'catatan' => $request->catatan,
                'status' => 2,
                'approved_by' => auth()->user()->id,
                'tgl_approve' => null
            ]);

            $request->session()->put('status', 'Berhasil menolak data kompetensi.');
            $request->session()->put('alert-type', 'success');

            return response()->json([
                'success'   => true,
                'message'   => 'Data Berhasil Diperbarui',
                'data'      => $kompetensiEdit
            ]);
        }

        $kompetensi = Kompetensi::find($id);

        $rules = [
            'edit-teknis_id'            => 'required',
            'edit-nama_pelatihan'            => 'required',
            'edit-sertifikat'     => 'nullable|mimes:pdf|max:2048',
            'edit-tgl_mulai'         => 'required|date|before_or_equal:edit-tgl_selesai',
            'edit-tgl_selesai'         => 'required|date|after_or_equal:edit-tgl_mulai',
            'edit-tgl_sertifikat'         => 'required|date',
            'edit-durasi'         => 'required|decimal:0,2',
            'edit-penyelenggara'         => 'required',
            'edit-jumlah_peserta'         => 'nullable|integer',
            'edit-ranking'         => 'nullable|integer',
        ];

        $messages = [
            'required' => 'Harus diisi',
            'required_if' => 'Harus diisi',
            'mimes' => 'Format file harus pdf',
            'max' => 'Ukuran file maksimal 2MB',
            'integer' => 'Angka bilangan bulat',
            'decimal' => 'Nilai maksimal memiliki 2 angka desimal. Contoh: 98.67',
            'before_or_equal' => 'Tanggal mulai tidak boleh setelah tanggal selesai.',
            'after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);
        // dd(isset($validateData['edit-pp_lain']));
        $data = [
            'teknis_id'     => $validateData['edit-teknis_id'],
            'nama_pelatihan'   => $validateData['edit-nama_pelatihan'],
            // 'catatan'      => $request['edit-catatan'],
            'tgl_mulai' => $validateData['edit-tgl_mulai'],
            'tgl_selesai' => $validateData['edit-tgl_selesai'],
            'tgl_sertifikat' => $validateData['edit-tgl_sertifikat'],
            'durasi' => $validateData['edit-durasi'],
            'penyelenggara' => $validateData['edit-penyelenggara'],
            'jumlah_peserta' => $validateData['edit-jumlah_peserta'],
            'ranking' => $validateData['edit-ranking'],
        ];

        if ($request['edit-sertifikat']) {
            $sertifikat = $request['edit-sertifikat'];
            File::delete(public_path()."/document/sertifikat/".$kompetensi->sertifikat);
            $data['sertifikat'] = time().'.'.$sertifikat->getClientOriginalExtension();
            $sertifikat->move(public_path()."/document/sertifikat/", $data['sertifikat']);
            $data['tgl_upload'] = now();
        }

        $kompetensiEdit = Kompetensi::where('id', $id)->update($data);

        $request->session()->put('status', 'Berhasil memperbarui data kompetensi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $kompetensiEdit
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterPimpinan  $masterPimpinan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('analis_sdm');

        $kompetensi = Kompetensi::find($id);
        File::delete(public_path()."/document/sertifikat/".$kompetensi->sertifikat);

        Kompetensi::destroy($id);
        $request->session()->put('status', 'Berhasil menghapus data kompetensi.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data kompetensi',
        ]);
    }

    public function getData($id)
    {
        $this->authorize('analis_sdm');
        
        $kompetensi = Kompetensi::where('id', $id)->get();
        $penyelenggara = $kompetensi->first()->penyelenggaraDiklat->id;
        $kategori = $kompetensi->first()->teknis->jenis->kategori->id;
        
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Kompetensi',
            'data'    => $kompetensi,
            'penyelenggara' => $penyelenggara,
            'kategori' => $kategori
        ]);
    }

}
