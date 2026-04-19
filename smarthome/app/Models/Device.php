<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //
    protected $table = 'devices';

    protected $fillable = [
        'nom',
        'type',
        'etat',
        'mqttTopic',
        'piece_id',
    ];

    public function piece()
    {
        return $this->belongsTo(Piece::class);
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function donnees()
    {
        return $this->hasMany(Donnee::class);
    }

    //Génération automatique du topic MQTT
    public function generateTopic()
    {
        $maisonId = $this->piece->maison_id;
        $pieceId = strtolower($this->piece->nom);
        $typeDevice = $this->type;
        $deviceId = $this->id;

        return "maison/{$maisonId}/{$pieceId}/{$typeDevice}/{$deviceId}";

    }

    //Topic commande
    public function topicSet()
    {
        return $this->mqttTopic . '/set';
    }

    //Topic status
    public function topicStatus()
    {
        return $this->mqttTopic . '/status';
    }
}
