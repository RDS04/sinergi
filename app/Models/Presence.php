<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = [
        'invitation_id',
        'nama_mhs',
        'prodi',
        'wa_mhs',
        'nama_ortu',
        'alamat_ortu',
        'wa_ortu',
        'present_at',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
