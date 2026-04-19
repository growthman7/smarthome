#include <WiFi.h>
#include <HTTPClient.h>
#include <Preferences.h>

const char* ssid = "AROWA";
const char* password = "KouakoffiN*1925";

String server = "http://localhost:8000";

Preferences preferences;

String sensor_key;

String getDeviceId(){

uint64_t chipid = ESP.getEfuseMac();

char id[20];

sprintf(id,"%04X%08X",(uint16_t)(chipid>>32),(uint32_t)chipid);

return String(id);

}

void registerSensor(){

HTTPClient http;

String device_id = getDeviceId();

http.begin(server + "/api/capteurs");

http.addHeader("Content-Type","application/json");

String json = "{\"device_id\":\""+device_id+"\"}";

int code = http.POST(json);

if(code==200){

String payload = http.getString();

Serial.println(payload);

preferences.begin("sensor",false);

preferences.putString("key",payload);

preferences.end();

}

http.end();

}

void sendData(){

HTTPClient http;

http.begin(server + "/api/sensor-data");

http.addHeader("Content-Type","application/json");

float temperature = 26;

String json = "{\"cle_capteur\":\""+sensor_key+"\",\"Temp\":"+String(temperature)+"}";

http.POST(json);

http.end();

}

void setup(){

Serial.begin(115200);

WiFi.begin(ssid,password);

while(WiFi.status()!=WL_CONNECTED){

delay(500);

Serial.print(".");

}

Serial.println("Connected");

preferences.begin("sensor",true);

sensor_key = preferences.getString("key","");

preferences.end();

if(sensor_key==""){

registerSensor();

preferences.begin("sensor",true);

sensor_key = preferences.getString("key","");

preferences.end();

}

}

void loop(){

// sendData();

delay(10000);

}