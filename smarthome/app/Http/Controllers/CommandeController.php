<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Device;
use App\Providers\MqttServiceProvider;
use Illuminate\Http\Request;
use PhpMqtt\Client\ConnectionSettings;

class CommandeController extends Controller
{
    public function send(Request $request)
    {
        // dd(env("MQTT_PORT"));
        $device = Device::findOrFail($request->idDevice);

        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }
        //Construction du topic MQTT
        $topic = $device->mqttTopic;
        // dd($topic);

        //Créére la commande dans la base de données
        $command = Commande::create([
            'type' => $request->type,
            'valeur' => $request->valeur,
            'device_id' => $request->idDevice,
        ]);

        if($device->etat === $request->valeur)
        {
            return redirect()->back()->with([
                'success' => true,
                'message' => 'Device stay '. $request->valeur .'.',
            ]);
        }


        // 🔥 ENVOI MQTT (ESP32)
        // $this->publishMqtt($device->mqttTopic, [
        //     'type' => $request->typeCom,
        //     'value' => $request->valeur
        // ]);

        $server = env("MQTT_SERVER", "localhost");
        $port = env("MQTT_PORT", 8883);
        $clientId = env("MQTT_CLIENTID", "laravel");
        $username = env('MQTT_USERNAME');
        $password = env('MQTT_PASSWORD');

        $connectionSettings = (new ConnectionSettings())
            ->setUsername($username)
            ->setPassword($password)
            ->setUseTls(true);
        $mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
        $mqtt->connect($connectionSettings, true);
        $mqtt->publish($topic, $request->valeur, 0);
        $mqtt->disconnect();

        $device->etat = $request->valeur;
        $device->save();

        return redirect()->back()->with([
            'success' => true,
            'message' => 'Commande envoyée',
        ]);
    }

    private function publishMqtt($topic, $payload)
    {
        // Exemple simple (lib php-mqtt)
        $mqtt = new \PhpMqtt\Client\MqttClient(env('MQTT_SERVER', '127.0.0.1'), env("MQTT_PORT",1883));

        $mqtt->connect();
        $mqtt->publish($topic, json_encode($payload));
        $mqtt->disconnect();
    }
}
