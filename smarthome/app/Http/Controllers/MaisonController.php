<?php

namespace App\Http\Controllers;

use App\Models\Maison;
use App\Models\Posseder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaisonController extends Controller
{
    public function index()
    {
        //
        $maisons = Maison::all();
        return response()->json($maisons);
    }

    public function store(Request $request)
    {
        //Vérifier que les données sont valides
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'adresse' => '|string|max:255',
            'ville' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation échouée',
                'errors'=>$validator->errors()], 422);
        }

        $maison = Maison::create($request->all());
        Posseder::create([
            'user_id' => auth()->id(),
            'maison_id' => $maison->id,
        ]);
        return redirect()->route('dashboard')->with('success', 'Maison créée avec succès');
    }

    public function show($id)
    {
        //
        $maison = Maison::with('pieces.devices')->whereHas('users', function ($query) {
            $query->where('id', auth()->id());
        })->find($id);

        if (!$maison) {
            return response()->json([
                'success' => false,
                'message' => 'Maison non trouvée'
            ], 404);
        }
        $maison->load('pieces.devices');
        return view('homes.show', ['maison' => $maison]);
    }

    public function update(Request $request, $id)
    {
        //
        $maison = Maison::find($id);
        if (!$maison) {
            return response()->json([
                'success' => false,
                'message' => 'Maison non trouvée'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|string|max:255',
            'adresse' => 'sometimes|string|max:255',
            'ville' => 'sometimes|string|max:255',
            'pays' => 'sometimes|string|max:255',
            'mqtt_topic' => 'sometimes|string|max:255',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation échouée',
                'errors'=>$validator->errors()], 422);
        }

        $maison->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Maison mise à jour avec succès',
            'data' => $maison
        ]);
    }

    public function destroy($id)
    {
        //
        $maison = Maison::find($id);
        if (!$maison) {
            return response()->json([
                'success' => false,
                'message' => 'Maison non trouvée'
            ], 404);
        }
        $maison->delete();
        return response()->json([
            'success' => true,
            'message' => 'Maison supprimée avec succès'
        ]);
    }
}
