<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Facades\Validator;

class MasterPegawaiController extends Controller
{
    protected $pangkat = [
        'II/a' =>	'Pengatur Muda',
        'II/b' =>	'Pengatur Muda Tingkat I',
        'II/c' => 	'Pengatur',
        'II/d' => 	'Pengatur Tingkat I',
        'III/a' =>	'Penata Muda',
        'III/b' =>	'Penata Muda Tingkat I',
        'III/c' =>	'Penata',
        'III/d' =>	'Penata Tingkat I',
        'IV/a' =>	'Pembina',
        'IV/b' =>	'Pembina Tingkat I',
        'IV/c' =>	'Pembina Muda',
        'IV/d' =>	'Pembina Madya',
        'IV/e' =>	'Pembina Utama'
    ];

    protected $unit_kerja = [
        '8000' => 'Inspektorat Utama',
        '8010' => 'Bagian Umum Inspektorat Utama',
        '8100' => 'Inspektorat Wilayah I',
        '8200' => 'Inspektorat Wilayah II',
        '8300' => 'Inspektorat Wilayah III'
    ];

    protected $jabatan = [
        '10' => 'Inspektur Utama',
        '11' => 'Inspektur Wilayah I',
        '12' => 'Inspektur wilayah II',
        '13' => 'Inspektur wilayah III',
        '14' => 'Kepala Bagian Umum',
        '21' =>	'Auditor Utama',
        '22' =>	'Auditor Madya',
        '23' =>	'Auditor Muda',
        '24' =>	'Auditor Pertama',
        '25' =>	'Auditor Penyelia',
        '26' =>	'Auditor Pelaksana Lanjutan',
        '27' =>	'Auditor Pelaksana',
        '31' =>	'Perencana Madya',
        '32' =>	'Perencana Muda',
        '33' =>	'Perencana Pertama',
        '41' =>	'Analis Kepegawaian Madya',
        '42' =>	'Analis Kepegawaian Muda',
        '43' =>	'Analis Kepegawaian Pertama',
        '51' =>	'Analis Pengelolaan Keuangan APBN Madya',
        '52' =>	'Analis Pengelolaan Keuangan APBN Muda',
        '53' =>	'Analis Pengelolaan Keuangan APBN Pertama',
        '61' =>	'Pranata Komputer Madya',
        '62' =>	'Pranata Komputer Muda',
        '63' =>	'Pranata Komputer Pratama',
        '71' =>	'Arsiparis Madya',
        '72' =>	'Arsiparis Muda',
        '73' =>	'Arsiparis Pertama',
        '81' =>	'Analis Hukum Madya',
        '82' =>	'Analis Hukum Muda',
        '83' =>	'Analis Hukum Pertama',
        '91' =>	'Penatalaksana Barang',
        '90' =>	'Fungsional Umum'
    ];

