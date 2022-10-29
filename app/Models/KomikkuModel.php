<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikkuModel extends Model
{
    protected $table = 'komikku';
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;
    protected $allowedFields = ['judul', 'slug', 'penulis', 'penerbit', 'sampul'];


    public function getKomikku($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->where(['slug' => $slug])->first();
    }
}
