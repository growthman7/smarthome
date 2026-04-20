<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Device;
use App\Providers\MqttServiceProvider;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function send(Request $request, MqttServiceProvider $mqtt)
    {
        $device = Device::findOrFail($request->idDevice);
        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }
        //Construction du topic MQTT
        $topic = $device->mqttTopic; // Exemple : "home/{mais/livingroom/light1/command"

        //Créére la commande dans la base de données
        $command = Commande::create([
            'type' => $request->type,
            'valeur' => $request->valeur,
            'device_id' => $request->idDevice,
        ]);


        // 🔥 ENVOI MQTT (ESP32)
        // $this->publishMqtt($device->mqttTopic, [
        //     'type' => $request->typeCom,
        //     'value' => $request->valeur
        // ]);
        $mqtt->publish($topic, json_encode([
            'type' => $request->type,
            'value' => $request->valeur
        ]));

        $mqtt->disconnect();



        return response()->json([
            'message' => 'Commande envoyée',
            'command' => $command
        ]);
    }

    private function publishMqtt($topic, $payload)
    {
        // Exemple simple (lib php-mqtt)
        $mqtt = new \PhpMqtt\Client\MqttClient('127.0.0.1', 1883);

        $mqtt->connect();
        $mqtt->publish($topic, json_encode($payload));
        $mqtt->disconnect();
    }
}
