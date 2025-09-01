<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelRumah;
use App\Models\ModelSetting;
use App\Models\ModelWilayah;
use App\Models\ModelKeterangan;

class Rumah extends BaseController
{
    protected $ModelRumah;
    protected $ModelSetting;
    protected $ModelWilayah;
    protected $ModelKeterangan;

    public function __construct()
    {
        $this->ModelRumah       = new ModelRumah();
        $this->ModelSetting     = new ModelSetting();
        $this->ModelWilayah     = new ModelWilayah();
        $this->ModelKeterangan  = new ModelKeterangan();
    }

    public function index()
    {
        $data = [
            'judul'     => 'Pendataan rumah',
            'menu'      => 'rumah',
            'page'      => 'rumah/v_index',
            'rumah'  => $this->ModelRumah->AllData(),
            'keterangan' => $this->ModelKeterangan->AllData(),
            'web'       => $this->ModelSetting->DataWeb(),
            'wilayah'   => $this->ModelWilayah->AllData(),
        ];
        return view('v_back_end', $data);
    }

    public function Input()
    {
        $data = [
            'judul'         => 'Input Rumah',
            'menu'          => 'rumah',
            'page'          => 'rumah/v_input',
            'web'           => $this->ModelSetting->DataWeb(),
            'provinsi'      => $this->ModelRumah->allProvinsi(),
            'wilayah'       => $this->ModelWilayah->AllData(),
            'keterangan'    => $this->ModelKeterangan->AllData(),
        ];
        return view('v_back_end', $data);
    }

