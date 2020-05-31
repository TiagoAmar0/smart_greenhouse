<?php

namespace App\Http\Controllers;

use App\Model\Equipment;
use App\Model\History;
use Illuminate\Http\Request;

class AtuatorsController extends Controller
{

    // Receives a equipment id (from a lamp) and a value and updates lamp
    public function changeLampStatus($id, $value){

        // Get equipment informations
        $lamp = Equipment::findOrFail($id);

        // If state doesn't change, just return with information
        if($lamp->value == $value){
            return redirect('/dashboard')->with('warning', 'A lâmpada já estava'. ($value == 0 ? 'desligada' : ($value == 1 ? 'acesa (mínimo)' : 'acesa (máximo)')) .'!');
        }

        // Update dequipment value
        $lamp->update(['value' => $value]);

        // Add new entry to equipment history
        $history = new History();
        $history->value = $lamp->value;
        $lamp->histories()->save($history);

        return redirect('/dashboard')->with('success', 'Estado da lâmpada alterado com sucesso!');
    }
}
