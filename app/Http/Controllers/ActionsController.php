<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Equipment;
use Illuminate\Http\Request;
use App\Http\Requests\ActionsRequest;
use App\Model\Action;
use App\Model\Sensor;

class ActionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetches all records along the information of the linked sensor
        $actions = Action::with('equipment')->get();

        return view('equipments.actions.index', ['actions' => $actions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Retrieve all equipments
        $equipments = Equipment::all();

        return view('equipments.actions.create', ['equipments' => $equipments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActionsRequest $request)
    {
        // Validates the form data according to SensorsRequest rules
        $validatedData = $request->validated();

        // Saves the record in the database
        Action::create($validatedData);

        return redirect('/dashboard/equipments/actions')->with('success', 'A ação foi adicionada com sucesso!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Retrieve all equipments
        $equipments = Equipment::all();

        // Retrieve action to edit data
        $action = Action::findOrFail($id);

        return view('equipments.actions.edit', ['equipments' => $equipments, 'action' => $action]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActionsRequest $request, $id)
    {
        // Validates the form data according to SensorActionsRequest rules
        $validatedData = $request->validated();

        // Updates data
        Action::whereId($id)->update($validatedData);

        return redirect('/dashboard/equipments/actions')->with('success', 'A ação foi atualizada com sucesso!');
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
        $action = Action::findOrFail($id);

        // Deletes the record from the database
        $action->delete();

        return redirect('/dashboard/equipments/actions')->with('success', 'A ação foi eliminada com sucesso!');
    }
}
