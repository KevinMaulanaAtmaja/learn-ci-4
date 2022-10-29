<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $KomikModel;

    public function __construct()
    {
        $this->KomikModel = new KomikModel();
    }

    public function index()
    {
        $komik = $this->KomikModel->findAll();
        $data = [
            'title' => 'Daftar Komik',
            'komik' => $komik

        ];

        dd($komik);

        return view('komik/index', $data);
    }
}