    public function InsertData()
    {
        $validation = $this->validate([
            'nama_kk' => [
                'label' => 'Nama Kk',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'nomor_ktp' => [
                'label' => 'Nomor KTP',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'coordinat' => [
                'label' => 'Koordinat',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_keterangan' => [
                'label' => 'Keterangan',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_provinsi' => [
                'label' => 'Provinsi',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_kabupaten' => [
                'label' => 'Kabupaten',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_kecamatan' => [
                'label' => 'Kecamatan',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'jenis_atap' => [
                'label' => 'Jenis Atap',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'jenis_dinding' => [
                'label' => 'Jenis Dinding',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'jenis_lantai' => [
                'label' => 'Jenis Lantai',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'jenis_bantuan' => [
                'label' => 'Jenis Bantuan',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_wilayah' => [
                'label' => 'Wilayah Administrasi',
                'rules' => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'foto' => [
                'label' => 'Foto Rumah',
                'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded'  => '{field} Wajib Diisi !!',
                    'max_size'  => 'Ukuran {field} maksimal 1024 KB !!',
                    'mime_in'   => 'Format {field} harus JPG, JPEG, atau PNG !!'
                ]
            ],
        ]);

        if (!$validation) {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to('Rumah/Input')->withInput();
        }

        $foto = $this->request->getFile('foto');
        $nama_file_foto = $foto->getRandomName();

        $data = [
            'nama_kk' => $this->request->getPost('nama_kk'),
            'nomor_ktp'     => $this->request->getPost('nomor_ktp'),
            'alamat'        => $this->request->getPost('alamat'),
            'coordinat'     => $this->request->getPost('coordinat'),
            'id_keterangan' => $this->request->getPost('id_keterangan'),
            'id_provinsi'   => $this->request->getPost('id_provinsi'),
            'id_kabupaten'  => $this->request->getPost('id_kabupaten'),
            'id_kecamatan'  => $this->request->getPost('id_kecamatan'),
            'jenis_atap'    => $this->request->getPost('jenis_atap'),
            'jenis_dinding' => $this->request->getPost('jenis_dinding'),
            'jenis_lantai'  => $this->request->getPost('jenis_lantai'),
            'jenis_bantuan' => $this->request->getPost('jenis_bantuan'),
            'id_wilayah'    => $this->request->getPost('id_wilayah'),
            'foto'          => $nama_file_foto,
        ];

        $foto->move('foto', $nama_file_foto);

        $this->ModelRumah->InsertData($data);
        session()->setFlashdata('insert', 'Data Berhasil Di Tambahkan !!');
        return redirect()->to('Rumah');
    }
    
    public function Kabupaten()
    {
        $id_provinsi = $this->request->getPost('id_provinsi');
        $dataKabupaten = $this->ModelRumah->allKabupaten($id_provinsi);
        echo '<option value="">--Pilih Kabupaten--</option>';
        foreach ($dataKabupaten as $row) {
            echo '<option value="' . $row['id_kabupaten'] . '">' . $row['nama_kabupaten'] . '</option>';
        }
    }

    public function Kecamatan()
    {
        $id_kabupaten = $this->request->getPost('id_kabupaten');
        $dataKecamatan = $this->ModelRumah->allKecamatan($id_kabupaten);
        echo '<option value="">--Pilih Kecamatan--</option>';
        foreach ($dataKecamatan as $row) {
            echo '<option value="' . $row['id_kecamatan'] . '">' . $row['nama_kecamatan'] . '</option>';
        }
    }

    

    public function Edit($id_rumah)
{
    // Ambil data rumah berdasarkan ID
    $rumah = $this->ModelRumah->DetailData($id_rumah);
    
    // Ambil data provinsi dan kabupaten sesuai dengan provinsi yang dipilih
    $provinsi = $this->ModelRumah->allProvinsi();
    $kabupaten = $this->ModelRumah->allKabupaten($rumah['id_provinsi']);  // Ambil kabupaten berdasarkan provinsi rumah
    $kecamatan = $this->ModelRumah->allKecamatan($rumah['id_kabupaten']);  // Ambil kecamatan berdasarkan kabupaten rumah

    // Kirim data ke view
    $data = [
        'judul'         => 'Edit Data Rumah',
        'menu'          => 'rumah',
        'page'          => 'rumah/v_edit',
        'web'           => $this->ModelSetting->DataWeb(),
        'provinsi'      => $provinsi,
        'kabupaten'     => $kabupaten,
        'kecamatan'     => $kecamatan,
        'wilayah'       => $this->ModelWilayah->AllData(),
        'keterangan'    => $this->ModelKeterangan->AllData(),
        'rumah'         => $rumah,
    ];

    return view('v_back_end', $data);
}


   public function UpdateData($id_rumah)
{
    // Validasi data
    if ($this->validate([
        'nama_kk' => ['label' => 'Nama KK', 'rules' => 'required'],
        'nomor_ktp' => ['label' => 'Nomor KTP', 'rules' => 'required'],
        'alamat' => ['label' => 'Alamat', 'rules' => 'required'],
        'coordinat' => ['label' => 'Koordinat', 'rules' => 'required'],
        'id_keterangan' => ['label' => 'Keterangan', 'rules' => 'required'],
        'id_provinsi' => ['label' => 'Provinsi', 'rules' => 'required'],
        'id_kabupaten' => ['label' => 'Kabupaten', 'rules' => 'required'],
        'id_kecamatan' => ['label' => 'Kecamatan', 'rules' => 'required'],
        'jenis_atap' => ['label' => 'Jenis Atap', 'rules' => 'required'],
        'jenis_dinding' => ['label' => 'Jenis Dinding', 'rules' => 'required'],
        'jenis_lantai' => ['label' => 'Jenis Lantai', 'rules' => 'required'],
        'jenis_bantuan' => ['label' => 'Jenis Bantuan', 'rules' => 'required'],
        'id_wilayah' => ['label' => 'Wilayah Administrasi', 'rules' => 'required'],
        'foto' => [
            'label' => 'Foto Rumah',
            'rules' => 'max_size[foto,1024]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'max_size' => 'Ukuran {field} maksimal 1024 KB !!',
                'mime_in' => 'Format {field} harus JPG, JPEG, atau PNG !!',
            ]
        ],
    ])) {
        // Jika foto baru diupload, ganti foto lama
        $rumah = $this->ModelRumah->DetailData($id_rumah);
        $foto = $this->request->getFile('foto');
        
        // Jika tidak ada foto baru, gunakan foto lama
        if ($foto->getError() == 4) {
            $nama_file_foto = $rumah['foto'];
        } else {
            // Foto baru diupload, simpan dan hapus foto lama
            $nama_file_foto = $foto->getRandomName();
            $foto->move('foto', $nama_file_foto);

            // Hapus foto lama jika ada
            if (!empty($rumah['foto'])) {
                $fotoPath = FCPATH . 'foto/' . $rumah['foto'];
                if (file_exists($fotoPath)) {
                    unlink($fotoPath);
                }
            }
        }

        // Persiapkan data yang akan diupdate
        $data = [
            'id_rumah' => $id_rumah,
            'nama_kk' => $this->request->getPost('nama_kk'),
            'nomor_ktp' => $this->request->getPost('nomor_ktp'),
            'alamat' => $this->request->getPost('alamat'),
            'coordinat' => $this->request->getPost('coordinat'),
            'id_keterangan' => $this->request->getPost('id_keterangan'),
            'id_provinsi' => $this->request->getPost('id_provinsi'),
            'id_kabupaten' => $this->request->getPost('id_kabupaten'),
            'id_kecamatan' => $this->request->getPost('id_kecamatan'),
            'jenis_atap' => $this->request->getPost('jenis_atap'),
            'jenis_dinding' => $this->request->getPost('jenis_dinding'),
            'jenis_lantai' => $this->request->getPost('jenis_lantai'),
            'jenis_bantuan' => $this->request->getPost('jenis_bantuan'),
            'id_wilayah' => $this->request->getPost('id_wilayah'),
            'foto' => $nama_file_foto,  // Menyimpan foto baru
        ];

        // Update data rumah
        $this->ModelRumah->UpdateData($id_rumah, $data);

        // Set flashdata untuk pemberitahuan sukses
        session()->setFlashdata('update', 'Data Berhasil Di Update !!');
        return redirect()->to('Rumah');
    } else {
        // Jika ada kesalahan validasi, tampilkan error
        session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
        return redirect()->to('Rumah/Edit/' . $id_rumah)->withInput();
    }
}


    public function Delete($id_rumah)
    {
        $rumah = $this->ModelRumah->DetailData($id_rumah);

        if (!empty($rumah['foto'])) {
            $fotoPath = FCPATH . 'foto/' . $rumah['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        $this->ModelRumah->DeleteData($id_rumah);
        session()->setFlashdata('delete', 'Data Berhasil Di Hapus !!');
        return redirect()->to('rumah');
    }

    public function Detail($id_rumah)
    {
        $data = [
            'judul'     => 'Detail Pendataan Rumah',
            'menu'      => 'rumah',
            'page'      => 'rumah/v_detail',
            'web'       => $this->ModelSetting->DataWeb(),
            'rumah'  => $this->ModelRumah->DetailData($id_rumah),
        ];
        return view('v_back_end', $data);
    }
}

   

