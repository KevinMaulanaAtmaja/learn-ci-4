<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikModel extends Model
{
    protected $table = 'komikku';
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;
}
