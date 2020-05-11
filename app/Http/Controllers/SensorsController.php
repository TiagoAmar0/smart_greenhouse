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
        $sensors = Sensor::all();
        return view('sensors.index', ['sensors' => $sensors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sensors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SensorsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SensorsRequest $request)
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
        Sensor::create($validatedData);

        return redirect('/dashboard/sensors')->with('success', 'O sensor foi adicionado com sucesso!');
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

        // Try to get the image from file input
        $image = $request->file('image');

        if(!$image){
            // If image input was not set, assings the value of the previous image path
            $path = $request->image_value;
        } else {
            // If image input was set, upload the new image to storage/uploads folder
            $path = $this->uploadImage($image, $request->name);

            // Delete the previous image
            Storage::disk('public')->delete(str_replace('/uploads/', '', $request->image_value));
        }

        // Changes the data to later store only the image path and unset array element that contained the previous image url
        $validatedData['image'] = $path;
        unset($validatedData['image_value']);

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

        //Deletes the image linked to sensor of upload folder
        Storage::disk('public')->delete(str_replace('/uploads/', '', $sensor->image));

        // Deletes the record from the database
        $sensor->delete();

        return redirect('/dashboard/sensors')->with('success', 'O sensor foi eliminado com sucesso!');
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
}
