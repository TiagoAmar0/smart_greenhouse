<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Equipment;
use App\Model\History;
use App\Model\StateText;
use Illuminate\Http\Request;
use App\Model\Sensor;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class EquipmentsApiController extends Controller
{
    public function updateEquipmentValue(Request $request)
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

        $history = new History();
        $history->value = $equipment->value;
        $equipment->histories()->save($history);

        echo $request->value;
    }

    public function getEquipmentValue($name)
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

    public function retrieveAllEquipmentsValues(){
        $equipments_values = Equipment::all('id', 'value', 'type', 'updated_at');

        foreach ($equipments_values as $equipment){
            if($equipment->type != 1){
                $state = StateText::where(['equipment_id' => $equipment->id, 'value' => $equipment->value])->first();
                if($state){
                    $equipment->value = $state->text;
                }
            }
        }

        return response()->json($equipments_values);
    }
}
