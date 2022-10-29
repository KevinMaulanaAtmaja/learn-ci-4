<?php

namespace App\Controllers;

class Coba extends BaseController
{
    public function index()
    {
        echo 'ini controller Coba method index';
    }

    public function tentang($namaku = '', $belajar = '', $umur = 0)
    {
        echo "tentang saya atau $namaku, belajar $belajar, pada umur $umur tahun";
    }
}
