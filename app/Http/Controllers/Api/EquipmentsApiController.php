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
    // Updates the value of given equipments
    // Receives a object with a key 'values' that contains a JSON object with all equipments and values to update
    public function updateEquipmentValue(Request $request)
    {

        // Checks if request as 'values' key and return with error if not
        if(!isset($request->values)){
            return response('Erro! Valores inválidos', 400)
                ->header('Content-Type', 'text/plain');
        }

        $output = "";

        // Decode JSON
        $request->values = json_decode($request->values);


        // if json is a valid array, proceed to updates
        if(is_array($request->values)){

            // Loop equipments values
            foreach ($request->values as $data){
                // Get equipment by name
                $equipment = Equipment::where('name', $data->name)->first();

                // Send error if equipment is not found
                if(!$equipment){
                    return response('Erro! Equipamento inválido ('. $data->name .')', 400)
                        ->header('Content-Type', 'text/plain');
                }

                // Only updates if new values difer from values in database
                if($data->value != $equipment->value){

                    // If numeric, round number with 2 decimal places. Otherwise just send text
                    if(is_numeric($data->value)){
                        $equipment->value = round(floatval($data->value), 2);
                    } else {
                        $equipment->value = $data->value;
                    }

                    // Save record
                    $equipment->save();

                    // Adds new entry to history
                    $history = new History();
                    $history->value = $equipment->value;
                    $equipment->histories()->save($history);
                }

                $output .= $equipment->name . " -> " . $equipment->value . "| ";
            }
        } else {
            // Sends error
            return response('Erro! Valores inválidos (ARRAY)', 400)
                ->header('Content-Type', 'text/plain');
        }


        echo $output;
    }

    // Retrieves the current value from an equipment
    // The parameter $name must have the exact same string as the equipment to update
    public function getEquipmentValue($name)
    {
        // Converts url parameter to string
        $name = $this->convertURLParameter($name);

        // Finds equipment and check if exists
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


    // Retrieve value of all equipments in a JSON string
    public function retrieveAllEquipmentsValues(){

        // Get all equipments values
        $equipments_values = Equipment::all('id', 'value', 'name', 'type', 'updated_at');

        // Add values translation (if exists)
        foreach ($equipments_values as $equipment){
            if($equipment->type != 1){
                $state = StateText::where(['equipment_id' => $equipment->id, 'value' => $equipment->value])->first();
                if($state){
                    $equipment->state = $state->text;
                }
            }
        }

        // Encode to JSON and return data
        return json_encode($equipments_values);
    }

    public function uploadWebcamPicture(Request $request){

        $name="webcam/" . time();

        $image = $request->file('image');

        if(!$image) {
            return response()->json([
                'message' => 'Image not found in request'], 400);
        }

        // GET Webcam Equipment
        $equipment = Equipment::where('name', 'Webcam')->first();
        if(!$equipment){
            return response()->json([
                'message' => 'Equipment not found'], 400);
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
}
