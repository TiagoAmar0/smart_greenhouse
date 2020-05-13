<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Equipment;
use App\Model\Sensor;
use Illuminate\Http\Request;

class ThingsApiController extends Controller
{


    // receives the Door id and assigns a new value to open/close and lock/unlock
    public function changeDoorStatus($id, $value){
        $equipment = Equipment::findOrFail($id);

        if($equipment->value == $value){
            return redirect('/dashboard')->with('error', 'A porta já estava '. $value .'!');
        }

        $equipment->update(['value' => $value]);

        return redirect('/dashboard')->with('success', 'Estado da porta alterado para '. $value .'!');
    }

    public function changeFanStatus($id, $value){

        $equipment = Equipment::findOrFail($id);

        if($equipment->value == $value){
            return redirect('/dashboard')->with('error', 'A ventoinha já estava no estado '. $value .'!');
        }

        $equipment->update(['value' => $value]);

        return redirect('/dashboard')->with('success', 'Estado da ventoinha alterado para '. $value .'!');
    }
}
