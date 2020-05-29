<?php

namespace App\Http\Controllers;

use App\Model\Equipment;
use Illuminate\Http\Request;

class AtuatorsController extends Controller
{
    public function changeLampStatus($id, $value){
        $lamp = Equipment::findOrFail($id);

        if($lamp->value == $value){
            return redirect('/dashboard')->with('warning', 'A lâmpada já estava'. ($value == 0 ? 'desligada' : ($value == 1 ? 'acesa (mínimo)' : 'acesa (máximo)')) .'!');
        }

        $lamp->update(['value' => $value]);
        return redirect('/dashboard')->with('success', 'Estado da lâmpada alterado com sucesso!');
    }
}
