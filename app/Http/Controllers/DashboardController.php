<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Sensor;

class DashboardController extends Controller
{

    public function index()
    {
        $sensors = Sensor::all();

        return view('dashboard.index', ['sensors' => $sensors]);
    }
}
