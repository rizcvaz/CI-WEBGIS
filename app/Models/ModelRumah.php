<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRumah extends Model
{
    protected $table = 'tbl_rumah';         // Nama tabel di database
    protected $primaryKey = 'id_rumah'; // Kolom primary key
    protected $allowedFields = [
        'nama_kk', 'nomor_ktp', 'alamat', 'coordinat', 
        'id_keterangan', 'id_provinsi', 'id_kabupaten', 
        'id_kecamatan', 'jenis_atap', 'jenis_dinding', 
        'jenis_lantai', 'jenis_bantuan', 'id_wilayah', 'foto'
    ]; // Kolom yang dapat diisi

    // Fungsi untuk mengambil semua data rumah
    public function AllData()
    {
        return $this->findAll(); // Mengambil semua data dari tabel
    }

    // Fungsi untuk menyimpan data rumah
    public function InsertData($data)
    {
        return $this->insert($data); // Menyimpan data baru
    }

    // Fungsi untuk memperbarui data rumah
    public function UpdateData($id_rumah, $data)
    {
        return $this->update($id_rumah, $data); // Memperbarui data rumah berdasarkan ID
    }

    // Fungsi untuk mengambil detail data rumah berdasarkan ID
    public function DetailData($id_rumah)
    {
        return $this->find($id_rumah); // Menampilkan data rumah berdasarkan ID
    }

    // Fungsi untuk menghapus data rumah
    public function DeleteData($id_rumah)
    {
        return $this->delete($id_rumah); // Menghapus data rumah berdasarkan ID
    }

    // Fungsi untuk mendapatkan provinsi (misalnya untuk dropdown)
    public function allProvinsi()
    {
        // Menyediakan provinsi untuk dropdown (sumber data bisa dari tabel provinsi atau API)
        return $this->db->table('tbl_provinsi')->get()->getResultArray();
    }

    // Fungsi untuk mendapatkan kabupaten berdasarkan provinsi
    public function allKabupaten($id_provinsi)
    {
        return $this->db->table('tbl_kabupaten')->where('id_provinsi', $id_provinsi)->get()->getResultArray();
    }

    // Fungsi untuk mendapatkan kecamatan berdasarkan kabupaten
    public function allKecamatan($id_kabupaten)
    {
        return $this->db->table('tbl_kecamatan')->where('id_kabupaten', $id_kabupaten)->get()->getResultArray();
    }
}
