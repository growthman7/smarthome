<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PhpMqtt\Client\MqttClient;
use phpMqtt\Client\ConnectionSettings;

class MqttServiceProvider extends ServiceProvider
{
    protected MqttClient $client;

    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(MqttClient::class, function () {
            $server = env('MQTT_SERVER', 'localhost');
            $port = env('MQTT_PORT', 1883);
            $clientId = env('MQTT_CLIENT_ID', 'mqtt_client');
            $username = env('MQTT_USERNAME', null);
            $password = env('MQTT_PASSWORD', null);

            $connectionSettings = (new ConnectionSettings())
                ->setUsername($username)
                ->setPassword($password);

            $this->client = new MqttClient($server, $port, $clientId);
            try {
                $this->client->connect($connectionSettings, true);
            } catch (\Exception $e) {
                // Gérer les erreurs de connexion MQTT
                throw new \RuntimeException('MQTT Connection Error: ' . $e->getMessage());
            }
        });
    }

    /**
     * Publier un message sur un topic MQTT
     */
    public function publish(string $topic, string $message, int $qos = 0): void
    {
        $this->client->publish($topic, $message, $qos);
    }

    /**
     * S'abonner à un topic
     */
    public function subscribe(string $topic, callable $callback, int $qos = 0): void
    {
        $this->client->subscribe($topic, $callback, $qos);
        $this->client->loop(true); // Boucle infinie pour écouter
    }

    public function disconnect(): void
    {
        $this->client->disconnect();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
