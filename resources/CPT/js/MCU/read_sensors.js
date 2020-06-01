var url = "http://localhost:8000/api/equipments";

var TEMPERATURE_SENSOR_PIN = A0;
var WATER_SENSOR_PIN = A1;
var HUMIDITY_SENSOR_PIN = A2;
var SMOKE_SENSOR_PIN = A3;
var PHOTO_SENSOR_PIN = 0;
var FIRE_MONITOR_PIN = 1;


// Reads and converts the temperature value from sensor
function readTemperature(slot){
    var temp = (analogRead(slot) /1023 * 200) - 100;
    return temp;
}

function readLuminosity(slot){
    return  Math.floor(map(digitalRead(slot), 0, 1023, 0, 100) + 0.5);
}

function readSmokePercentage(slot){
    return Math.floor(map(analogRead(slot), 0, 1023, 0, 100) + 0.5);
}

function readFire(slot){
    return digitalRead(slot) === 0 ? 0 : 1;
}

function readWaterLevel(slot){
    return Math.floor(map(analogRead(slot), 0, 1023, 0, 20) + 0.5);
}

function readHumidity(slot){
    return Math.floor(map(analogRead(slot), 0, 255, 0, 255) + 0.5) / 10;
}

function sendDataToServer(data){
    Serial.println("********** A LER DADOS DOS SENSORES **********")

    var values = {
        values: JSON.stringify(data)
    }

    RealHTTPClient.post(url,values, function(status, data){
        if(status == 200){
            Serial.println(data);
        } else {
            Serial.print("ERRO! Status: "+ status + ". " + data);
        }
    });
}


function setup(){
    pinMode(TEMPERATURE_SENSOR_PIN, INPUT)
    pinMode(PHOTO_SENSOR_PIN, INPUT)
    pinMode(FIRE_MONITOR_PIN, INPUT)
    pinMode(SMOKE_SENSOR_PIN, INPUT)
    pinMode(HUMIDITY_SENSOR_PIN, INPUT)
    pinMode(WATER_SENSOR_PIN, INPUT)
}

function loop(){
    // Array that will contain all sensors information
    var data = [];

    // Retrieve temperature
    var temperature = readTemperature(TEMPERATURE_SENSOR_PIN);

    data.push({ name: 'Sensor de Temperatura', value: temperature })

    /** TEMPERATURE VALIDATIONS */
    if(temperature > 25){
        // Turn on cooler and turn off heater
        data.push({ name: 'Arrefecimento', value: 1 })
        data.push({ name: 'Aquecimento', value: 0 })
    } else if(temperature < 15){
        // Turn off cooler and turn on heater
        data.push({ name: 'Arrefecimento', value: 0 })
        data.push({ name: 'Aquecimento', value: 1 })
    } else {
        // Turn both cooler and heater off
        data.push({ name: 'Arrefecimento', value: 0 })
        data.push({ name: 'Aquecimento', value: 0 })
    }
    /** END OF TEMPERATURE VALIDATIONS */

    // Retrieve luminosity
    var luminosity = readLuminosity(PHOTO_SENSOR_PIN);
    data.push({ name: 'Sensor de Luminosidade', value: luminosity })

    /** LUMINOSITY VALIDATIONS */
    if(luminosity < 35){
        // Turn automatic illumination on
        data.push({ name: 'Iluminação Automática', value: 2 })
    } else if (luminosity > 85){
        // Turn automatic illumination off
        data.push({ name: 'Iluminação Automática', value: 0 })
    } else {
        // Turn automatic illumination on (Dim m)
        data.push({ name: 'Iluminação Automática', value: 1 })
    }
    /** END OF LUMINOSITY VALIDATIONS */

    // Retrieve fire monitor
    var fire = readFire(1);
    data.push({ name: 'Monitor de Incêndio', value: (fire == 1 ? "Detetado" : "Não detetado")})

    // Update fire sprinkler status
    data.push({ name: 'Aspersor de Incêncio', value: fire })
    /** FIRE VALIDATIONS */
    if(fire == 1){
        // Opens smart door
        data.push({ name: 'Smart Door', value: '1,0' })
    }


    // Retrieve smoke
    data.push({ name: 'Sensor de Fumo', value: readSmokePercentage(SMOKE_SENSOR_PIN)})

    // Retrieve water level
    var water_level = readWaterLevel(WATER_SENSOR_PIN)
    data.push({ name: 'Nivel de Água no Solo', value: water_level })

    /** WATER LEVEL VALIDATIONS */
    if(water_level < 5){
        // Turn on sprinkler
        data.push({ name: 'Sistema de Rega', value: 1 })
    } else {
        // Turn off sprinkler
        data.push({ name: 'Sistema de Rega', value: 0 })
    }
    /** END WATER LEVEL VALIDATIONS */

    // Retrieve humidity
    data.push({ name: 'Sensor de Humidade', value: readHumidity(A2) })

    sendDataToServer(data)
    
    delay(2000)
}