<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianModel extends Model
{
    use HasFactory;
    protected $table = 'antrian';
    protected $fillable = [
        'nama_pasien',
        'no_antrian',
        'service',
        'status',
    ];
}
