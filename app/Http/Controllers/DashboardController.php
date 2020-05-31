<?php

namespace App\Http\Controllers;

use App\Model\Actuator;
use App\Model\StateText;
use App\Model\Thing;
use App\Model\Sensor;

class DashboardController extends Controller
{

    public function index()
    {
        // Get all sensors, atuators and things with associated equipment and actions
        $sensors = Sensor::with('equipment.actions')->get();
        $actuators = Actuator::with('equipment.actions')->get();
        $things = Thing::with('equipment.actions')->get();

        // Add state values text to thing
        foreach($things as $thing){
            // Get State related to equipment value
            $stateText = StateText::where(['equipment_id' => $thing->equipment->id, 'value' => $thing->equipment->value])->first();
            if($stateText){
                $thing->state = $stateText;
            }
        }

        // Add state values text to actuator
        foreach($actuators as $actuator){
            // Get State related to equipment value
            $stateText = StateText::where(['equipment_id' => $actuator->equipment->id, 'value' => $actuator->equipment->value])->first();

            if($stateText){
                $actuator->state = $stateText;
            }
        }

        return view('dashboard.index', ['sensors' => $sensors, 'actuators' => $actuators, 'things' => $things]);
    }
}
