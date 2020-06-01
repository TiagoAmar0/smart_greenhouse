var url = "http://127.0.0.1:8000/api/equipments/values"
var HEATING_PIN = 2
var COOLER_PIN = 1
var LAWN_SPRINKLER_PIN = 3
var FIRE_SPRINKLER_PIN = 0
var LCD_PIN = 4

function setup() {
    pinMode(HEATING_PIN, OUTPUT);
    pinMode(COOLER_PIN, OUTPUT);
    pinMode(LAWN_SPRINKLER_PIN, OUTPUT);
    pinMode(FIRE_SPRINKLER_PIN, OUTPUT);
    pinMode(LCD_PIN, OUTPUT);
}

function loop() {

    RealHTTPClient.get(url, function (status, data) {
      
        var values = JSON.parse(data);
        Serial.println("********** ATUALIZAR ATUADORES **********")

        for(var i=0; i<values.length; i++){

            // Change Heating state
            if(values[i].name == "Aquecimento"){
                values[i].value == 1 ? digitalWrite(HEATING_PIN, HIGH) : digitalWrite(HEATING_PIN, LOW);
                Serial.println("Aquecimento -> " + values[i].value)
                continue;
            }

            // Change Cooler state
            if(values[i].name == "Arrefecimento"){
                values[i].value == 1 ? digitalWrite(COOLER_PIN, HIGH) : digitalWrite(COOLER_PIN, LOW);
                Serial.println("Arrefecimento -> " + values[i].value)
                continue;
            }

            // Change Lawn Sprinkler state
            if(values[i].name == "Sistema de Rega"){
                values[i].value == 1 ? customWrite(LAWN_SPRINKLER_PIN, '1') : customWrite(LAWN_SPRINKLER_PIN, '0');
                Serial.println("Sistema de rega -> " + values[i].value)
                continue;
            }

            // Change Fire Sprinkler state
            if(values[i].name == "Aspersor de Incêncio"){
                values[i].value == 1 ? customWrite(FIRE_SPRINKLER_PIN, '1') : customWrite(FIRE_SPRINKLER_PIN, '0');
                Serial.println("Aspersor de Incêncio -> " + values[i].value)
                continue;
            }

            // Check Alarm status
            if(values[i].name == "Alarme"){
                values[i].value == 1 ?  customWrite(LCD_PIN, 'Alarme: ON') :  customWrite(LCD_PIN, 'Alarme: OFF');
                Serial.println("Alarme -> " + values[i].value)
                continue;
            }
        }
    });

    delay(2000);
}