<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Sensor;

class SensorsApiController extends Controller
{
    public function updateSensorValue(Request $request)
    {
        if (!isset($request->name) || !isset($request->value)) {
            http_response_code(400);
            return;
        }

        $sensor = Sensor::where('name', $request->name)->first();
        if(!$sensor){
            http_response_code(404);
            return;
        }

        $sensor->value = round(floatval($request->value), 2);
        $sensor->save();

        echo $request->value;
    }

    public function getSensorValue($name)
    {
        $sensor = Sensor::where('name', $name)->first();

        return $sensor->value;
    }
}
