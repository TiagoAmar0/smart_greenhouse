<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentsRequest;
use App\Model\Actuator;
use App\Model\Equipment;
use App\Model\Sensor;
use App\Model\Thing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EquipmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipments = Equipment::all();

        return view('equipments.index', ['equipments' => $equipments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('equipments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EquipmentsRequest $request)
    {
        // Validates the form data according to SensorsRequest rules
        $validatedData = $request->validated();

        // Retrieves image
        $image = $request->file('image');

        // Upload image to storage/uploads folder
        $path = $this->uploadImage($image, $request->name);

        // Change data to only store the image path in database
        $validatedData['image'] = $path;

        // Saves the record in the database
        $equipment = new Equipment();
        $equipment->name = $validatedData['name'];
        $equipment->image = $validatedData['image'];
        $equipment->type = $validatedData['type'];
        $equipment->save();

        // Saves Record and subtable data
        $this->addEquipmentToSubTable($validatedData['type'], $equipment);

        return redirect('/dashboard/equipments')->with('success', 'O sensor foi adicionado com sucesso!');
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
        $equipment = Equipment::findOrFail($id);
        return view('equipments.edit', ['equipment' => $equipment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EquipmentsRequest $request, $id)
    {
        // Validates the form data according to SensorsRequest rules
        $validatedData = $request->validated();

        // Get data from old record to later check if type changed
        $equipment_old = Equipment::findOrFail($id);

        // Try to get the image from file input
        $image = $request->file('image');

        if(!$image){
            // If image input was not set, assings the value of the previous image path
            $path = $request->image_value;
        } else {
            // If image input was set, upload the new image to storage/uploads folder
            $path = $this->uploadImage($image, $request->name);

            // Delete the previous image
            if($path != $request->image_value){
                Storage::disk('public')->delete(str_replace('/uploads/', '', $request->image_value));
            }
        }

        // Changes the data to later store only the image path and unset array element that contained the previous image url
        $validatedData['image'] = $path;
        unset($validatedData['image_value']);

        // Updates data
        $equipment_new = Equipment::findOrFail($id);
        $equipment_new->update($validatedData);

        // If the type changed, it needs to delete a record from old type table and create a record in new type table
        if($equipment_old->type != $validatedData['type']){
            $this->deleteEquipmentFromSubTable($id, $equipment_old->type);
            $this->addEquipmentToSubTable($validatedData['type'], $equipment_new);
        }

        return redirect('/dashboard/equipments')->with('success', 'O sensor foi atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    /**
     * Uploads an image to storage/uploads folder
     * Returns the path of the uploaded image
     *
     * @param $image
     * @param $name
     * @return string
     */
    private function uploadImage($image, $name){
        $extension = $image->getClientOriginalExtension();
        $new_filename = $name . '.'. $extension;
        Storage::disk('public')->put($new_filename, File::get($image));
        $path = '/uploads/' . $new_filename;

        return $path;
    }

    private function addEquipmentToSubTable($type, $equipment){
        switch ($type){
            case '1':
                $sensor = new Sensor();
                $equipment->sensor()->save($sensor);
                break;
            case '2':
                $actuator = new Actuator();
                $equipment->actuator()->save($actuator);
                break;
            case '3':
                $thing = new Thing();
                $equipment->thing()->save($thing);
                break;
        }
    }

    private function deleteEquipmentFromSubTable($equipment_id, $type){
        switch ($type){
            case '1':
                Sensor::where('equipment_id', $equipment_id)->first()->delete();
                break;
            case '2':
                Actuator::where('equipment_id', $equipment_id)->first()->delete();
                break;
            case '3':
                Thing::where('equipment_id', $equipment_id)->first()->delete();
                break;
        }
    }

}
