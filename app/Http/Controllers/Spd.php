<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;
use App\Models\SuratModel;
use \Dompdf\Dompdf;

class Spd extends BaseController
{
    function __construct()
    {
        session();
    }
    public function index()
    {
        date_default_timezone_set("ASIA/JAKARTA");
        $usermodel = new SuratModel();
        $daftarspd = $usermodel->findAll();
        $data = [
            'title' => "Daftar SPD",
            'style' => "admin/spd/daftar-spd",
            'active' => "admin daftar spd",
            'script' => "admin/spd/daftar-spd",
            'daftarspd' => $daftarspd
        ];
        return view('admin/spd/index', $data);
    }

    public function tambahSpd($id)
    {
        $usermodel = new PenggunaModel();
        $ppk = $usermodel
            ->where('role', 4)
            ->select('pengguna.id as id, pengguna.nama as nama_pengguna, pengguna.nip as nip')
            ->get()->getRowArray();
        $usermodel = new SuratModel();
        $spd = $usermodel->find($id);
        if (isset($_POST["submit"])) {
            $rules = [
                'no_spd' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'No SPD Tidak Boleh Kosong'
                    ]
                ],
                'tgl_spd' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal Tidak Boleh Kosong'
                    ]
                ],
                'tujuan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tujuan Tidak Boleh Kosong'
                    ]
                ],
                'tgl_berangkat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal Berangkat Tidak Boleh Kosong'
                    ]
                ],
                'tgl_kembali' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal Kembali Tidak Boleh Kosong'
                    ]
                ],
                'durasi' => [
                    'rules' => 'required', 'numeric',
                    'errors' => [
                        'required' => 'Durasi Tidak Boleh Kosong',
                        'numeric' => 'Hanya Boleh Angka'
                    ]
                ],
                'anggaran_akun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Anggaran Akun Tidak Boleh Kosong'
                    ]
                ]
            ];
            if (!$this->validate($rules)) {
                return redirect()->to(base_url('Admin/Spd/tambahSpd/' . $id))->withInput();
            }
            $tambahData = [
                'id' => $id,
                'ppk' => $this->request->getPost('ppk'),
                'nip_ppk' => $this->request->getPost('nip_ppk'),
                'no_spd' => $this->request->getPost('no_spd'),
                'tgl_spd' => $this->request->getPost('tgl_spd'),
                'tingkat' => $this->request->getPost('tingkat'),
                'asal' => $this->request->getPost('asal'),
                'tujuan' => $this->request->getPost('tujuan'),
                'jenis_transport' => $this->request->getPost('jenis_transport'),
                'tgl_berangkat' => $this->request->getPost('tgl_berangkat'),
                'tgl_kembali' => $this->request->getPost('tgl_kembali'),
                'durasi' => $this->request->getPost('durasi'),
                'anggaran_akun' => $this->request->getPost('anggaran_akun')

            ];
            $usermodel = new SuratModel();
            $usermodel->save($tambahData);
            return redirect()->to(base_url('Admin/Spd'));
        }
        $data = [
            'title' => "Buat SPD",
            'style' => "admin/spd/tambah-spd",
            'active' => "admin daftar spd",
            'script' => "admin/spd/tambah-spd",
            'ppk' => $ppk,
            'spd' => $spd
        ];
        return view('admin/spd/tambah-spd', $data);
    }
    public function ubahSpd($id)
    {
        $usermodel = new PenggunaModel();
        $usermodel = new SuratModel();
        if (isset($_POST["submit"])) {
            $rules = [
                'no_spd' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'No SPD Tidak Boleh Kosong'
                    ]
                ],
                'tgl_spd' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal Tidak Boleh Kosong'
                    ]
                ],
                'tujuan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tujuan Tidak Boleh Kosong'
                    ]
                ],
                'tgl_berangkat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal Berangkat Tidak Boleh Kosong'
                    ]
                ],
                'tgl_kembali' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal Kembali Tidak Boleh Kosong'
                    ]
                ],
                'durasi' => [
                    'rules' => 'required', 'numeric',
                    'errors' => [
                        'required' => 'Durasi Tidak Boleh Kosong',
                        'numeric' => 'Hanya Boleh Angka'
                    ]
                ],
                'anggaran_akun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Anggaran Akun Tidak Boleh Kosong'
                    ]
                ]
            ];
            if (!$this->validate($rules)) {
                return redirect()->to(base_url('Admin/Spd/ubahSpd/' . $id))->withInput();
            }
            $ubahData = [
                'id' => $id,
                'no_spd' => $this->request->getPost('no_spd'),
                'tgl_spd' => $this->request->getPost('tgl_spd'),
                'tingkat' => $this->request->getPost('tingkat'),
                'tujuan' => $this->request->getPost('tujuan'),
                'jenis_transport' => $this->request->getPost('jenis_transport'),
                'tgl_berangkat' => $this->request->getPost('tgl_berangkat'),
                'tgl_kembali' => $this->request->getPost('tgl_kembali'),
                'durasi' => $this->request->getPost('durasi'),
                'anggaran_akun' => $this->request->getPost('anggaran_akun')
            ];
            $usermodel = new SuratModel();
            $usermodel->save($ubahData);
            return redirect()->to(base_url('Admin/Spd'));
        }
        $usermodel = new SuratModel();
        $spd = $usermodel->find($id);
        $data = [
            'title' => "Ubah Spd",
            'style' => "admin/spd/ubah-spd",
            'active' => "admin daftar spd",
            'script' => "admin/spd/ubah-spd",
            'spd' => $spd
        ];
        return view('admin/spd/ubah-spd', $data);
    }
    public function cetakSpd($id)
    {
        $usermodel = new SuratModel();
        $spd = $usermodel->find($id);
        $data = [
            'title' => "Cetak SPD",
            'style' => "admin/spd/cetak-spd",
            'active' => "admin cetak spd",
            'script' => "admin/spd/cetak-spd",
            'spd' => $spd
        ];
        return view('admin/spd/cetak-spd', $data);
    }
}
