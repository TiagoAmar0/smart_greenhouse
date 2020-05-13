<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Sensor;
use Illuminate\Http\Request;

class ThingsApiController extends Controller
{
    /**
     * SMART DOOR FUNCTIONS
     */

    // receives the Door id and assigns a new value to open/close and lock/unlock
    public function toggleDoorStatus($sensor_id, $value){
        Sensor::whereId($sensor_id)->update(['value' => $value]);
    }

    public function changeFanStatus($value){

    }
}
