<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use Illuminate\Http\Request;

class PieceController extends Controller
{
    //
    public function index()
    {
        //Récupérer l'ID de l'utilisateur connecté
        $idUser = auth()->id();
        $pieces = Piece::whereHas('maison.users', function ($query) use ($idUser) {
            $query->where('id', $idUser);
        })->get();
        $pieces->load('maison');
        return view('rooms.index', compact('pieces'));
    }

    public function store(Request $request)
    {
        //
        $request->validate([
            'nom' => 'required|string|max:255',
            'maison_id' => 'required|exists:maisons,id',
        ]);


        $piece = Piece::create($request->all());
        return redirect()->route('rooms')->with('success', 'Pièce créée avec succès');
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Pièce créée avec succès',
        //     'data' => $piece
        // ], 201);
    }

    public function show(string $id)
    {
        //
        $piece = Piece::with('devices')->findOrFail($id);
        // dd($piece);
        return view('rooms.show', compact('piece'));
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Détails de la pièce',
        //     'data' => $piece
        // ]);
    }
}
