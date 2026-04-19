#include <WiFi.h>
#include <WebServer.h>
#include <Preferences.h>

Preferences preferences;
String ssid;
String password;
Boolean isWifiExist;

WebServer server(80); //L'objet server qui sera utilisé pour manipuler le server web

//Code HTML pour la page de configuration
String page_config = R"rawliteral(
<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>NETWORK CONFIG</title>
      <style>
          body {
              font-family: Arial, sans-serif;
              background-color: #f0f0f0;
              display: flex;
              justify-content: center;
              align-items: center;
              height: 100vh;
              margin: 0;
          }
          div {
              position: relative;
              background-color: #fff;
              padding: 20px;
              border-radius: 8px;
              box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
              width: 300px;
          }
          form {
              display: flex;
              flex-direction: column;
              position: relative;
              width: 100%;
          }

          h1 {
              font-size: 18px;
              margin-bottom: 10px;
          }
          p {
              font-size: 14px;
              margin-bottom: 20px;
          }
          label {
              display: block;
              margin-bottom: 5px;
              font-weight: bold;
          }
          input[type="text"],
          input[type="password"] {
              width: 100%;
              padding: 8px;
              margin-bottom: 15px;
              border: 1px solid #ccc;
              border-radius: 4px;
          }
          button {
              width: 100%;
              padding: 10px;
              background-color: #007BFF;
              color: white;
              border: none;
              border-radius: 4px;
              cursor: pointer;
          }
          button:hover {
              background-color: #0056b3;
          }
          #divssid, #divpassword {
              position: relative;
              width : 250px;
              overflow: hidden;
          }
      </style>
  </head>
  <body>
      <div>
          <h1>CONFIGURATION DE VOTRE RESEAU</h1>
          <p>Configurer votre réseau local domestique.</p>
          <form method="post" action="/save">
              <div id="divssid">
                  <label for="ssid">Nom du réseau (SSID) :</label>
                  <input type="text" id="ssid" name="ssid" placeholder="MonReseau">
              </div>
              <div id="divpassword">
                  <label for="password">Mot de passe :</label>
                  <input type="password" id="password" name="password" placeholder="Mot de passe" autocomplete="new-password">
              </div>
              <button type="submit">
                  Enregistrer
              </button>
          </form>
      </div>
  </body>
</html>
)rawliteral";

//Fonction pour sauvegarder les informations du WIFI local
void saveWifiConfig(String ssid, String password) {
  preferences.begin("wifi_config", false);//false => lecture + écriture
  preferences.putString("ssid", ssid);
  preferences.putString("password", password);
  preferences.end();
}

//Fonction pour afficher la configuration du WIFI stocké dans la mémoire flash
void showWifiConfig() {
  preferences.begin("wifi_config", true);//true => Lecture seule
  if(preferences.isKey("ssid") && preferences.isKey("password")) {
    String ssid = preferences.getString("ssid", "");
    String password = preferences.getString("password", "");
    String response = "SSID : " + ssid + "\nPASSWORD : " + password;
    Serial.println(response);
  }
  preferences.end();
}

void clearPreferences() {
  preferences.begin("wifi_config", false);//false => lecture + écriture
  preferences.clear();
  preferences.end();
}

//Fonction pour se connecter au Wifi
void connectWifi(ssid, password) {
  WiFi.begin(ssid, password);
  while(WiFi.status()!=WL_CONNECTED){
    delay(500);
    Serial.println(".");
  }
  Serial.println("Connected");
}

//Fonction pour afficher la page de configuration
void handleroot() {
  server.send(200, "text/html", page_config);
}

//Fonction pour enregistrer la configuration Wifi dans la mémoire flash
void handleConfig() {
  if(server.hasArg("ssid") && server.hasArg("password")) {
    ssid = server.arg("ssid");
    password = server.arg("password");
  }
  saveWifiConfig(ssid, password);

  String response = "SSID : " + ssid + "<br>Password : " + password;
  server.send(200, "text/html", response);
}

//Fonction d'initialisation
void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);

  preferences.begin("wifi_config", true);//true => Lecture seule
  isWifiExist = preferences.isKey("ssid") && preferences.isKey("password");
  preferences.end();

  if(isWifiExist) {
    preferences.begin("wifi_config", true);//true => Lecture seule
    ssid = prefereences.getString("ssid", "");
    password = preferences.getString("password");
    connectWifi(ssid, password);
  }else{
    Serial.println("Configuration du point d'accès");
    ssid = "ESP32_NETWORK";
    password = "12345678";
    if(!WiFi.softAP(ssid, password)) {
      log_e("Echec lors de la création du point d'accès.");
    }
    IPAddress espIP = WiFi.softAPIP();
    Serial.println("Adresse IP : ");
    Serial.println(espIP);

    //Les routes et lancer le serveur
    server.on("/", HTTP_GET, handleroot);
    server.on("/save", HTTP_POST, handleConfig);
    server.on("/show", HTTP_GET, [](){
      showWifiConfig();
      server.send(200, "text/html", "Configuration du Wifi");
    });
    server.on("/resetconfig", HTTP_GET, [](){
      clearPreferences();
      server.send(200, "text/html", "<h1>Configuration rénintialisée</h1>");
    });
    server.onNotFound([]() {
      String url = server.uri();
      Serial.println("URL demandée : " + url);
      server.send(404, "text/plain", "Page non trouvée");
    });
    server.begin();
    Serial.println("Le serveur a démarré.");
  }
  

}

//Le code de cette fonction s'exécutera en boucle
void loop() {
  // put your main code here, to run repeatedly:
  server.handleClient();
}
