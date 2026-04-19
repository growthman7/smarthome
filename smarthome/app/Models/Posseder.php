<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posseder extends Model
{
    //
    protected $table = 'posseder';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'maison_id',
    ];
}
