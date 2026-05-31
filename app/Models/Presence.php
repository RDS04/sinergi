<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = [
        'invitation_id',
        'nama_mhs',
        'status',
        'nama_ortu',
        'wa_mhs',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
