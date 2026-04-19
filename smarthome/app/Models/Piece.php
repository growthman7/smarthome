<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    //
    protected $table = 'pieces';

    protected $fillable = [
        'nom',
        'maison_id',
    ];

    public function maison()
    {
        return $this->belongsTo(Maison::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
