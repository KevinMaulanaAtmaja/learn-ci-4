<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | Web BIN',
            'test' => ['satu', 'dua', 'tiga']
        ];
        // echo view('layout/header', $data);
        return view('pages/awal', $data);
        // echo view('layout/footer');
    }

    public function tentang()
    {
        $data = [
            'title' => 'Tentang Saya'
        ];
        // echo view('layout/header', $data);
        return view('pages/tentang', $data);
        // echo view('layout/footer');
    }

    public function kontak()
    {
        $data = [
            'title' => 'Kontak Saya',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Tanggul',
                    'kota' => 'BWI'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Nongsa DigITal Park',
                    'kota' => 'Batam'
                ]
            ]
        ];

        return view('pages/kontak', $data);
    }
}
