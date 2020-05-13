<?php

namespace App\Http\Controllers;

use App\Model\Actuator;
use App\Model\Equipment;
use App\Model\Thing;
use Illuminate\Http\Request;
use App\Model\Sensor;

class DashboardController extends Controller
{

    public function index()
    {
        $sensors = Sensor::with('equipment.actions')->get();
        $actuators = Actuator::with('equipment.actions')->get();
        $things = Thing::with('equipment.actions')->get();

        return view('dashboard.index', ['sensors' => $sensors, 'actuators' => $actuators, 'things' => $things]);
    }
}
