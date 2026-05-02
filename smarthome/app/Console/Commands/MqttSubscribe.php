<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;

class MqttSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
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

        $mqtt->subscribe('maison/1/temperature', function ($topic, $message) {
            //Découpage JSON
            $data = json_decode($message, true);
            // echo $data;

            if (isset($data['temperature'])) {

                $temperature = $data['temperature'];
                echo $temperature;
                \App\Models\Donnee::create([
                    'type' => 'temperature',
                    'valeur' => $temperature,
                    'device_id' => 1, // ID du device associé à la température
                ]);

            } else {
                echo "Format invalide reçu !" . PHP_EOL;
            }

        }, 0);

        $mqtt->loop(true);
    }
}
