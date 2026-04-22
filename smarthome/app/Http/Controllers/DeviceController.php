<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    //
    public function index()
    {
        //
        $devices = Device::with('piece.maison')->get();
        // dd($devices);
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Liste des appareils',
        //     'data' => $devices
        // ]);
        return view('devices.index', compact('devices'));
    }

    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'piece_id' => 'required|exists:pieces,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $device = Device::create($request->all());
        $device->load('piece'); // Charger la relation avec la pièce
        $device->mqttTopic = $device->generateTopic(); // Générer le topic MQTT basé sur la pièce et le nom de l'appareil
        $device->save(); // Sauvegarder les modifications

        return redirect()->back()->with([
            'success' => true,
            'message' => 'Appareil créé avec succès',
            'mqttTopic' => $device->mqttTopic,
        ]);
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Appareil créé avec succès',
        //     'data' => $device,
        //     'topics' => [
        //         'set' => $device->topicSet(),
        //         'status' => $device->topicStatus(),
        //     ]
        // ], 201);
    }
}
