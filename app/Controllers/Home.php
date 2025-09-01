<?php

namespace App\Controllers;

use App\Models\ModelSetting;
use App\Models\ModelWilayah;
use App\Models\ModelRumah;
use App\Models\ModelKeterangan;

class Home extends BaseController
{
    protected $ModelSetting;
    protected $ModelWilayah;
    protected $ModelRumah;
    protected $ModelKeterangan;

    public function __construct()
    {
        $this->ModelSetting    = new ModelSetting();
        $this->ModelWilayah    = new ModelWilayah();
        $this->ModelRumah   = new ModelRumah();
        $this->ModelKeterangan = new ModelKeterangan();
    }

    public function index(): string
    {
        $data = [
            'judul'      => 'Home',
            'page'       => 'v_home',
            'web'        => $this->ModelSetting->DataWeb(),
            'wilayah'    => $this->ModelWilayah->AllData(),
            'rumah'   => $this->ModelRumah->AllData(),
            'keterangan' => $this->ModelKeterangan->AllData(),
        ];

        return view('v_front_end', $data);
    }
}
