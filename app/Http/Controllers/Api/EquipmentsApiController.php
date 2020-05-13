<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Equipment;
use Illuminate\Http\Request;
use App\Model\Sensor;

class EquipmentsApiController extends Controller
{
    public function updateSensorValue(Request $request)
    {
        if (!isset($request->name) || !isset($request->value)) {
            http_response_code(400);
            return;
        }

        $equipment = Equipment::where('name', $request->name)->first();
        if(!$equipment){
            http_response_code(404);
            return;
        }

        $equipment->value = round(floatval($request->value), 2);
        $equipment->save();

        echo $request->value;
    }

    public function getSensorValue($name)
    {
        $name = $this->convertURLParameter($name);
        $equipment = Equipment::where('name', $name)->first();
        if(!$equipment){
            return response()->json([
                'message' => 'Equipment not found'], 404);
        }

        return $equipment->value;
    }

    private function convertURLParameter($param){
        return str_replace('_', ' ', $param);
    }
}
