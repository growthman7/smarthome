#include <WiFi.h>
#include <WebServer.h>
#include <Preferences.h>
#include <HTTPClient.h>
#include <WiFiClientSecure.h>
#include <PubSubClient.h>

Preferences preferences;

WebServer server(80);

char ssid[32];
char password[64];
bool wifiConfigured = false;

char deviceId[18];

// Paramètres réseau
IPAddress local_IP(192, 168, 1, 254);   // IP fixe
IPAddress gateway(192, 168, 1, 1);      // passerelle (souvent l’adresse du routeur)
IPAddress subnet(255, 255, 255, 0);     // masque de sous-réseau
IPAddress primaryDNS(8, 8, 8, 8);       // DNS primaire (Google)
IPAddress secondaryDNS(8, 8, 4, 4);     // DNS secondaire (Google)

// MQTT HiveMQ
const char* mqtt_server = "xxxxx.s1.eu.hivemq.cloud";
const int mqtt_port = 8883;
const char* mqtt_user = "USERNAME";
const char* mqtt_pass = "PASSWORD";

WiFiClientSecure espClient;
PubSubClient client(espClient);

//GPIO devices
#define LED_SALON 2
#define LED_CHAMBRE 4
#define VOLET_PIN 5

static unsigned long lastWifiCheck = 0;
/* ================================
   PAGE HTML
================================ */

String page = R"rawliteral(
  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="UTF-8">
      <title>ESP32 CONFIG</title>
      <style>
        body{
          font-family:Arial;
          background:#f2f2f2;
          display:flex;
          justify-content:center;
          align-items:center;
          height:100vh;
        }
        .card{
          background:white;
          padding:30px;
          border-radius:10px;
          box-shadow:0 4px 10px rgba(0,0,0,0.2);
          width:300px;
        }
        input,select{
          width:100%;
          padding:10px;
          margin-bottom:10px;
        }
        button{
          background:#007BFF;
          color:white;
          border:none;
          padding:10px;
          width:100%;
        }
      </style>
    </head>

    <body>

    <div class="card">

    <h3>Configuration WiFi</h3>

    <form method="POST" action="/save">

    <select name="ssid">
    {{WIFI_LIST}}
    </select>

    <input type="password" name="password" placeholder="Mot de passe">

    <button type="submit">Enregistrer</button>

    </form>

    </div>

    </body>
  </html>
  )rawliteral";



/* ================================
   SCAN WIFI
================================ */

String getWifiList(){
  String options="";
  int n = WiFi.scanNetworks(true);

  for(int i=0;i<n;i++){
    options += "<option value='";
    options += WiFi.SSID(i);
    options += "'>";
    options += WiFi.SSID(i);
    options += "</option>";
  }
  return options;
}



/* ================================
   PAGE PRINCIPALE
================================ */

void handleRoot(){
  String pageHtml = page;
  pageHtml.replace("{{WIFI_LIST}}",getWifiList());

  server.send(200,"text/html",pageHtml);
}



/* ================================
   SAUVEGARDE WIFI
================================ */

void saveWifi(String ssid,String password){
  preferences.begin("wifi_config",false);

  preferences.putString("ssid",ssid);

  preferences.putString("password",password);

  preferences.end();
}



/* ================================
   LECTURE WIFI
================================ */

bool loadWifi(){
  preferences.begin("wifi_config",true);//true => lecture seule

  bool exist =
  preferences.isKey("ssid") &&
  preferences.isKey("password");

  if(exist){
    ssid = preferences.getString("ssid","");
    password = preferences.getString("password","");
  }
  preferences.end();
  return exist;
}



/* ================================
   CONNEXION WIFI
================================ */

bool connectWifi(){
   // Configuration IP statique
  if (!WiFi.config(local_IP, gateway, subnet, primaryDNS, secondaryDNS)) {
    Serial.println("Erreur de configuration IP");
  }
  WiFi.begin(ssid.c_str(),password.c_str());

  Serial.print("Connexion WiFi");

  // int timeout = 20;
  // while(WiFi.status()!=WL_CONNECTED && timeout>0){
  //   delay(500);
  //   Serial.print(".");
  //   timeout--;
  // }

  unsigned long start = millis();
  while (WiFi.status() != WL_CONNECTED && millis() - start < 15000) {
      delay(100);
  }

  if(WiFi.status()==WL_CONNECTED){
    Serial.println("");
    Serial.println("Connecté !");
    Serial.println(WiFi.localIP());
    return true;
  }

  Serial.println("");
  Serial.println("Echec connexion");
  return false;
}


