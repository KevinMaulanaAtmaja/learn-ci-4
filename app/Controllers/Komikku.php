<?php

namespace App\Controllers;

use App\Models\KomikkuModel;

class Komikku extends BaseController
{
    protected $komikkuModel;

    public function __construct()
    {
        $this->komikkuModel = new KomikkuModel();
    }

    public function index()
    {
        // $komikku = $this->komikkuModel->findAll();


        $data = [
            'title' => 'Daftar Komik',
            'komikku' => $this->komikkuModel->getKomikku()
        ];

        // konek tanpa model
        // $db = \Config\Database::connect();
        // $komik = $db->query("SELECT * FROM komikku");
        // // dd($komik);
        // foreach ($komik->getResultArray() as $row) {
        //     d($row);
        // }

        //default
        // $komikkuModel = new \App\Models\KomikkuModel();

        //agak default
        // $komikkuModel = new KomikkuModel();

        //cara memanggil dari db
        // $komikku = $this->komikkuModel->findAll();
        // $komikku = $komikkuModel->find(1);


        // d($komikku);


        return view('komikku/index', $data);
    }
    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik',
            'komikku' => $this->komikkuModel->getKomikku($slug)
        ];

        // jika komikku tidak ada di tabel
        if (empty($data['komikku'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(' Judul Komikku ' . $slug . ' tidak ditemukan');
        }

        // $komikku = $this->komikkuModel->getKomikku($slug);
        return view('komikku/detail', $data);
        // dd($komikku);
    }

    public function create()
    {
        // session();
        $data = [
            'title' => 'Form Tambah Data Komikku',
            'validation' => \Config\Services::validation()
        ];
        return view('komikku/create', $data);
    }

    public function save()
    {
        // validasi input
        if (!$this->validate([
            // 'judul' => 'required|is_unique[komikku.judul]'
            'judul' => [
                'rules' => 'required|is_unique[komikku.judul]',
                'errors' => [
                    'required' => '{field} komikku harus diisi.',
                    'is_unique' => '{field} judul komikku sudah ada'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('/komikku/tambah')->withInput()->with('validation', $validation);
            return redirect()->to('/komikku/tambah')->withInput();
        }

        // ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        // apakah tidak ada gambar yg di upload
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            // generate nama sampul random
            $namaSampul = $fileSampul->getRandomName();

            // pindahkan file ke folder img
            $fileSampul->move('img', $namaSampul);
        }
        // ambil nama file
        // $namaSampul = $fileSampul->getName();




        $slug = url_title($this->request->getVar('judul'), '-', true);
        // dd($this->request->getVar());
        $this->komikkuModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/komikku');
    }

    public function delete($id)
    {
        // cari gambar berdasarkan id
        $komikku = $this->komikkuModel->find($id);
        // cek jika file gambarnya default
        if ($komikku['sampul'] != 'default.jpg') {
            // hapus gambar
            unlink('img/' . $komikku['sampul']);
        }

        $this->komikkuModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/komikku');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Komikku',
            'validation' => \Config\Services::validation(),
            'komikku' => $this->komikkuModel->getKomikku($slug)
        ];
        return view('komikku/edit', $data);
    }

    public function update($id)
    {
        // validasi input

        // cek judul
        $KomikLama = $this->komikkuModel->getKomikku($this->request->getVar('slug'));
        if ($KomikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komikku.judul]';
        }

        if (!$this->validate([
            // 'judul' => 'required|is_unique[komikku.judul]'
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komikku harus diisi.',
                    'is_unique' => '{field} judul komikku sudah ada'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            return redirect()->to('/komikku/edit/' . $this->request->getVar('slug'))->withInput();
        }
        $fileSampul = $this->request->getFile('sampul');

        // cek gambar apakah tetap gambar lama 
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            // generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan gambar
            $fileSampul->move('img', $namaSampul);
            // hapus file yg lama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        // dd($this->request->getVar());
        $this->komikkuModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to('/komikku');
    }
}
