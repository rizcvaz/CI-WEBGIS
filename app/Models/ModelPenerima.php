<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRumah extends Model
{
    public function AllData()
    {
        return $this->db->table('tbl_rumah')
        ->join('tbl_keterangan', 'tbl_keterangan.id_keterangan = tbl_rumah.id_keterangan', 'left')
            ->get()->getResultArray();
    }

    public function AllDataPerWilayah($id_wilayah)
    {
        return $this->db->table('tbl_rumah')
        ->join('tbl_keterangan', 'tbl_keterangan.id_keterangan = tbl_rumah.id_keterangan', 'left')
        ->where('id_wilayah', $id_wilayah)
            ->get()->getResultArray();
    }

    public function AllDataPerKeterangan($id_keterangan)
    {
        return $this->db->table('tbl_rumah')
        ->join('tbl_keterangan', 'tbl_keterangan.id_keterangan = tbl_rumah.id_keterangan', 'left')
        ->where('tbl_rumah.id_keterangan', $id_keterangan)
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('tbl_rumah')->insert($data);
    }

    public function DetailData($id_rumah)
    {
    return $this->db->table('tbl_rumah')
        ->join('tbl_keterangan', 'tbl_keterangan.id_keterangan = tbl_rumah.id_keterangan', 'left')
        ->join('tbl_provinsi', 'tbl_provinsi.id_provinsi = tbl_rumah.id_provinsi', 'left')
        ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_rumah.id_kabupaten', 'left')
        ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_rumah.id_kecamatan', 'left')
        ->join('tbl_wilayah', 'tbl_wilayah.id_wilayah = tbl_rumah.id_wilayah', 'left')
        ->where('id_rumah', $id_rumah)
        ->get()->getRowArray();
    }

    public function UpdateData($id_rumah, $data)
    {
    $this->db->table('tbl_rumah')
        ->where('id_rumah', $id_rumah)
        ->update($data);
    }

    public function DeleteData($id_rumah)
    {
    $this->db->table('tbl_rumah')
        ->where('id_rumah', $id_rumah)
        ->delete();
    }

    //provinsi
    public function allProvinsi()
    {
        return $this->db->table('tbl_provinsi')
            ->orderBy('id_provinsi', 'ASC')
            ->get()->getResultArray();
    }

    public function allKabupaten($id_provinsi)
    {
        return $this->db->table('tbl_kabupaten')
            ->where('id_provinsi', $id_provinsi)
            ->get()->getResultArray();
    }

    public function allKecamatan($id_kabupaten)
    {
        return $this->db->table('tbl_kecamatan')
            ->where('id_kabupaten', $id_kabupaten)
            ->get()->getResultArray();
    }

}