// FONCTIONS MQTT
//Parser Topic
void handleMessage(String topic, String message) {

  Serial.println("Topic: " + topic);
  Serial.println("Message: " + message);

  if (topic.split("/").length < 5) return;
  // Découper topic
  int first = topic.indexOf('/');
  int second = topic.indexOf('/', first + 1);
  int third = topic.indexOf('/', second + 1);
  int fourth = topic.indexOf('/', third + 1);

  String maison = topic.substring(first + 1, second);
  String piece  = topic.substring(second + 1, third);
  String type   = topic.substring(third + 1, fourth);
  String device = topic.substring(fourth + 1);

  // 🔥 LOGIQUE INTELLIGENTE

  // 💡 LIGHT
  if (type == "light") {

    if (piece == "salon") {
      digitalWrite(LED_SALON, message == "ON" ? HIGH : LOW);
    }

    if (piece == "chambre") {
      digitalWrite(LED_CHAMBRE, message == "ON" ? HIGH : LOW);
    }
  }

  // 🪟 VOLET
  else if (type == "volet") {

    if (message == "OPEN") {
      digitalWrite(VOLET_PIN, HIGH);
    } 
    else if (message == "CLOSE") {
      digitalWrite(VOLET_PIN, LOW);
    }
  }

  // 🌡️ TEMP (ex: config seuil)
  else if (type == "temperature") {
    Serial.println("Config température reçue");
  }
}

// Callback MQTT
void callback(char* topic, byte* payload, unsigned int length) {

  char message[length + 1];
  memcpy(message, payload, length);
  message[length] = '\0';

  for (int i = 0; i < length; i++) {
    message += (char)payload[i];
  }

  handleMessage(String(topic), message);
}

// Reconexion
unsigned long lastReconnectAttempt = 0;
void reconnect() {
  if (millis() - lastReconnectAttempt > 5000) {
    lastReconnectAttempt = millis();
    if (client.connect("ESP32_SMARTHOME", mqtt_user, mqtt_pass)) {

      // Subscribe toute la maison
      client.subscribe("maison/1/#");

    }
  }
}

/*FONCTIONS API*/
/*ENREGISTREMENT API */

// void registerDevice(){
//   if(WiFi.status()!=WL_CONNECTED) return;

//   HTTPClient http;

//   String url="http://localhost:8000/api/devices";

//   http.begin(url);

//   http.addHeader("Content-Type","application/json");

//   String payload="{";

//   payload += "\"device_id\":\""+deviceId+"\",";

//   payload += "\"ip\":\""+WiFi.localIP().toString()+"\"";

//   payload+="}";

//   int response=http.POST(payload);

//   Serial.println("API Response : "+String(response));

//   http.end();
// }

// /*RECUPERER LES DONNEES*/
// void fetchData() {
//   //On va récupérer les données du serveur MQTT;
//   //Les données seront dans l'url sous la forme : maison/{$maisonId}/{$pieceId}/{$typeDevice}/{$deviceId}
//   HTTPClient http;

// }





/* ================================
   ROUTE SAVE
================================ */

void handleSave(){
  if(server.hasArg("ssid") && server.hasArg("password")){

    ssid=server.arg("ssid");

    password=server.arg("password");

    saveWifi(ssid,password);

    server.send(200,"text/html","<h2>Configuration sauvegardée</h2><p>Redémarrage...</p>");

    delay(2000);

    ESP.restart();

  }

}



/* ================================
   MODE CONFIGURATION
================================ */

void startConfigPortal(){
  WiFi.softAP("ESP32_SETUP","12345678"); //Configurer un point d'accès

  Serial.println("Mode configuration");

  Serial.println(WiFi.softAPIP()); //Afficher l'adresse IP de l'ESP32 dans la commande série

  server.on("/",HTTP_GET,handleRoot);

  server.on("/save",HTTP_POST,handleSave);

  server.begin();

}

void clearSettings() {
  preferences.begin("wifi_config",false); //false => lecture + écriture
  preferences.clear();
  preferences.end();
}



/* ================================
   SETUP
================================ */

void setup(){
  //put the setup code here
  Serial.begin(115200);

  pinMode(LED_SALON, OUTPUT);
  pinMode(LED_CHAMBRE, OUTPUT);
  pinMode(VOLET_PIN, OUTPUT);

  deviceId = WiFi.macAddress();

  Serial.println("Device ID : "+deviceId);

  wifiConfigured = loadWifi();

  if(wifiConfigured){
    if(connectWifi()){
    //  registerDevice();
      Serial.println("CONNECTED !");
    }
    else{
      startConfigPortal();
    }
  }
  else{
    startConfigPortal();
  }

  espClient.setInsecure();

  client.setServer(mqtt_server, mqtt_port);
  client.setCallback(callback);
}

void loop(){
  //put the loop code here
  if (millis() - lastWifiCheck > 10000) {
    lastWifiCheck = millis();
    if (WiFi.status() != WL_CONNECTED) {
      connectWifi();
    }
  }

  server.handleClient();

  if (!client.connected()) reconnect();
  client.loop();


}