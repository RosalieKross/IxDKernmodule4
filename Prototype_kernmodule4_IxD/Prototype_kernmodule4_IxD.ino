#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFiClient.h>

#include <LiquidCrystal_I2C.h>

// set the LCD number of columns and rows
int lcdColumns = 16;
int lcdRows = 2;
LiquidCrystal_I2C lcd(0x27, lcdColumns, lcdRows);

#include "DHT.h"
#define DHTPIN 4
#define DHTTYPE DHT11  // DHT 11
DHT dht(DHTPIN, DHTTYPE);

#include <ESP32Servo.h>
Servo myservo;
int servoPin = 18;



const char* ssid     = "ASUS";
const char* password = "AF796CF44935";


const char* serverName = "https://studenthome.hku.nl/~rosalie.kross/post-esp-data.php";

String apiKeyValue = "tPmAT5Ab3j7F9";

String sensorName = "DH11";
String sensorLocation = "Bedroom";
int deviceCode = 1111;


//windowposition
bool windowIsOpen = false;
int servoPos = 0;    // variable to store the servo position
String WindowPos = "closed";
String WindowPosControll = "Closed";
bool WindowManual = false;
bool NightMode = false;

String WindowMode = "Manual";

#define SEALEVELPRESSURE_HPA (1013.25)

//Adafruit_BME280 bme;  // I2C


void setup() {
  Serial.begin(115200);

  //LCD
  lcd.init();
  lcd.backlight();
  // set cursor to first column, first row
  lcd.setCursor(0, 0);
  lcd.print("Welcome to");
  lcd.setCursor(5, 1);
  lcd.print("Wind-O");


  dht.begin();

  servoPos == servoPos;
  myservo.setPeriodHertz(50);    // standard 50 hz servo
  myservo.attach(servoPin, 1000, 2000);
  myservo.write(180);

  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());


}

void loop() {

  //Lees uidige kamertemp uit
  int temperature = temperatureReading();


  //Stuur huidige temp naar data base
  sendData(temperature);

  //Ingevoerde WindowPositie ophalen uit de Database
  int windowController = getWindowController();

  int windowPosController = getWindowOnOff();


  // UserPref temp ophalen uit de database
  int userPrefTemp = getUserPrefTemp();

  // Nightmode temp ophalen uit de database
  int NightModeTemp = getNightModeTemp();

  //met UserPref temp window in gewenste positie
  WindowControl(userPrefTemp, temperature, windowController, windowPosController, NightModeTemp);

//Display WindowPos on LCD
  lcdReadings(servoPos, temperature, userPrefTemp, NightModeTemp);



  delay(5000);
}

void WindowControl(int averageTemp, int temperature, int windowController, int windowPosController, int NightModeTemp) {
  
  
 //Als de windowController op Manual staat
 if(windowPosController == 1){
  WindowManual = true;
  WindowMode = "Manual";
  NightMode = false;
  Serial.println("THE WINDOW IS ON MANUAL!");
  
  if(windowController == 180){
    myservo.write(0);
    WindowPosControll = "open";
    Serial.println("Window is Helemaal open ");
    
  }

  if(windowController == 90){
    myservo.write(90);
    WindowPosControll = "half open";
    Serial.println("Window is half open");
  }

  if(windowController == 0){
    myservo.write(180);
    WindowPosControll = "closed";
    Serial.println("Window is Dicht ");
    }
  
  }

  //Als de windowController op Manual staat
 if(windowPosController == 2){
  WindowManual = false;
  NightMode = true;
  WindowMode = "NightMode";
  Serial.println("THE WINDOW IS ON NightMode!");
  
  if(temperature <= NightModeTemp){
    myservo.write(180);
    WindowPosControll = "close";
    Serial.println("Window is Helemaal open ");
    
  }

  if(temperature >= NightModeTemp){
    myservo.write(0);
    WindowPosControll = "open";
    Serial.println("Window is open");
  }
  
  }

  
  //Als de windowcontroller op automatic staat (0)
  if(windowPosController == 0){
    WindowManual = false;
    NightMode = false;
    WindowMode = "Automatic";

    Serial.println("THE WINDOW IS ON Automatic!");

  // Opens window when temp is higher than 26
  if (temperature >= averageTemp) {
    myservo.write(0);
    //Serial.println("RAAM HELEMAAL OPEN");
    //Serial.println(servoPos);
    windowIsOpen = true;
  }

  //Closes window when temp is lower than 26
  if (temperature <= averageTemp) {
    myservo.write(180);
    //Serial.println("Raam DICHT");
    //Serial.println("servo position: ");
    windowIsOpen = false;
  }

  if (windowIsOpen == true) {
    servoPos = 180;
    WindowPos = "Open";
    Serial.println("Window is ");
    Serial.print(WindowPos);
  }

  if (windowIsOpen == false) {
    servoPos = 0;
    WindowPos = "Closed";
    Serial.println("Window is ");
    Serial.print(WindowPos);
  }

  }

}

int temperatureReading() {

  delay(2000);

  float humidity = dht.readHumidity();
  // Read temperature as Celsius (the default)
  float temperature = dht.readTemperature();


  if (isnan (humidity) || isnan(temperature)) {
    Serial.println(F("Failed to read from DHT sensor!"));
    return -1;
  }

  Serial.print(F("Humidity: "));
  Serial.print(humidity);
  Serial.print(F("%  Temperature: "));
  Serial.print(temperature);
  Serial.println(F("°C "));



  return temperature;


}

