<?php

namespace App\Http\Controllers;

use App\Models\ChangelogsIsi;
use App\Models\ChangelogsJudul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChangelogsController extends Controller
{
    public function index_judul()
    {
        $this->authorize('admin');

        $changelog = ChangelogsJudul::all();
        $last_version = ChangelogsJudul::orderby('created_at', 'desc')->first();
        $versi = null;
        if ($last_version == null) {
           $versi == "Belum ada"; 
        }else{
            $versi = $last_version->versi;
        }

        return view('admin.changelog.index_judul', [
            'type_menu'     => 'changelogs',
        ])->with('changelog', $changelog)->with('versi', $versi);
    }

    public function index_isi()
    {
        $this->authorize('admin');

        $changelog = DB::table('isi_changelog')->join('judul_changelog', 'isi_changelog.id_judulchangelog', '=', 'judul_changelog.id_judulchangelog')->get();
        $versi = ChangelogsJudul::all();

        return view('admin.changelog.index_isi', [
            'type_menu'     => 'changelogs'
        ])->with('changelog', $changelog)->with('versi', $versi);
    }

    public function simpan_judul(Request $request)
    {
        $rules = [
            'judul'             => 'required',
            'versi'             => 'required',
            'tgl_changelog'     => 'required',
            'keterangan'        => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);
        ChangelogsJudul::create($validateData);

        $request->session()->put('status', 'Berhasil menambahkan data Changelogs.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah Judul Changelogs',
        ]);
    }

    public function simpan_isi(Request $request)
    {
        $rules = [
            'id_judulchangelog' => 'required',
            'isi'               => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);
        ChangelogsIsi::create($validateData);

        $request->session()->put('status', 'Berhasil menambahkan data Changelogs.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah Changelogs',
        ]);
    }

    public function edit_judul($id)
    {
        $changelog = ChangelogsJudul::where('id_judulchangelog', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Detail versi changelog',
            'data'      => $changelog
        ]);
    }

    public function update_judul(Request $request, $id)
    {
        $rules = [
            'judul'             => 'required',
            'versi'             => 'required',
            'keterangan'        => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        ChangelogsJudul::where('id_judulchangelog', $id)
            ->update([
                'judul'      => $request->judul,
                'versi'      => $request->versi,
                'keterangan' => $request->keterangan
            ]);

        $request->session()->put('status', 'Berhasil memperbarui data Versi Changelogs');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
        ]);
    }

    public function edit_isi($id)
    {
        $changelog = DB::table('isi_changelog')
            ->join('judul_changelog', 'isi_changelog.id_judulchangelog', '=', 'judul_changelog.id_judulchangelog')
            ->where('id_isichangelog', $id)
            ->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Detail changelog',
            'data'      => $changelog
        ]);
    }

    public function update_isi(Request $request, $id)
    {
        $rules = [
            'isi'               => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        };

        ChangelogsIsi::where('id_isichangelog', $id)
            ->update([
                'isi'                 => $request->isi
            ]);

        $request->session()->put('status', 'Berhasil memperbarui data Isi Changelogs');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
        ]);
    }

    public function hapus_judul(Request $request, $id)
    {
        ChangelogsJudul::destroy($id);
        $request->session()->put('status', 'Berhasil menghapus data Versi Changelogs.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data Versi Changelogs',
        ]);
    }

    public function hapus_isi(Request $request, $id)
    {
        ChangelogsIsi::destroy($id);
        $request->session()->put('status', 'Berhasil menghapus data Changelogs.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data Changelogs',
        ]);
    }

    public function getChangelogs()
    {
        // $changelog = DB::table('isi_changelog')
        //     ->join('judul_changelog', 'isi_changelog.id_judulchangelog', '=', 'judul_changelog.id_judulchangelog')            
        //     ->orderBy('judul_changelog.id_judulchangelog')
        //     ->get();

        $changelog = ChangelogsJudul::with('changelogsisi')->get();
        return response()->json([
            'changelog' => $changelog,
        ]);
    }
}
