<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitation';
    protected $fillable = [
        'nama_mhs',
        'wa_mhs',
        'status',
        'attendance_status',
        'nama_ortu_1',
        'nama_ortu_2',
    ];
}
