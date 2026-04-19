<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maison extends Model
{
    //
    protected $table = 'maisons';

    protected $fillable = [
        'nom',
        'adresse',
        'ville',
        'pays',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'posseder', 'maison_id', 'user_id');
    }

    public function pieces()
    {
        return $this->hasMany(Piece::class);
    }
}
