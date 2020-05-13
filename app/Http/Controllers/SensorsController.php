<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Requests\SensorsRequest;
use App\Model\Sensor;


class SensorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Gets all sensors information
        $sensors = Sensor::with('equipment')->get();
        return view('sensors.index', ['sensors' => $sensors]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the sensor information according to the ID provided in GET request
        $sensor = Sensor::findOrFail($id);
        return view('sensors.edit', ['sensor' => $sensor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SensorsRequest $request, $id)
    {
        // Validates the form data according to SensorsRequest rules
        $validatedData = $request->validated();

        // Updates data
        Sensor::whereId($id)->update($validatedData);

        return redirect('/dashboard/sensors')->with('success', 'O sensor foi atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the sensor information according to the ID provided in DELETE request
        $sensor = Sensor::findOrFail($id);

        // Deletes the record from the database
        $sensor->delete();

        return redirect('/dashboard/sensors')->with('success', 'O sensor foi eliminado com sucesso!');
    }
}
