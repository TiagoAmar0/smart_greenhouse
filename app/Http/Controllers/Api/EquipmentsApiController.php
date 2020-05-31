<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Equipment;
use App\Model\History;
use App\Model\StateText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EquipmentsApiController extends Controller
{
    public function updateEquipmentValue(Request $request)
    {

        if(!isset($request->values)){
            return response('Erro! Valores inválidos', 400)
                ->header('Content-Type', 'text/plain');
        }
        $output = "";
        $request->values = json_decode($request->values);
        if(is_array($request->values)){
            foreach ($request->values as $data){
                $equipment = Equipment::where('name', $data->name)->first();
                if(!$equipment){
                    return response('Erro! Equipamento inválido ('. $data->name .')', 400)
                        ->header('Content-Type', 'text/plain');
                }

                if($data->value!= $equipment->value){

                    if(is_numeric($data->value)){
                        $equipment->value = round(floatval($data->value), 2);
                    } else {
                        $equipment->value = $data->value;
                    }
                    $equipment->save();

                    $history = new History();
                    $history->value = $equipment->value;
                    $equipment->histories()->save($history);
                }

                $output .= $equipment->name . " -> " . $equipment->value . "| ";
            }
        } else {
            return response('Erro! Valores inválidos (ARRAY)', 400)
                ->header('Content-Type', 'text/plain');
        }


        echo $output;
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
        $equipments_values = Equipment::all('id', 'value', 'name', 'type', 'updated_at');

        foreach ($equipments_values as $equipment){
            if($equipment->type != 1){
                $state = StateText::where(['equipment_id' => $equipment->id, 'value' => $equipment->value])->first();
                if($state){
                    $equipment->state = $state->text;
                }
            }
        }

        return json_encode($equipments_values);
    }

    public function uploadWebcamPicture(Request $request){

        $name="webcam/" . time();

        $image = $request->file('image');
        if($image){

            // GET Webcam Equipment
            $equipment = Equipment::where('name', 'Webcam')->first();
            if(!$equipment){
//                TODO: ERROR
            }

            // Store image in uploads folder
            $extension = $image->getClientOriginalExtension();
            $new_filename = $name . '.'. $extension;
            Storage::disk('public')->put($new_filename, File::get($image));
            $path = '/uploads/' . $new_filename;

            // Save new value and add entry in equipment history
            $history = new History();
            $history->value = $path;
            $equipment->histories()->save($history);

            $equipment->value = $path;
            $equipment->save();

            return $path;
        }

        http_response_code(400);
    }
}
