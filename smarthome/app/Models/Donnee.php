<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Device;

class Donnee extends Model
{
    //
    protected $table = 'donnees';

    protected $fillable = [
        'type',
        'valeur',
        'device_id',
    ];

    public function devices()
    {
        return $this->belongsTo(Device::class);
    }
}
