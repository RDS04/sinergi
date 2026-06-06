<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = [
        'invitation_id',
        'nama_mhs',
        'status',
        'wa_mhs',
        'nama_ortu_1',
        'nama_ortu_2',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
