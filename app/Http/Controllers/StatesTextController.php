<?php

namespace App\Http\Controllers;

use App\Model\Equipment;
use App\Model\StateText;
use App\Http\Requests\StatesTextRequest;

class StatesTextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Gets all states with related equipment information
        $states = StateText::with('equipment')->get();

        return view('equipments.states.index', ['states' => $states]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $equipments = Equipment::all();
        return view('equipments.states.create', ['equipments' => $equipments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatesTextRequest $request)
    {
        // Validates the form data according to SensorsRequest rules
        $validatedData = $request->validated();

        StateText::create($validatedData);

        return redirect('/dashboard/equipments/states')->with('success', 'O state foi adicionado com sucesso!');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state = StateText::findOrFail($id);
        $equipments = Equipment::all();

        return view('equipments.states.edit', ['state' => $state, 'equipments' => $equipments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StatesTextRequest $request, $id)
    {
        // Validates the form data according to StatesTextRequest rules
        $validatedData = $request->validated();

        // Updates data
        StateText::whereId($id)->update($validatedData);

        return redirect('/dashboard/equipments/states')->with('success', 'O estado foi atualizado com sucesso!');
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
        $action = StateText::findOrFail($id);

        // Deletes the record from the database
        $action->delete();

        return redirect('/dashboard/equipments/states')->with('success', 'O estado foi eliminado com sucesso!');
    }
}
