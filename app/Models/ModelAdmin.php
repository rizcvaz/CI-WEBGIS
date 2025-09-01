<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model
{
    public function JumlahRumah()
    {
        return $this->db->table('tbl_rumah')
        ->countAll();
    }

    public function JumlahWilayah()
    {
        return $this->db->table('tbl_wilayah')
        ->countAll();
    }
}
