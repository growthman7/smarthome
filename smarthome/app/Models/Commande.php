<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    //
    protected $table = 'commandes';
    protected $fillable = [
        'type',
        'valeur',
        'device_id',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
