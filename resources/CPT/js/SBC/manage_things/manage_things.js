var url = "http://127.0.0.1:8000/api/equipments/values"

var AUTO_SMART_LAMP_PIN = 3
var SMART_LAMP_PIN = 2
var SMART_FAN_PIN = 1
var SMART_DOOR_PIN = 0

function setup() {
    pinMode(AUTO_SMART_LAMP_PIN, OUTPUT);
    pinMode(SMART_LAMP_PIN, OUTPUT);
    pinMode(SMART_FAN_PIN, OUTPUT);
    pinMode(SMART_DOOR_PIN, OUTPUT);
}

function loop() {

    RealHTTPClient.get(url, function (status, data) {
      
        var values = JSON.parse(data);
        Serial.println("********** ATUALIZAR ATUADORES **********")

        for(var i=0; i<values.length; i++){

            // Change Automatic Illumination state
            if(values[i].name == "Iluminação Automática"){
                customWrite(AUTO_SMART_LAMP_PIN, values[i].value);
                Serial.println("Iluminação Automática -> " + values[i].value)
                continue;
            }

            // Change Lamp state
            if(values[i].name == "Lâmpada"){
                customWrite(SMART_LAMP_PIN, values[i].value);
                Serial.println("Lâmpada -> " + values[i].value)
                continue;
            }

            // Change Fan state
            if(values[i].name == "Ventoinha"){
                customWrite(SMART_FAN_PIN, values[i].value);
                Serial.println("Ventoinha -> " + values[i].value)
                continue;
            }

            // Change Fire Sprinkler state
            if(values[i].name == "Smart Door"){
                customWrite(SMART_DOOR_PIN, values[i].value);
                Serial.println("Smart Door -> " + values[i].value)
                continue;
            }
        }
    });

    delay(2000);
}