void lcdReadings(int servoPos, int temperature, int userPrefTemp, int NightModeTemp){

if(WindowManual == true){
 lcd.clear();
 lcd.setCursor(0, 0);
 lcd.print("Control: Manual");
 lcd.setCursor(0, 1);
 lcd.print("Window:");
 lcd.setCursor(7, 1);
 lcd.print(WindowPosControll);
 delay(1000);
}

if(NightMode == true){
 lcd.clear();
 lcd.setCursor(0, 0);
 lcd.print("Control:NightMode");
 lcd.setCursor(0, 1);
 lcd.print("Window:");
 lcd.setCursor(7, 1);
 lcd.print(WindowPosControll);
 delay(2000);
 lcd.clear();
lcd.setCursor(0, 0);
lcd.print("RoomTemp:");
lcd.setCursor(9, 0);
lcd.print(temperature); 
lcd.setCursor(12, 0);
lcd.print((char)223);
lcd.setCursor(13, 0);
lcd.print("C");
lcd.setCursor(0, 1);
lcd.print("NightM Temp:");
lcd.setCursor(12, 1);
lcd.print(NightModeTemp);
lcd.setCursor(14, 1);
lcd.print((char)223);
lcd.setCursor(15, 1);
lcd.print("C");
delay(2000);
lcd.clear();
 lcd.setCursor(0, 0);
 lcd.print("Control:NightMode");
 lcd.setCursor(0, 1);
 lcd.print("Window:");
 lcd.setCursor(7, 1);
 lcd.print(WindowPosControll);
 delay(1000);
}

if(WindowManual == false && NightMode == false){  
lcd.clear();
lcd.setCursor(0, 0);
lcd.print("RoomTemp:");
lcd.setCursor(9, 0);
lcd.print(temperature); 
lcd.setCursor(12, 0);
lcd.print((char)223);
lcd.setCursor(13, 0);
lcd.print("C");
lcd.setCursor(0, 1);
lcd.print("Window:");
lcd.setCursor(7, 1);
lcd.print(WindowPos);
delay(2000);
lcd.clear();
lcd.setCursor(0, 0);
lcd.print("Set roomTemp is");
lcd.setCursor(6, 1);
lcd.print(userPrefTemp);
lcd.setCursor(8, 1);
lcd.print((char)223);
lcd.setCursor(9, 1);
lcd.print("C");
delay(3000);
lcd.clear();
lcd.clear();
lcd.setCursor(0, 0);
lcd.print("RoomTemp:");
lcd.setCursor(10, 0);
lcd.print(temperature); 
lcd.setCursor(12, 0);
lcd.print((char)223);
lcd.setCursor(13, 0);
lcd.print("C");
lcd.setCursor(0, 1);
lcd.print("Window:");
lcd.setCursor(7, 1);
lcd.print(WindowPos);

delay(1000);
  
}
  }

int getNightModeTemp() {

  int NightModeTemp = 0;

  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;


    http.begin("https://studenthome.hku.nl/~rosalie.kross/getNightModeTempIxD4.php?Device_code=1111");


    int httpResponseCode = http.GET();

    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);

      String response = http.getString();
      NightModeTemp = response.toInt();
      Serial.print("Pref Room temp:");
      Serial.println(NightModeTemp);

    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);

    }
    // Free resources
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }

  return NightModeTemp;

}









int getUserPrefTemp() {

  int userPrefTemp = 0;

  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;


    http.begin("https://studenthome.hku.nl/~rosalie.kross/getRequestIxD4.php?Device_code=1111");


    int httpResponseCode = http.GET();

    

    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);

      String response = http.getString();
      userPrefTemp = response.toInt();
      Serial.print("Pref Room temp:");
      Serial.println(userPrefTemp);

    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);

    }
    // Free resources
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }

  return userPrefTemp;

}

void sendData(float temperature) {

  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    String httpRequestData = "api_key=" + apiKeyValue + "&sensor=" + sensorName + "&temp=" + String(temperature)
                         + "&humidity=" + String(dht.readHumidity()) +  "&windowPos=" + WindowPos + "&deviceCode=" + deviceCode + "";
                         
    
    http.begin("https://studenthome.hku.nl/~rosalie.kross/post-esp-data.php?" + httpRequestData);
    

    int httpResponseCode = http.GET();



    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);

      String response = http.getString();
      Serial.println(response);
 

    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);

    }
    // Free resources
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }

}

int getWindowController() {

  int windowController = 0;

  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;


    http.begin("https://studenthome.hku.nl/~rosalie.kross/getWindowControls.php?Device_code=1111");


    int httpResponseCode = http.GET();

    

    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);

      String response = http.getString();
      windowController = response.toInt();
      Serial.print("Given windowPos");
      Serial.println(windowController);

    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);

    }
    // Free resources
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }

  return windowController;

}

int getWindowOnOff() {

  int windowPosController = 0;

  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;


    http.begin("https://studenthome.hku.nl/~rosalie.kross/getWindowOnOff.php?Device_code=1111");


    int httpResponseCode = http.GET();

    

    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);

      String response = http.getString();
      windowPosController = response.toInt();
      Serial.print("WindowStatus is");
      Serial.println(windowPosController);

    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);

    }
    // Free resources
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }

  return windowPosController;

}
