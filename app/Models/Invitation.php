<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitation';
    protected $fillable = [
        'nama_mhs',
        'prodi',
        'wa_mhs',
        'nama_ortu',
        'alamat_ortu',
        'wa_ortu',
    ];
}
