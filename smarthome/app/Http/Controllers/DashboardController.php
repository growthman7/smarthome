<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $count_homes = auth()->user()->maisons()->count();
        $count_devices = Device::whereHas('piece.maison.users', function ($query) {
            $query->where('users.id', auth()->id());
        })->count();

        $count_rooms = auth()->user() //Récupère l'utilisateur authentifié
        ->maisons() //Récupère les maisons de l'utilisateur
        ->with('pieces') //Récupère les pièces de chaque maison
        ->get() //Exécute la requête et récupère les résultats
        ->pluck('pieces') //Récupère uniquement les pièces de chaque maison
        ->flatten() //Transforme la collection de collections de pièces en une seule collection de pièces
        ->count(); //Compte le nombre total de pièces

        $homes = auth()->user()->maisons()->get(); //Récupère les maisons de l'utilisateur authentifié

        return view('dashboard.index', compact('homes', 'count_homes', 'count_devices', 'count_rooms'));
    }
}