    protected $role = [
        'is_admin'      => 'Admin',
        'is_sekma'      => 'Sekretaris Utama',
        'is_sekwil'     => 'Sekretaris Wilayah',
        'is_perencana'  => 'Perencana',
        'is_apkapbn'    => 'APK-APBN',
        'is_opwil'      => 'Operator Wilayah',
        'is_analissdm'  => 'Analis SDM',
        'is_arsiparis'  => 'Arsiparis',
        'is_aktif'      => 'Inspektur'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin');
        $users = User::all();
        return view('admin.master-pegawai.index', [
            'type_menu' => 'master-pegawai',
            'pangkat'       => $this->pangkat,
            'unit_kerja'    => $this->unit_kerja,
            'jabatan'       => $this->jabatan,
            'role'          => $this->role
            ])->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllPegawai()
    {
        $url_base       = 'https://sso.bps.go.id/auth/';
        $url_token      = $url_base.'realms/pegawai-bps/protocol/openid-connect/token';
        $url_api        = $url_base.'realms/pegawai-bps/api-pegawai';
        $client_id      = env('SSO_CLIENT_ID');
        $client_secret  = env('SSO_CLIENT_SECRET');
        $ch = curl_init($url_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS,"grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_USERPWD, $client_id . ":" . $client_secret);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_token = curl_exec($ch);
        if(curl_errno($ch)){
            throw new Exception(curl_error($ch));
        }
        curl_close ($ch);
        $json_token = json_decode($response_token, true);
        $access_token = $json_token['access_token'];

        $kodeOrganisasi = ['000000080100','000000081000',  '000000082000', '000000083000'];

        $allPegawai = [];

        foreach($kodeOrganisasi as $kode){
            $query_search = '/unit/'.$kode;

            $ch = curl_init($url_api.$query_search);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , 'Authorization: Bearer '.$access_token ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            if(curl_errno($ch)){
                throw new Exception(curl_error($ch));
            }
            curl_close ($ch);
            $json = json_decode($response, true);
            $allPegawai = array_merge($allPegawai, $json);

        }
        $pegawaiDatabase = User::all();
        // filter allpegawai when ["attributes"]["attribute-nip"][0] not in nip pegawaidatabase
        $allPegawai = array_filter($allPegawai, function($pegawai) use ($pegawaiDatabase){
            $nip = $pegawai["attributes"]["attribute-nip"][0];
            $isExist = $pegawaiDatabase->contains('nip', $nip);
            return !$isExist;
        });
        return $allPegawai;
    }

    public function create()
    {
        $allPegawai = $this->getAllPegawai();
        return view(
            'admin.master-pegawai.create',
            [
                'type_menu'     => 'master-pegawai',
                'pangkat'       => $this->pangkat,
                'unit_kerja'    => $this->unit_kerja,
                'jabatan'       => $this->jabatan,
                'role'          => $this->role,
                'allPegawai'    => $allPegawai,
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
        // protected $role = [
        //     'is_admin'      => 'Admin',
        //     'is_sekma'      => 'Sekretaris Utama',
        //     'is_sekwil'     => 'Sekretaris Wilayah',
        //     'is_perencana'  => 'Perencana',
        //     'is_apkapbn'    => 'APK-APBN',
        //     'is_opwil'      => 'Operator Wilayah',
        //     'is_analissdm'  => 'Analis SDM'
        // ];

        $validateData = $request->validate([
            'name'          => 'required',
            'email'         => 'required|unique:users|max:255',
            'nip'           => 'required|max:18',
            'pangkat'       => 'required',
            'unit_kerja'    => 'required',
            'jabatan'       => 'required',
            'is_admin'      => 'required',
            'is_sekma'      => 'required',
            'is_sekwil'     => 'required',
            'is_perencana'  => 'required',
            'is_apkapbn'    => 'required',
            'is_opwil'      => 'required',
            'is_analissdm'  => 'required',
            'is_arsiparis'  => 'required',
            'is_aktif'      => 'required',
        ]);

        $validateData["password"] = bcrypt($request->password);

        User::create($validateData);

        return redirect('/admin/master-pegawai')
            ->with('status', 'Berhasil menambahkan data pegawai.')
            ->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrfail($id);

        return view('admin.master-pegawai.show', [
            'type_menu' => 'master-pegawai',
            'pangkat'       => $this->pangkat,
            'unit_kerja'    => $this->unit_kerja,
            'jabatan'       => $this->jabatan,
            'role'          => $this->role
            ])
            ->with('user',$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrfail($id);
        return view('admin.master-pegawai.edit', [
            'type_menu' => 'master-pegawai',
            'pangkat'       => $this->pangkat,
            'unit_kerja'    => $this->unit_kerja,
            'jabatan'       => $this->jabatan,
            'role'          => $this->role])
            ->with('user', $user);
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
        $user = User::findOrfail($id);

        $rules = [
            'name'          => 'required',
            // 'email'         => 'required|unique:users|max:255',
            // 'password'      => 'required',
            'nip'           => 'required',
            'pangkat'       => 'required',
            'unit_kerja'    => 'required',
            'jabatan'       => 'required',
            'is_admin'      => 'required',
            'is_sekma'      => 'required',
            'is_sekwil'     => 'required',
            'is_perencana'  => 'required',
            'is_apkapbn'    => 'required',
            'is_opwil'      => 'required',
            'is_analissdm'  => 'required',
            'is_arsiparis'  => 'required',
            'is_aktif'      => 'required',
        ];

        // if($request->password != ""){
        //     $rules['password'] = 'required';
        //     $request['password'] = $user->password;
        // }else{
        //     $request['password'] = bcrypt($request->password);
        // }

        if($request->email != $user->email){
            $rules['email'] = 'required|unique:users|max:255';
        }

        $validateData = $request->validate($rules);

        User::where('id', $id)->update($validateData);
        return redirect('/admin/master-pegawai')
            ->with('status', 'Berhasil memperbarui data pegawai.')
            ->with('alert-type', 'success');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            $user = User::where('id', $id)->first();
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dihapus!',
            ]);
        } catch (\Throwable $th) {
            if($th->errorInfo[1] == 1451){
                return response()->json([
                    'success' => false,
                    'message' => "Data masih terhubung dengan data lain!"
                ], 409);
            }
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Dihapus!',
            ], 409);
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request)
    {
        $validateFile = $request->validate([
            'file' => 'required|mimes::xls,xlsx'
        ]);


        $file = $request->file('file');
        $file_name = rand().$file->getClientOriginalName();
        $file->move(storage_path('/document/upload/'), $file_name);

        $header = (new HeadingRowImport)->toArray(storage_path('/document/upload/').$file_name);
        $rules = [
            'name',
            'email',
            'nip',
            'kode_pangkat',
            'kode_unitkerja',
            'kode_jabatan',
            'admin',
            'sekretaris_utama',
            'sekretaris_wilayah',
            'perencana',
            'apkapbn',
            'operator_wilayah',
            'analissdm',
        ];

        foreach($rules as $rule){
            if(!in_array($rule, $header[0][0])){
               return back()
               ->with('status', 'Gagal mengimpor data, format file tidak sesuai. Silahkan unduh format yang telah disediakan.')
               ->with('alert-type', 'danger');
            }
        }

        Excel::import(new UserImport, storage_path('/document/upload/').$file_name);
        return back()->with('status', 'Berhasil mengimpor data pegawai.')->with('alert-type', 'success');
    }

    public function getPegawai($nip)
    {
        $url_base       = 'https://sso.bps.go.id/auth/';
        $url_token      = $url_base.'realms/pegawai-bps/protocol/openid-connect/token';
        $url_api        = $url_base.'realms/pegawai-bps/api-pegawai';
        $client_id      = env('SSO_CLIENT_ID');
        $client_secret  = env('SSO_CLIENT_SECRET');
        $ch = curl_init($url_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS,"grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_USERPWD, $client_id . ":" . $client_secret);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_token = curl_exec($ch);
        if(curl_errno($ch)){
            throw new Exception(curl_error($ch));
        }
        curl_close ($ch);
        $json_token = json_decode($response_token, true);
        $access_token = $json_token['access_token'];
        // dd($access_token);

        $query_search = '/nipbaru/'.$nip;

        $ch = curl_init($url_api.$query_search);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , 'Authorization: Bearer '.$access_token ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if(curl_errno($ch)){
            throw new Exception(curl_error($ch));
        }
        curl_close ($ch);
        $json = json_decode($response, true);
        // dd($json);
        return response()->json($json);
    }
}
